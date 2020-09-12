<?php

namespace Contratos;

use \App;
use DB;
/**
 * ProdutosController
 *
 * @category	Visionnaire_Contratos
 * @package	Visionnaire
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @author-co Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
Class ProdutosController extends \BaseController
{

	private static $DEBUG_DATA			= 0;	// para ativar a depuração.
	
	/**
	 * Endpoint inicial para integração de Configuração dos Produtos.
	 *
	 * @return null
	 */
	public function indexConfiguracao()
	{
		$this->processaConfiguracao();
	}
	
	/**
	 * Endpoint inicial para integração de Produtos.
	 *
	 * @return null
	 */
	public function index()
	{
		$this->processaCatalogo();
	}
	
	/**
	 * Função para sincronizar os dados do integrador com o magento através de um SKU
	 *
	 * @param string $produtoSKU sku do produto a ser sincronizado.
	 * @return null
	 */
	public function processaSku($produtoSKU = null){
		$this->processaCatalogo(null, $produtoSKU);
	}
	
	////////////////////////////////////////////////////////////////////
	///////////              INTEGRAÇÃO                     ///////////
	///////////////////////////////////////////////////////////////////
	/**
	 * Função para sincronizar os dados do integrador com o magento.
	 *
	 * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
	 * @param string $produtoSKU sku do produto a ser sincronizado.
	 * @return null
	 */
	public function processaCatalogo($iSoapCall=null, $produtoSKU=null){
		$erro 	= false;
		$inicio = date('d/m/Y H:i:s');
		$tempo  = time();
		$this->_retorno['endpoint'] = "processaCatalogo";
		
		if($iSoapCall == null){
			$iSoap 		= new \IntegradorSoapClient();
		}else{
			$iSoap 		= $iSoapCall;
		}
		
	
		if($produtoSKU == null){
			$produtos = \SGE\SyncProduto::where('KitECommerce', '=', 'N')->get();
		}else{
			$produtos = \SGE\SyncProduto::where('SKU', '=', $produto)->where('KitECommerce', '=', 'N')->get();
		}
		
		$client 	= $iSoap->getClient();
		$session 	= $iSoap->getSession();
		//$functions = $client->__getFunctions ();
		//var_dump ($functions);
		$i = 0;
		if($produtos){
			
			foreach($produtos as $p){
				$status = 2;	// é o product disabled no Magento.
				$p->SKU = trim($p->SKU);
				$i++;
					$complexFilter = array(
							'complex_filter' => array(
									array(
											'key' => 'sku',
											'value' => array('key' => '=', 'value' => $p->SKU)
									)
							)
					);
					/*
					 * Qualificação das regras.
					 */
					/*
					 *  Regra: Considerar sempre a coluna DescricaoEcommerce para lançamento do nome do produto, porém se estiver em branco, considerar a coluna Descri��o;
					 */
					$descricao = utf8_encode($p->DescricaoEcommerce);
					if($p->DescricaoEcommerce == ""){
						$descricao = utf8_encode($p->Descricao);
					}
					//Regra: Inserir os campos Nível, Série e Bimestre como atributos do produto, se as informações vierem nulas não definir tais atributos;
					$additionalAttrs['single_data'][] = array('key' => 'sge_nivel'		, 'value' => $p->Nivel);
					$additionalAttrs['single_data'][] = array('key' => 'sge_serie'		, 'value' => $p->Serie);
					$additionalAttrs['single_data'][] = array('key' => 'sge_bimestre'	, 'value' => $p->Bimestre);
					// Regra: Durante a leitura da coluna DataExpiracao, se a data já for excedida, inativar o produto na plataforma;
					$dataExpiracao = $p->DataExpiracao;
					if($dataExpiracao != ""){
						$_dataExpiracao 	= explode("-",$dataExpiracao);
						$timestamp_expira 	= mktime("23","59","59",$_dataExpiracao[1],substr($_dataExpiracao[2],0,2), $_dataExpiracao[0]);
						$timestamp_now		= time();
						if($timestamp_now < $timestamp_expira){
							$status = 1;
						}
					}
					// Montamos aqui o array de atributos para aproveitar o espaço de regras.
					$atributos = array( 'description' => $descricao, 'short_description' => $descricao, 'tax_class_id' => 0,
							'weight' => $p->PesoLiquido, 'price' => $p->PrecoTabela, 'status' => $status, 'name' => $descricao, 'additional_attributes' => $additionalAttrs);
					
					/**
					 * Regra: Caso o campo PercentualDesconto não seja vazio o campo PrecoFinal corresponderá ao campo Product special price no magento
					 */
					if($p->PercentualDesconto > 0){
						$atributos['special_price']	= $p->PrecoFinal;
					}
					
					$product_type = 'simple';
						
					/*
					 * Fim Qualificação das regras.
					 */
					$additionalAttrs = null;
					if(ProdutosController::$DEBUG_DATA){
						print "Consultando: ". $p->SKU ."\r\n";
					}
					//$product = $client->catalogProductList($session, $complexFilter);
					
					$product_id = "".$p->SKU;
					//'status' => 2 //disabled.
					if(ProdutosController::$DEBUG_DATA){
						print "{$p->SKU} - {$descricao} - {$p->PesoLiquido} - {$p->PrecoTabela} - {$status} - {$p->Nivel} - {$p->Serie} - {$p->Bimestre}\r\n";
					}
					try {
						//if($product){
							if(ProdutosController::$DEBUG_DATA){
								print "Atualizando: ". $p->SKU ."\r\n";
							}
							$result = $client->catalogProductUpdate($session, $product_id, $atributos, null, 'sku');
						//}else{
							
						//}
					}catch(Exception $e){
						
						
					}
					if($result != '1'){
						//$this->_retorno['message'] .= $e->getMessage ();
						//$erro = 1;
						if(ProdutosController::$DEBUG_DATA){
							print "Cadastrando: ". $p->SKU ."\r\n";
						}
						// get attribute set
						$attributeSets = $client->catalogProductAttributeSetList($session);
						$attributeSet = current($attributeSets);
						$result = $client->catalogProductCreate($session, $product_type, $attributeSet->set_id, $p->SKU, $atributos);
					}
					
					if(isset($result->faultstring) && $result->faultstring != ""){
						if(ProdutosController::$DEBUG_DATA){
							print  "Falha ao atualizar o SKU: {$p->SKU}. Mensagem: ".$result->faultstring ."\r\n ";
						}
					}
				
				/* Otimização.
				 * if($i%2000 == 0){
					$client->endSession($session);
					$iSoap 		= new \IntegradorSoapClient();
					$client 	= $iSoap->getClient();
					$session 	= $iSoap->getSession();
				}*/
				if($i%10 == 0 && ProdutosController::$DEBUG_DATA){
					$tempo_decorrido = time() - $tempo;
					ob_flush();
					if(ProdutosController::$DEBUG_DATA){
						print "Atualizados: {$i}. {$tempo_decorrido} s\r\n;";
					}
					
				}
				
			}
		}
		$fim = date('d/m/Y H:i:s');
		$tempo_decorrido = time() - $tempo;
		if(!$erro){
			$this->_retorno['message']                      = "Ok";
			$this->_retorno['data']							= array("status" => "Atualizados: {$i}. {$inicio} -> {$fim}. Tempo decorrido (s): {$tempo_decorrido}");
		}else{
			$this->_retorno['message']                      = 'Importação com erros.';
		}
		
		$this->_retorno['success']                      = true;
		$this->_retorno['code']                 		= ($erro) ? 404 : 200;
		
		if($iSoapCall == null){
			$client->endSession($session);
			$this->retornoJson();
		}
		
	}

	/**
	 * Função para sincronizar os dados das configurações de cada produto..
	 *
	 * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
	 * @return null
	 */
	public function processaConfiguracao($iSoapCall=null){
			$erro 	= false;
			$inicio = date('d/m/Y H:i:s');
			$tempo  = time();
			$this->_retorno['endpoint'] = "processaConfiguração";
			
			$_dados = null;
			if($iSoapCall == null){
				$iSoap 		= new \IntegradorSoapClient();
			}else{
				$iSoap 		= $iSoapCall;
			}
		
			$configuracao = \DB::table('sge_estoque')
			->join('sge_contrato_produtos', 'sge_contrato_produtos.sku', '=', 'sge_estoque.SKU')
			->join('sge_contrato', 'sge_contrato.id', '=', 'sge_contrato_produtos.contrato_id')
			->select('sge_estoque.SKU','sge_estoque.estoque_disponivel','sge_estoque.expedido_por', 'sge_contrato_produtos.kit', 'sge_contrato_produtos.data_expiracao', 'sge_contrato.data_inicio_vigencia', 'sge_contrato.data_fim_vigencia'
					, 'sge_contrato.parcela_minima', 'sge_contrato.desconto_boleto', 'sge_contrato.SLABoleto', 'sge_contrato.cliente_id','sge_contrato.nome_cliente','sge_contrato.tipo_venda_id', 'sge_contrato.expedido_por')
			->get();
			
			$client 	= $iSoap->getClient();
			$session 	= $iSoap->getSession();
			//$functions = $client->__getFunctions ();
			//var_dump ($functions);
			// Limpamos a tabela primeiro.
			$result = $client->produtosProdutoLimparFlags( $session );
			$i = 0;
			if($configuracao){
					
				foreach($configuracao as $c){
					/*
					 * model:
					 * array('escola_id' => 12, 'sku' => '99.99', 'expedido_por'=> 99, 'disponivel_kit'=> 1, 'disponivel_front' => 0, 'qtd_disponivel' => 99);
					 */
					$linha = array('escola_id' => $c->cliente_id, 'sku' => $c->SKU, 'expedido_por'=> $c->expedido_por, 'disponivel_kit'=> 0, 
							'disponivel_front' => 1, 'qtd_disponivel' => $c->estoque_disponivel,
							'nome_cliente' => $c->nome_cliente,'tipo_venda_id' => $c->tipo_venda_id,
					);
					$linha['disponivel_kit'] = 0;
					$linha['disponivel_front'] = 0;
					/**
					 * Tratamento de Regras.
					 */
					// Regra: Durante a leitura da coluna DataExpiracao, se a data já for excedida, inativar o produto na plataforma;
					$dataFimVigencia = $c->data_fim_vigencia;
					if($dataFimVigencia != ""){
						$_dataFimVigencia 	= explode("-",$dataFimVigencia);
						$timestamp_expira 	= mktime("23","59","59",$_dataFimVigencia[1],substr($_dataFimVigencia[2],0,2), $_dataFimVigencia[0]);
						$timestamp_now		= time();
						if($timestamp_now > $timestamp_fim){
							$linha['disponivel_kit'] = 0;
							$linha['disponivel_front'] = 1;
						}else{
							
						}
					}
					$_dados[] = $linha;
					if(ProdutosController::$DEBUG_DATA){
						print "Processando: {$linha['escola_id']} -{$linha['nome_cliente']} - {$linha['sku']} - {$linha['expedido_por']} - {$linha['disponivel_kit']} - {$linha['disponivel_front']} - {$linha['qtd_disponivel']} - {$linha['estoque_disponivel']}\r\n";
					}
					if($i % 10 == 0 && $i>0){
						$data = json_encode($_dados);
						$result = $client->produtosProdutoInserirFlags( $session,  $data);
						$data = null;
						$_dados = null;
					}
					$i++;
				}
			}
			
			if($_dados != null){
				// buffer.
				$data = json_encode($_dados);
				$result = $client->produtosProdutoInserirFlags( $session,  $data);
			}
			// Comando para reindexar os produtos no magento.
			$result = $client->produtosProdutoReindexar ( $session );
		
			$fim = date('d/m/Y H:i:s');
			$tempo_decorrido = time() - $tempo;
			if(!$erro){
				$this->_retorno['message']                      = "Ok";
				$this->_retorno['data']							= array("status" => "Atualizados: {$i}. {$inicio} -> {$fim}. Tempo decorrido (s): {$tempo_decorrido}");
			}else{
				$this->_retorno['message']                      = 'Importação com erros.';
			}
			
			$this->_retorno['success']                      = true;
			$this->_retorno['code']                 		= ($erro) ? 404 : 200;
			
			if($iSoapCall == null){
				$client->endSession($session);
				$this->retornoJson();
			}
	}
	
	/**
	 * Função para sincronizar os dados de Kits dos Produtos.
	 *
	 * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
	 * @return null
	 */
	public function processaKits($iSoapCall=null){
		$erro 	= false;
		$inicio = date('d/m/Y H:i:s');
		$tempo  = time();
		$this->_retorno['endpoint'] = "processaKits";
		
		if($iSoapCall == null){
			$iSoap 		= new \IntegradorSoapClient();
		}else{
			$iSoap 		= $iSoapCall;
		}
		$produtos = \DB::connection('sge')->table('SyncProduto')
		->join('SyncContratoProduto', 'SyncProduto.SKU', '=', 'SyncContratoProduto.Kit')
		->join('SyncContrato', 'SyncContrato.Chave', '=', 'SyncContratoProduto.Contrato')
		->where("SyncProduto.KitECommerce", '=', 'S')
		->select('SyncContratoProduto.Kit','SyncContratoProduto.SKU','SyncContrato.Cliente','SyncContrato.NomeCliente',
				'SyncProduto.DataExpiracao','SyncProduto.Descricao','SyncProduto.DescricaoEcommerce','SyncContratoProduto.PrecoFinal')
				->orderBy("SyncContratoProduto.Kit", "ASC")
				->orderBy("SyncContrato.Cliente", "ASC")
				->orderBy("SyncContratoProduto.SKU", "ASC")
				->get();
		$client 	= $iSoap->getClient();
		$session 	= $iSoap->getSession();
		$i 			= 0;
		$_kit 		= null;
		if($produtos){
			$produto_kit 	= 0;
			$original_SKU 	= "";
			$cliente		= 0;
			foreach($produtos as $p){
				$status = 2;	// é o product disabled no Magento.
				$i++;
				/*
				 * Qualificação das regras.
				 */
				/*
				 *  Regra: Considerar sempre a coluna DescricaoEcommerce para lançamento do nome do produto, porém se estiver em branco, considerar a coluna Descri��o;
				 */
				$descricao = utf8_encode($p->DescricaoEcommerce);
				if($p->DescricaoEcommerce == ""){
					$descricao = utf8_encode($p->Descricao);
				}
				
				// Regra: Durante a leitura da coluna DataExpiracao, se a data já for excedida, inativar o produto na plataforma;
				$dataExpiracao = $p->DataExpiracao;
				if($dataExpiracao != ""){
					$_dataExpiracao 	= explode("-",$dataExpiracao);
					$timestamp_expira 	= mktime("23","59","59",$_dataExpiracao[1],substr($_dataExpiracao[2],0,2), $_dataExpiracao[0]);
					$timestamp_now		= time();
					if($timestamp_now < $timestamp_expira){
						$status = 1;
					}
				}
				// Montamos aqui o array de atributos para aproveitar o espaço de regras.
				$atributos = array( 'description' => $descricao, 'short_description' => $descricao,
						'price' => $p->PrecoTabela, 'status' => $status, 'name' => $descricao);
				
				$product_type = 'bundle';
				/*
				 * Fim Qualificação das regras.
				 */
				
				$_kit['store_id'] 			= $p->NomeCliente;//"Varejo"// Aqui tem que ser o nome da Store!
				$_kit['product_id'] 		= $productId;
				if($cliente != 0 && $p->Cliente != $cliente){
					// O foreach acima termina de cadastrar um kit. Embaixo vamos relacionar os produtos do kit
					$_kit['items'][] = array(
							'required'  	=> 1,
							'option_id' 	=> '',
							'position'  	=> 0,
							'type'      	=> 'checkbox', //Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX,
							'title'     	=> "Kit ". $kitConsulta,
							'default_title' => "Kit ". $kitConsulta,
							'delete'    	=> '',
					);
					
					$dados = json_encode($_kit);
					$result = $client->produtosProdutoInserirKit( $session, $dados );
					$_kit = null;
				}
				$kitConsulta = $p->Kit. ".". sprintf("%04d",$p->Cliente);
				// vamos buscar para ver se o Kit não existe
				$complexFilter = array(
						'complex_filter' => array(
								array(
										'key' => 'sku',
										'value' => array('key' => '=', 'value' => $kitConsulta)
								)
						)
				);
				if(ProdutosController::$DEBUG_DATA){
					print "Consultando: ". $kitConsulta ."\r\n";
				}
				$product = $client->catalogProductList($session, $complexFilter);
					
				if($product){
					if(ProdutosController::$DEBUG_DATA){
						print "Atualizando: ". $kitConsulta ."\r\n";
					}
					$productId = $product[0]->product_id;
					//$result = $client->catalogProductUpdate($session, $product_id, $atributos, null, 'sku');
				}else{
					$attributeSets = $client->catalogProductAttributeSetList($session);
					$attributeSet = current($attributeSets);
					$result = $client->catalogProductCreate($session, $product_type, $attributeSet->set_id, $kitConsulta, $atributos);
					$productId = $result;
				}
				
				// vamos buscar para ver se o produto que vamos cadastrar no kit existe
				$complexFilterKit = array(
						'complex_filter' => array(
								array(
										'key' => 'sku',
										'value' => array('key' => '=', 'value' => $p->SKU)
								)
						)
				);
				if(ProdutosController::$DEBUG_DATA){
					print "Consultando produto do kit: ". $p->SKU ."\r\n";
				}
				$productKit = $client->catalogProductList($session, $complexFilterKit);
				if($productKit){
					$_kit['dados'][]= array(
							'product_id'                => $productKit[0]->product_id,
							'selection_qty'             => 1,
							'selection_can_change_qty'  => 1,
							'position'                  => 0,
							'is_default'				=> 1,
							'selection_id'             	=> '',
							'selection_price_type'     	=> 0,
							'selection_price_value'    	=> $p->PrecoFinal,
							'option_id'                	=> '',
							'delete'                   	=> '',
					);
				}
				
				
				$cliente = $p->Cliente;
			}	
			if($_kit != null){
				// O foreach acima termina de cadastrar um kit. Embaixo vamos relacionar os produtos do kit
				$_kit['items'][] = array(
						'required'  	=> 1,
						'option_id' 	=> '',
						'position'  	=> 0,
						'type'      	=> 'checkbox', //Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX,
						'title'     	=> "Kit ". $kitConsulta,
						'default_title' => "Kit ". $kitConsulta,
						'delete'    	=> '',
				);
				$dados = json_encode($_kit);
				$result = $client->produtosProdutoInserirKit( $session, $dados );
				$_kit = null;
			}
		}
		$fim = date('d/m/Y H:i:s');
		$tempo_decorrido = time() - $tempo;
		if(!$erro){
			$this->_retorno['message']                      = "Ok";
			$this->_retorno['data']							= array("status" => "Atualizados: {$i}. {$inicio} -> {$fim}. Tempo decorrido (s): {$tempo_decorrido}");
		}else{
			$this->_retorno['message']                      = 'Importação com erros.';
		}
	
		$this->_retorno['success']                      = true;
		$this->_retorno['code']                 		= ($erro) ? 404 : 200;
	
		if($iSoapCall == null){
			$client->endSession($session);
			$this->retornoJson();
		}
	
	}
	
	/**
	 * Função para sincronizar os dados de produtos coligados.
	 *
	 * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
	 * @return null
	 */
	public function processaColigados($iSoapCall=null){
		$erro 	= false;
		$inicio = date('d/m/Y H:i:s');
		$tempo  = time();
		$this->_retorno['endpoint'] = "processaColigados";
		
		if($iSoapCall == null){
			$iSoap 		= new \IntegradorSoapClient();
		}else{
			$iSoap 		= $iSoapCall;
		}
		$client 	= $iSoap->getClient();
		$session 	= $iSoap->getSession();
		
		$produtos = \DB::connection('sge')->table('SyncProduto')
		->whereRaw("SyncProduto.SKU != SyncProduto.ProdutoGerencial")
		->select('SyncProduto.SKU','SyncProduto.ProdutoGerencial')
				->orderBy("SyncProduto.SKU", "ASC")
				->get();
		
		$i 			= 0;
		$_kit 		= null;
		if($produtos){
			foreach($produtos as $p){
				$status = 2;	// é o product disabled no Magento.
				$i++;
				$complexFilter = array(
						'complex_filter' => array(
								array(
										'key' => 'sku',
										'value' => array('key' => '=', 'value' => $p->ProdutoGerencial)
								)
						)
				);
				if(ProdutosController::$DEBUG_DATA){
					print "Consultando: ". $p->ProdutoGerencial ."\r\n";
				}
				$product = $client->catalogProductList($session, $complexFilter);
					
				if($product){
					if(ProdutosController::$DEBUG_DATA){
						print "Coligando: ". $p->SKU ." em ". $p->ProdutoGerencial ."\r\n";
					}
					$result = $client->catalogProductLinkAssign($session, 'related', $p->ProdutoGerencial, $p->SKU, null, 'sku');
				}

			}
		}
		$fim = date('d/m/Y H:i:s');
		$tempo_decorrido = time() - $tempo;
		if(!$erro){
			$this->_retorno['message']                      = "Ok";
			$this->_retorno['data']							= array("status" => "Atualizados: {$i}. {$inicio} -> {$fim}. Tempo decorrido (s): {$tempo_decorrido}");
		}else{
			$this->_retorno['message']                      = 'Importação com erros.';
		}

		$this->_retorno['success']                      = true;
		$this->_retorno['code']                 		= ($erro) ? 404 : 200;

		if($iSoapCall == null){
			$client->endSession($session);
			$this->retornoJson();
		}
	
	}
	

}
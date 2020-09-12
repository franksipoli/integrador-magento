<?php

namespace Contratos;

use \App;

/**
 * EstoqueController
 *
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @author-co Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
Class EstoqueController extends \BaseController
{
	private static $DEBUG_DATA			= 0;	// para ativar a depuração.

	/**
	 * Endpoint inicial para integração de Produtos.
	 *
	 * @return null
	 */
	public function index()
	{
		$this->processaEstoque();
	}
	
	/**
	 * Função para sincronizar os dados do integrador com o magento.
	 *
	 * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
	 * @return null
	 */
	public function processaEstoque($iSoapCall=null){
		$erro 	= false;
		$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	$this->_retorno['endpoint'] = "processaEstoque";
		if($iSoapCall == null){
			$iSoap 		= new \IntegradorSoapClient();
		}else{
			$iSoap 		= $iSoapCall;
		}
		$client 	= $iSoap->getClient();
		$session 	= $iSoap->getSession();
		//var_dump ($functions);
		$estoque = \SGE\SyncEstoque::all();
		$i = 0;
		if($estoque){
			
			foreach($estoque as $e){
				// v2 call
				$i++;
				try {
					$complexFilter = array(
							'complex_filter' => array(
									array(
											'key' => 'sku',
											'value' => array('key' => '=', 'value' => $e->SKU)
									)
							)
					);
					/*
					 * Qualificação das regras.
					 */
					/*
					 * Fim Qualificação das regras.
					 */
					if(EstoqueController::$DEBUG_DATA){
						print "Consultando: ". $e->SKU ."\r\n";
					}
					$product = $client->catalogProductList($session, $complexFilter);
					if($product){
						if(EstoqueController::$DEBUG_DATA){
							print "Atualizando: ". $e->SKU ."\r\n";
						}
						$result = $client->catalogInventoryStockItemUpdate($session, $e->SKU, array('identifierType' => 'SKU', 'qty' => $e->EstoqueDisponivel));
						if(EstoqueController::$DEBUG_DATA){
							print "produto {$e->SKU} atualizado.\r\n";
						}
					}
					if($i%2000 == 0){
						$client->endSession($session);
						$iSoap 		= new \IntegradorSoapClient();
						$client 	= $iSoap->getClient();
						$session 	= $iSoap->getSession();
					}
					if($i%100 == 0 && EstoqueController::$DEBUG_DATA){
						$tempo_decorrido = time() - $tempo;
						print "Atualizados: {$i}. {$tempo_decorrido} s\r\n;";
						ob_flush();
					}
					
					
				} catch ( Exception $e ) {
					$this->_retorno['message'] .= $e->getMessage ();
					$erro = 1;
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
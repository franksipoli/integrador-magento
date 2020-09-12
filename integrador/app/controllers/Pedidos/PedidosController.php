<?php

namespace Pedidos;

use \App;

/**
 * PedidosController
 *
 * @author Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
Class PedidosController extends \BaseController
{

	private static $DEBUG_DATA			= 0;	// para ativar a depuração.
	private static $DIAS_ANTES			= 20;	// dias antes para filtrar a data da última alteração.
	
	/**
	 * Método principal para sincronização dos dados de pedidos entre o SGE e o Integrador.
	 * Nessa rotina faz-se a verificação do andamento dos pedidos no SGE e envia a atualização
	 * ao Magento, devendo este sinalizar ao usuário quando um pedido é alterado.
	 * @return json
	 */
    public function index()
    {
    	return $this->processaPedidos();
    }
    
    /**
     * Método para sincronização de dados de Remessas.
     * @return json
     */
    public function indexPedidoRemessas()
    {
    	return $this->processaPedidosRemessas();
    }
    
    ////////////////////////////////////////////////////////////////////
    ///////////              INTEGRAÇÃO                     ///////////
    ///////////////////////////////////////////////////////////////////
    /**
     * - Processa os pedidos simples buscando seus status na base de dados do SGE e integrando ao magento.
     * - Processa os pedidos de remessas, atribuindo ao comentário quais envios estão sendo feito e quais produtos.
     * Status possíveis: pending, processing, completed
     * @param unknown $iSoapCall
     */
    public function processaPedidos($iSoapCall=null){
    	
    	$erro 	= false;
    	$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	$_dados = null;
    	$descricao = null;
    	if($iSoapCall == null){
    		$iSoap 		= new \IntegradorSoapClient();
    	}else{
    		$iSoap 		= $iSoapCall;
    	}
    	$client 		= $iSoap->getClient();
    	$session 		= $iSoap->getSession();
    	$horaAnterior	= time() - (PedidosController::$DIAS_ANTES * 24 * 60 * 60);	// Dias antes para validar a ultima alteração.
    	$pedidos		= \SGE\SyncPedidos::whereRaw("DataUltAlteracao > '". date("Y-m-d", $horaAnterior) ." 00:00:00'")->get();
    	$i=0;
    	//print_r($pedidos->toArray());
    	if($pedidos){
	    	foreach($pedidos as $p){
	    		$processado = false;
	    		$descricao = $p['DescricaoEDI'] .". ";
	    		if($p['CodigoRastreamento'] != ""){
	    			$descricao .= " C&oacute;digo de Rastreamento: ". $p['CodigoRastreamento'];
	    		}
	    		$descricao = utf8_encode($descricao);
	    		if(PedidosController::$DEBUG_DATA){
	    			print "Processando: {$p['PedidoMagento']} - {$p['Status']} - {$descricao}. ";
	    		}
    			$result = $client->salesOrderInfo($session, $p['PedidoMagento']);
    			//print_r($result);
    			if($result->faultstring != ""){
    				$_dados['log'][$i] = "Erro ao processar o pedido {$p['PedidoMagento']}. ". $result->faultstring;
    				//print $_dados['log'][$i];
    			}else{
    				
    				if(isset($result->status) && $result->status != $p['Status']){
    					// Atualizamos o status do pedido.
    					$result = $client->salesOrderAddComment($session, $p['PedidoMagento'], $p['Status'], $descricao, 1);
    					$processado = true;
    				}
    			}
    			if($processado == false){
    				$string = "Não Processado: {$p['PedidoMagento']} - {$p['Status']}. ";
    				$_dados['log'][$i] = $string;
    			}
    			$i++;
    			print "\r\n";
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
		if($_dados!= null){ $this->_retorno['data']['log'] = $_dados['log'];}
		
		$this->_retorno['success']                      = true;
		$this->_retorno['code']                 		= ($erro) ? 404 : 200;
		
		if($iSoapCall == null){
			$client->endSession($session);
			return $this->retornoJson($this->_retorno);
		}
    	return json_encode($this->_retorno);
    	 
    }
    
}
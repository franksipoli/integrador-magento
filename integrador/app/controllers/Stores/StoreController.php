<?php

namespace Stores;

use Models\Integrador;

/**
 * Controle das Stores
 *
 * @category	Visionnaire
 * @package	Visionnaire
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @author-co Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
Class StoreController extends \BaseController
{

	/**
	 * Método principal para resgate dos dados de Stores ordenado por id.
	 * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
	 * @return null
	 */
    public function index()
    {
    	//if(Sentry::check()){
   			$entity = \Integrador\Store::orderBy("store_id","ASC")->get();
           
            if($entity){
            	$this->_retorno['message']                      = 'Ok';
            	$this->_retorno['data']							= $entity;
            }else{
            	$this->_retorno['message']                      = 'Registro nao encontrado';
            }
    		
    		$this->_retorno['success']                      = true;
    		$this->_retorno['code']                 		= is_null($entity) ? 404 : 200;
    	//}
    	$this->retornoJson();
    	
    }
    
    /**
     * Resgata as stores a serem cadastradas automaticamente no sistema.
     * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
     * @return null
     */
    public function integraStores(){
    	//if(Sentry::check()){
    		$entityFinal = null;
	    	$entity = \Integrador\ContratoStores::all()->toArray();
	    	if(is_array($entity)){
	    		$i = 0;
	    		foreach($entity as $e){
	    			$entityFinal[$i]['view']['name'] 			= $e['url_loja_escola'];
	    			$entityFinal[$i]['view']['code'] 			= $e['code'];
	    			$entityFinal[$i]['website'] 				= $e['website'];
	    			$entityFinal[$i]['website']['nome_magento'] = $e['store']['name'];
	    			$i++;
	    		}
	    	}
	    	
	    	if($entity){
	    		$entity = $entityFinal;
	    		$this->_retorno['message']                      = 'Ok';
	    		$this->_retorno['data']							= $entityFinal;
	    	}else{
	    		$this->_retorno['message']                      = 'Registro nao encontrado';
	    	}
	    	
	    	$this->_retorno['success']                      = true;
	    	$this->_retorno['code']                 		= is_null($entity) ? 404 : 200;
    	//}
    	$this->retornoJson();
    }
    
    
    ////////////////////////////////////////////////////////////////////
    ///////////              INTEGRAÇÃO                     ///////////
    ///////////////////////////////////////////////////////////////////
    /**
     * Processa os dados de store e armazena na tabela sge_stores.
     * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
     * @return null
     */
    public function processaStores($log = null){
    	try{
    		\Integrador\Store::truncate();
    		//$stores = DB::table('sge_contrato')->selectRaw("distinct(expedido_por)")->get();
    		$stores = \DB::table('sge_contrato')
    		->selectRaw("distinct(expedido_por), sge_localidade_expedicao.descricao")
    		->join('sge_localidade_expedicao', 'sge_localidade_expedicao.id', '=', 'sge_contrato.expedido_por')
			->get();
    		if($stores){
    			foreach($stores as $s){
    				$nStore = \Integrador\Store::firstOrCreate(array("store_id" => $s->expedido_por , "nome" => $s->descricao,"nome_magento" => $s->descricao));
    			}
    		}	
    	}catch (Exception $e){
    		return $e->getMessage();
    	}
    	return null;
    }
    
    /**
     * Faz as chamadas das APIs do Magento para poder gerar os dados de catálogo e configuração de Sites dentro do Magento.
     * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
     * @return null
     */
    public function processaCatalogoStores($iSoapCall=null){
    	$erro 	= false;
    	$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	$this->_retorno['endpoint'] = "processaCatalogoStores";
    	if($iSoapCall == null){
    		$iSoap 		= new \IntegradorSoapClient();
    	}else{
    		$iSoap 		= $iSoapCall;
    	}
    	$client 	= $iSoap->getClient();
    	$session 	= $iSoap->getSession();
    	$result = $client->utilidadesWebsiteCadastrar ( $session );
		$result = $client->utilidadesWebsiteCadastrarCatalogo ( $session );
		
		
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
			
		}
		return $this->retornoJson();
    }
    
    /**
     * Processa os dados de logins de cada store e envia para o Magento.
     * Aqui também é processado as urls para cada Store, gerando as lojas a serem acessadas no sistema.
     * @param object $iSoapCall objeto do tipo IntegradorSoapClient. Normalmente virá setado quando estiver sendo chamado de outra integração.
     * @return null
     */
    public function processaStoreLogins($iSoapCall=null){
    	$erro 	= false;
    	$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	
    	$this->_retorno['endpoint'] = "processaStoreLogins";
    	if($iSoapCall == null){
    		$iSoap 		= new \IntegradorSoapClient();
    	}else{
    		$iSoap 		= $iSoapCall;
    	}
    	$client 		= $iSoap->getClient();
    	$session 		= $iSoap->getSession();
    	$i = 0;
    	$logins = \Integrador\Contrato::all();
    	
    	if($logins){
    		foreach($logins as $l){
    			if($l->cnpj == "" || $l->cnpj == null){ continue; }
    			$userData = array(
    					'username'  => $l->cnpj,
    					'firstname' => $l->nome_cliente,
    					'lastname'  => $l->url_loja_escola,
    					'email'     => $l->cnpj,
    					'password'  => $l->senha_padrao,
    					'is_active' => 1
    			);
    			$timestamp_fim = $timestamp_now = $timestamp_inicio  = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
    			
    			if($l->data_inicio_vigencia != ""){
    				$_data_inicio = explode(" ", $l->data_inicio_vigencia);
    				$timestamp_inicio  	= mktime(0,0,1, $_data_inicio[1],$_data_inicio[2], $_data_inicio[0]);
    			}else{
    				
    			}
    			if($l->data_fim_vigencia != ""){
    				$_data_fim 	= explode(" ", $l->data_fim_vigencia);
    				$timestamp_fim  	= mktime(23,59,59, $_data_fim[1],$_data_fim[2], $_data_fim[0]);
    			}
    			if($timestamp_now > $timestamp_fim){
    				// Rotina para remover.
    			}
    			$result = $client->utilidadesUtilidadeCadastrarUsuario( $session, $userData );
    			$_dados['view_code'] 	= $l->cliente_id;
    			
    			// vamos tratar aqui a url da escola para poder enviar ao Magento. Pois a url tem que ter uma barra no final.
    			$barrafinal = substr($l->url_loja_escola, -1);	// pega o último caracter.
    			if($barrafinal != "/"){
    				$l->url_loja_escola .= "/";
    			} 
    			// vamos tratar aqui se a url tem http:// no começo também.
    			$httpcomeco = preg_match("/^((http[s]?|ftp):\/)?\/?/", $l->url_loja_escola);
    			if(!$httpcomeco){
    				$l->url_loja_escola = "https://".$l->url_loja_escola;
    			}
    			$_dados['store_url'] 	= $l->url_loja_escola;
    			$result = $client->utilidadesUtilidadecadastrarUrlStore( $session, $_dados);
    			$i++;
    			$userData = null;
    		}
    	}
    	
    	$result = $client->utilidadesWebsiteGerarSiteIndex ( $session );
    	$result = $client->utilidadesWebsiteGerarSiteIndex ( $session );
    	
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
    	}
    	return $this->retornoJson();
    }
    
}

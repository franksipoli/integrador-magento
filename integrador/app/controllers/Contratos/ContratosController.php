<?php

namespace Contratos;

use \App;

Class ContratosController extends \BaseController
{

    public function index($contrato_id=0, $contrato_completo=0, $cliente_id = 0 )
    {
    	//if(Sentry::check()){
    		if($contrato_completo == 1){
    			$query = \Integrador\Contrato::with(array('formaPagamento', 'tipoVenda', 'vigenciaParcelamento', 'produtos', 'remessas'));
    		}else{
    			$query = \Integrador\Contrato::with(array('formaPagamento', 'tipoVenda', 'vigenciaParcelamento', 'remessas'));
    		}
    		$query->where(function($query) use ($cliente_id, $contrato_id){
	    			if($cliente_id > 0){
	    				$query->where("cliente_id", "=", $cliente_id);
	    			}
	    			if($contrato_id > 0){
	    				$query->where("id", "=", $contrato_id);
	    			}
            })->orderBy("cliente_id","ASC");
            if($cliente_id >0 || $contrato_id > 0){
            	$entity = $query->get()->first();
            }else{
            	$entity = $query->get();
            }
            
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
    
    public function escola($cliente_id=0, $contrato_completo=0){
    	
    	$this->index(0, $contrato_completo,$cliente_id);
    }
    
}
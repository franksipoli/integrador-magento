<?php

namespace Contratos;

use \App;

/**
 * FreteController
 *
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @copyright 2016 Editora Positivo
 */
Class FreteController extends \BaseController
{

	/**
	 * Método principal para buscar os dados do frete entre o Integrador e o
	 * SIP.
	 * @return json
	 */
    public function index()
    {
	   
            
        if($entity){
          	$this->_retorno['message']                      = 'Ok';
          	$this->_retorno['data']							= $entity;
        }else{
           	$this->_retorno['message']                      = 'Registro nao encontrado';
        }
    		
    	$this->_retorno['success']                      = true;
    	$this->_retorno['code']                 		= is_null($entity) ? 404 : 200;
    	$this->retornoJson();
    	 
    }
    
    
    
}
<?php

namespace Integrador;

use \App;
use \Menu;
use \Route;
use \Contratos;

/**
 * Controle das rotas para o Integrador.
 *
 * @category	Visionnaire_Integrador
 * @package	Visionnaire
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @author-co Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
class Initialize extends \SlimStarter\Module\Initializer{

    public function getModuleName(){
    	return 'Integrador';
    }

    public function getModuleAccessor(){
    	return 'integrador';
    }

    /*
     * As rotas do webservice.
    */
    public function registerPublicRoute(){

    	
        /* Contratos */
        Route::group(
        '/contratos',
        function(){
                Route::get('/'                                  		, 'Contratos\ContratosController:index');                            		// GET /contratos
                Route::get('/escola/:cliente_id(/:contrato_completo)'   , 'Contratos\ContratosController:escola');                             		// GET /contratos/:id
                Route::get('/estoque'                           		, 'Contratos\EstoqueController:index');	                            		// GET /estoque
                Route::get('/produtos'                           		, 'Contratos\ProdutosController:index');	                           		// GET /produtos
                Route::get('/configuracao'                         		, 'Contratos\ProdutosController:indexConfiguracao');	                    // GET /configuracao
                Route::get('/produtoskit'                           	, 'Contratos\ProdutosController:processaKits');	                           	// GET /produtoskit
                Route::get('/produtoscoligados'                        	, 'Contratos\ProdutosController:processaColigados');	                    // GET /produtoscoligados
                Route::get('/adminLogin'                         		, 'Contratos\StoreAdminLoginController:processaStoresLoginAdmin');	        // GET /adminLogin
                Route::get('/produtos/:sku'                           	, 'Contratos\ProdutosController:processaSku');	                           	// GET /produtos/2000.1945
                Route::get('/:contrato_id(/:contrato_completo)'         , 'Contratos\ContratosController:index');                             		// GET /contratos/:id

                
                /*Route::post('/'                                 , 'Contratos\ContratosController:index:store');                           		// POST /contratos 
                Route::get('/edit/:id'                  		, 'Contratos\ContratosController:index:edit');                             			// GET /contratos/:id/edit
                Route::put('/:id'                               , 'Contratos\ContratosController:index:update');                           			// PUT /contratos/:id
                Route::delete('/:id'                    		, 'Contratos\ContratosController:index:destroy');                          			// DELETE /contratos/:id 
                */
        });
        
        /* Comissao */
        Route::group(
        		'/comissao',
        		function(){
        			Route::get('/'                                  	, 'Comissao\ComissaoController:index');                            				// GET /comissao
                    Route::post('/'                                     , 'Comissao\ComissaoController:index');                                         // GET /comissao
        			Route::get('/baixas'                               	, 'Comissao\ComissaoController:indexBaixas');                      				// GET /comissao/baixas
        			Route::get('/previsao'                             	, 'Comissao\ComissaoController:indexPrevisaoBaixa');                      		// GET /comissao/baixas
                    Route::post('/baixas'                                , 'Comissao\ComissaoController:indexBaixas');                                  // POST /comissao/baixas
                    Route::post('/previsao'                              , 'Comissao\ComissaoController:indexPrevisaoBaixa');                           // POST /comissao/previsaobaixa
        
        		});
        
        /* Frete */
        Route::group(
        		'/frete',
        		function(){
        			Route::get('/'                                  	, 'Frete\FreteController:index');                            				// GET /frete
        
        		});
        
        /* Logs */
        Route::group(
        		'/integrador_log',
        		function(){
        			Route::get('/'                                  	, 'LoggerController:index');                            					// GET /integrador_log
        			Route::post('/'                                  	, 'LoggerController:indexPost');                           					// POST /integrador_log
        		});
        

        
        /* Pedidos */
        Route::group(
        		'/pedidos',
        		function(){
        			Route::get('/'                                  	, 'Pedidos\PedidosController:index');                         				// GET /pedidos
        			
        		});

        /* Stores */
        Route::group(
        		'/stores',
        		function(){
        			Route::get('/'                                  	, 'Stores\StoreController:index');                            				// GET /stores
        			Route::get('/integraStores'                     	, 'Stores\StoreController:integraStores');                      			// GET /stores/integraStores
        			Route::get('/processaStores'                    	, 'Stores\StoreController:processaStores');                     			// GET /stores/processaStores
        			Route::get('/processaStoresCatalogo'            	, 'Stores\StoreController:processaCatalogoStores');             			// GET /stores/processaStoresCatalogo
        			Route::get('/processaStoreLogins'            		, 'Stores\StoreController:processaStoreLogins');                			// GET /stores/processaStoreLogins
              
        		});

        /** rotas de integracao */
        Route::get('/politica_desconto', 'PoliticaDescontoController:index');
        Route::get('/massa', 'MassaController:index');																								// GET /massa
        
        /** Rotas do "Integrador do SGE", fazendo um bypass */
        Route::get('/massasge', 'MassaSGEController:index');																						// GET /massasge
        
        /** Rotas do "Integrador com Soap", fazendo um bypass */
        Route::get('/massasoap', 'MassaSoapController:index');																						// GET /massasoap

    }
}
        
?>
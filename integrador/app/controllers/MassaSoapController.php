	<?php

use Models\SGE;
use Models\Integrador;

/**
 * MassaSoapController
 *
 * @author Frank Sipoli
 * @copyright 2016 Editora Positivo
 */

Class MassaSoapController extends BaseController
{
	private $logger = null;
	private $iSoap  = null;
	
    public function index()
    {
    	$this->logger = new \LoggerController();
    	$this->logger->header("Integracao da Massa Soap SGE");
    	
    	$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	print "Início da integração: {$inicio}";

    	ob_flush ();
    	
    	// Início das integrações sequenciais entre o Integrador e o Magento
    	$this->iSoap 		= new \IntegradorSoapClient();
    	$this->processaStores();	
    	$this->processaCatalogo();
    	$this->processaConfiguracao();
    	$this->iSoap->endSession($session);
    	
    	$fim = date('d/m/Y H:i:s');
    	$tempo_decorrido = time() - $tempo;
    	$fimString = "Fim da integracao: {$inicio} - {$fim}. Tempo decorrido em segundos: ".$tempo_decorrido ."\r\n";
    	print $fimString;
    	print $this->logger->getHistorico();
    	$this->logger->end($fimString);
    	
    	
    }
    
    /**
     * Etapa 1 - Faz a integração das Stores entre o Integrador e o Magento. 
     */
    private function processaStores(){
    	$stores = new \Stores\StoreController();
    	$mensagem = $stores->processaStores();
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Stores";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Stores Ok");
    	}
    }
    
    /**
     * Etapa 2 - Processa os dados de catálogo e produtos das lojas.
     * Observar as regras no item 3.1.1  Regras de Importação do documento De/Para
     * Rodrigo - 28/07/2016
     */
    private function processaCatalogo(){
    	$produtos = new \Contratos\ProdutosController();
    	$mensagem = $produtos->processaCatalogo($this->iSoap);
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Processa Catalogo";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Catalogo Ok");
    	}
    }
    
    /**
     * Etapa 3 Processa os dados de configuração dos produtos
     * Rodrigo - 28/07/2016
     */
    private function processaConfiguracao(){
    	$produtos = new \Contratos\ProdutosController();
    	$mensagem = $produtos->processaConfiguracao($this->iSoap);
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Processa Configuração";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Configuração Ok");
    	}
    }
    
    private function logError($titulo="Erro", $mensagem="mensagem padrao"){
    	$logError = new \LoggerController();
    	$logError->error($titulo, $mensagem);
    	$logError = null;
    }
}

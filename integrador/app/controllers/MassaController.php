<?php

use Models\SGE;
use Models\Integrador;

/**
 * MassaController
 *
 * @author Rodrigo 
 * @copyright 2016 Editora Positivo
 */
Class MassaController extends BaseController
{
	private $logger = null;
	private $iSoap  = null;
	private $registrosDepuracao = 1;
	private $flagDepuracao 		= 0;		// Indica se vamos trabalhar no modo bulk ou controlado para ver erros.
	
	/**
	 * Método principal sincronização dos dados entre o SGE e o Integrador.
	 * Cada sincronização gera um log que depois é armazenado no banco de dados para
	 * visualização na área administrativa do Magento.
	 * @return null
	 */
    public function index()
    {
    	$this->logger = new \LoggerController();
    	$this->logger->header("Integracao da Massa de dados SGE");
    	$this->logger->setFormatted(true);
    	
    	$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	$mensagemInicio = "Início da integração: {$inicio}";
    	$this->logger->header($mensagemInicio);
    	
    	$this->logger->header("Limpando as tabelas");
    	$this->cleanFirst();
    	$this->logger->header("Fim da limpeza.");

    	try{
	    	// Integração de Contrato Tipo de Venda
	    	$dados = \SGE\SyncTipoVendaIntegrador::get()->toArray();
	    	\Integrador\TipoVenda::insert($dados);
	    	$this->logger->lineAdd("Contrato Tipo Venda adicionados: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contrato Tipo Venda\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	try{
    		$dados = null;
    		$dados = \SGE\SyncContratoIntegrador::get()->toArray();
	    	// Integração de Contratos
	    	if($this->flagDepuracao){
	    		$skip = 0;
	    		$qtde = $this->registrosDepuracao;
	    		for($i=0;$i<count($dados);$i++){
	    			$dadosd = \SGE\SyncContratoIntegrador::skip($skip)->take($qtde)->get()->toArray();
	    			foreach($dados as $key => $data){
	    				$data['url_loja_escola'] = \Utils\UtilsController::validaUrlStores($data['url_loja_escola']);
	    				$dadosd[$key] = $data;
	    			}
	    			
	    			\Integrador\Contrato::insert($dadosd);
	    			$skip +=$this->registrosDepuracao;
	    		}
	    	}else{
	    		foreach($dados as $key => $data){
	    			$data['url_loja_escola'] = \Utils\UtilsController::validaUrlStores($data['url_loja_escola']);
	    			$dados[$key] = $data;
	    		}
	    		\Integrador\Contrato::insert($dados);
	    	}
	    	
	    	$this->logger->lineAdd("Contratos adicionados: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contratos\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	try{
	    	// Integração de Contrato Formas de Pagamentos
	    	$dados = \SGE\SyncContratoFormaPagamentoIntegrador::get()->toArray();
	    	\Integrador\ContratoFormaPagamento::insert($dados);
	    	$this->logger->lineAdd("Contrato Forma de Pagamento adicionados: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contrato Forma de Pagamento\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	ob_flush ();
    	try{
    		ini_set("max_execution_time", 300);
	    	// Integração de Contrato Produtos
    		$skip = 0;
	    	$qtde = $this->registrosDepuracao;
	    	for($i=1;$i<=3000;$i++){
	    		$dados = \SGE\SyncContratoProdutosIntegrador::skip($skip)->take($qtde)->get()->toArray();
	    		if(!$dados){break;}
	    		\Integrador\ContratoProdutos::insert($dados);
	    		$skip +=$this->registrosDepuracao;
	    	}
	    	$this->logger->lineAdd("Contrato Produtos adicionados: ". $skip);
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contrato Produtos\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	
    	/* Remessas não disponíveis
    	try{
	    	// Integração de Contrato Remessas
	    	$dados = \SGE\SyncRemessasIntegrador::get()->toArray();
	    	\Integrador\Remessas::insert($dados);
	    	$this->logger->lineAdd("Contrato Remessas adicionados: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contrato Remessas\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	*/
    	
    	try{
	    	// Integração de Vigencia Parcelas
	    	$dados = \SGE\SyncVigenciaParcelamentoIntegrador::get()->toArray();
	    	\Integrador\VigenciaParcelamento::insert($dados);
	    	$this->logger->lineAdd("Contrato Vigencia Parcelamento adicionados: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contrato Vigencia Parcelamento\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	
    	try{
	    	// Integração de Estoque
	    	$dados 	= \SGE\SyncEstoqueIntegrador::get()->toArray();
	    	$_dados = null;
	    	$skip = 0;
	    	$qtde = 1000;
	    	// Integração de Estoque
	    	for($i=0;$i<count($dados);$i++){
	    		$_dados[] = $dados[$i];
	    		
	    		if($skip%$qtde == 0){
	    			\Integrador\Estoque::insert($_dados);
	    			$_dados = null;
	    		}
	    		$skip +=1000;
	    	}
	    	
	    	$this->logger->lineAdd("Contrato Estoque adicionados: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Contrato Estoque\r\n";
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	
    	try{
    		// Integração de Contrato Produtos
    		$dados = \SGE\SyncProdutoKitIntegrador::get()->toArray();
    		\Integrador\ProdutosKit::insert($dados);
    		$this->logger->lineAdd("Kit de Produtos adicionados: ". count($dados));
    		//\Integrador\ProdutosKit::where("sku_kit","=", 0)->delete();
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Kit de Produtos";
    		$this->logger->lineAdd($mensagemTitulo);
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	
    	try{
    		// Integração de Localidades
    		$dados = \SGE\SyncLocalidadeExpedicaoIntegrador::get()->toArray();
    		\Integrador\LocalidadeExpedicao::insert($dados);
    		$this->logger->lineAdd("Localidades de expedição adicionadas: ". count($dados));
    	}catch ( Exception $e ){
    		$mensagemTitulo = "Erro - Localidades Expedição";
    		$this->logger->lineAdd($mensagemTitulo);
    		print $mensagemTitulo . $e->getMessage() ."\r\n";
    		$this->logError($mensagemTitulo, $e->getMessage());
    	}
    	ob_flush ();
    	
    	// Início das integrações sequenciais entre o Integrador e o Magento
    	$this->iSoap 		= new \IntegradorSoapClient();
    	$this->processaStores();	
    	$this->processaCatalogo();
    	$this->processaStoresCatalogo();
    	$this->processaStoreLogins();
    	$this->processaConfiguracao();
    	$this->iSoap->endSession($session);
    	
    	$fim = date('d/m/Y H:i:s');
    	$tempo_decorrido = time() - $tempo;
    	$fimString = "Fim da integracao: {$inicio} - {$fim}. Tempo decorrido em segundos: ".$tempo_decorrido ."\r\n";
    	$this->logger->end($fimString);
    	print $this->logger->getHistorico();
    	$this->logger->limparHistorico();
    	
    	
    }
    
    /**
     * Funcao responsavel por cadastrar um website usando nome e codigo fornecidos pelo contrato
     *
     * @return null
     */    
    private function cleanFirst(){
    	\Integrador\VigenciaParcelamento::where("id",">", 0)->delete();
    	\Integrador\Remessas::where("id",">", 0)->delete();
    	\Integrador\ContratoProdutos::where("id",">", 0)->delete();
    	\Integrador\ContratoFormaPagamento::where("id",">","0")->delete();
    	\Integrador\Contrato::where("id",">", "0")->delete();
    	\Integrador\TipoVenda::where("id",">", 0)->delete();
    	\Integrador\Estoque::where("id",">", 0)->delete();
    	\Integrador\ProdutosKit::where("id",">", 0)->delete();
    	\Integrador\LocalidadeExpedicao::truncate();

    	/*\Integrador\SyncContratoProdutos::where("Chave_Contrato",">","0")->delete();
    	\Integrador\SyncVigenciaParcelamento::where("Chave_Contrato",">","0")->delete();
    	\Integrador\SyncRemessas::where("Chave_Contrato",">","0")->delete();
    	\Integrador\SyncProduto::where("SKU","!=","''")->delete();
    	*/

    }
    
    /**
     * Etapa 1 - Faz a integração das Stores entre o Integrador e o Magento. 
     * Faz a integração das Stores entre o Integrador e o Magento.
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
     * Segundo ciclo de importação dos dados das Stores.
     */
    private function processaStoresCatalogo(){
    	$stores = new \Stores\StoreController();
    	$mensagem = $stores->processaCatalogoStores($this->iSoap);
    	 
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Catalogo Stores";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Catalogo Stores Ok");
    	}
    	 
    }
    
    /**
     * Terceiro ciclo de importação dos dados das Stores.
     */
    private function processaStoreLogins(){
    	$stores = new \Stores\StoreController();
    	$mensagem = $stores->processaStoreLogins($this->iSoap);
    
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Login e Urls Stores";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Login e Urls Stores Ok");
    	}
    
    }
    
    /**
     * Etapa 2 - Processa os dados de catálogo, kits, coligados e produtos das lojas.
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
    	
    	$mensagem = $produtos->processaConfiguracao($this->iSoap);
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Processa Configuração";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Configuração Ok");
    	}
    	
    	$mensagem = $produtos->processaKits($this->iSoap);
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Processa Kits";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Kits Ok");
    	}
    	
    	$mensagem = $produtos->processaColigados($this->iSoap);
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Processa Coligados";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Coligados Ok");
    	}
    	
    	$produtos = new \Contratos\EstoqueController();
    	$mensagem = $produtos->processaEstoque($this->iSoap);
    	if($mensagem != null ){
    		$mensagemTitulo = "Erro - Processa Estoque";
    		$this->logger->lineAdd($mensagemTitulo);
    		$this->logError($mensagemTitulo, $mensagem);
    	}else{
    		$this->logger->lineAdd("Processa Estoque Ok");
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

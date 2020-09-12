<?php

Class LoggerController extends BaseController
{
	private $stringHeader 		= "";
	private $stringHistorico 	= "";
	private $stringFooter 		= "";
    private $formatted			= false;	// Formata do lado da mensagem os ----
	private $MENSAGEM_ERROR		= "erro";	// Mensagem do tipo erro.
	
	
	public function index(){
		$limite_padrao = 20;
		//if(Sentry::check()){
			$input = Input::get();
			
			
			/** in case request come from post http form */
			$input = (is_null($input) || empty($input)) ? Input::post() : $input;
				
			if(isset($input['limit'])){
				$limite_padrao = ($input['limit'] == "" || $input['limit']<=0)?$limite_padrao:$input['limit'];
			}
			$entity = \IntegradorLog::orderBy("data_log","DESC")->take($limite_padrao)->get();
			 
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
	
	public function indexPost(){
		$this->index();	// Atalho.
	}
	
	
	/**
	 * Função para gravar no log
	 *
	 * @param string $mensagem a mensagem a ser gravada.
	 * @param string $eventType tipo de eventos que podemos gravar no log.
	 * @return null
	 */
    public function log($mensagem = "",$eventType='geral'){
    	$dados = array('mensagem' => $mensagem, 'evento' => $eventType);
    	\IntegradorLog::insert($dados);
    }
    
    /**
     * Função para gerar o header do log.
     *
     * @param string $titulo o título do log
 	 * @return string $stringHeader string do header criado.
     */
    public function header($titulo = ""){
    	$this->stringHeader = "---------------------------------------------------------------\r\n".
      					      "----". str_pad($titulo, 55, " ", STR_PAD_BOTH) 			."----\r\n".   
      					      "---------------------------------------------------------------\r\n";
    	$this->stringHistorico .= $this->stringHeader;
    	return $this->stringHeader;
    }
    
    /**
     * Função para gerar o footer do log.
     *
     * @param string $mensagem a mensagem do footer
     * @return string $stringHeader string do header criado.
     */
    public function footer($mensagem=""){
    	$this->stringFooter = $mensagem;
    	$this->stringFooter .= "---------------------------------------------------------------\r\n"	;
    	$this->stringHistorico .= $this->stringFooter;
    	return $this->stringFooter;
    }
    
    public function lineAdd($dados){
    	if($this->formatted == true){
    		$dados = "----". str_pad($dados, 55, " ", STR_PAD_BOTH) 			."----\r\n";
    	}
    	$this->stringHistorico .= $dados;
    }
    
    public function end($mensagem =""){
    	$this->footer($mensagem);
    	$this->log($this->stringHistorico);
    	
    }
    
    public function limparHistorico(){
    	$this->stringHistorico = "";
    }
    
    public function error($titulo = "", $mensagem =""){
    	$this->header($titulo);
    	$this->stringHistorico .= $mensagem;
    	$this->log($this->stringHistorico, $this->MENSAGEM_ERROR);
    }
    
    public function getHistorico(){
    	return $this->stringHistorico;
    }
    
    public function setFormatted($bool = false){
    	$this->formatted = $bool;
    }
}

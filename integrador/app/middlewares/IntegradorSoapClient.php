<?php

Class IntegradorSoapClient
{

	public $session = null;
	public $client  = null;
	private $soap_config = null;
	
	private $arquivoWsdl = '/tmp/wsdl_integradorf.wsdl';
	public function __construct(){
		//configuração no servidor
		ini_set("soap.wsdl_cache_enabled", 0);
		$this->app 		= Slim\Slim::getInstance();
		$this->soap_config 	= $this->app->config('soap');
		$this->validaArquivoWsdl();
		for($tentativa=0;$tentativa<2; $tentativa++){
			if($tentariva > 0){
				print "Reiniciando a conexão.";
			}
			try {
				$this->client = new \SoapClient ("file://". $this->arquivoWsdl, array (
						'trace' => 1,
						'version' => SOAP_1_2,
						'cache_wsdl' => WSDL_CACHE_NONE,
						'location' => $this->soap_config['servidor'],
						'keep_alive' => 1,
						"exceptions" => false,
						"connection_timeout" => 15,
						'encoding'=>'UTF-8',
						'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP 
				) );
				break;
			} catch ( Exception $e ) {
				echo $e->getMessage ();
			}	
			
		}
		
		
		//$functions = $this->client->__getFunctions ();
		//var_dump ($functions);
		$this->session = $this->client->login($this->soap_config['login'], $this->soap_config['senha']);
		
	}
	
	public function getClient(){
		return $this->client;
	}
	
	public function getSession(){
		return $this->session;
	}
	
	public function endSession(){
		$this->client->endSession($this->session);
	}
	
	private function validaArquivoWsdl(){
		if(!is_file( $this->arquivoWsdl)){
			$wsdl = file_get_contents($this->soap_config['servidor'] .'?wsdl=1');
			file_put_contents( $this->arquivoWsdl, $wsdl);
		}
	}
	
}

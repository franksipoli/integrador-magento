<?php
use Models\SGE;
/**
 * MassaSGEController
 *
 * @author Rodrigo 
 * @copyright 2016 Editora Positivo
 */
Class MassaSGEController extends BaseController
{

	//private $_clientes = array(array('id' => '1', 'nome' => "Abelhilha Feliz", 'login' => 'abelha_1', 'senha' => 'abelha_1'),array('id' => '2', 'nome' => "Raposa Feliz", 'login' => 'raposa_1', 'senha' => 'raposa_1'),array('id' => '3', 'nome' => "Urso Feliz", 'login' => 'urso_1', 'senha' => 'urso_1'));
	private $_contratos = array(
			array('Chave' => '1', 'Cliente' => 1, 'NomeCliente' => 'Visionnaire', 'CNPJ' => 'vision', 'SenhaPadrao' => 'visionnaire', 'TipoVenda' => 2,
					'DataIniVig' => '2016-07-01 00:00:00', 'DataFimVig' => '2017-09-01 23:59:59',	'SitContrato' => 2,
					'FaturadoPor' => 2, 'ExpedidoPor' => 1, 'ParcelaMinima' => 50.00, 'PercDescontoBoleto' => 5, 'DataAlteracao' => '2016-07-27',
					'SLABoleto' => 10, 'ContratoOriginal' => null, 'ClienteEntrega' => 5, 'TipoEnderecoEntrega' => 3, 'URLLojaNaEscola' => 'ecommerce.visionnaire.com.br' ),
			array('Chave' => '2', 'Cliente' => 2, 'NomeCliente' => 'Visionnaire Cliente 2', 'CNPJ' => 'vision2', 'SenhaPadrao' => 'visionnaire', 'TipoVenda' => 2,
					'DataIniVig' => '2016-07-01 00:00:00', 'DataFimVig' => '2017-09-01 23:59:59',	'SitContrato' => 2,
					'FaturadoPor' => 2, 'ExpedidoPor' => 1, 'ParcelaMinima' => 50.00, 'PercDescontoBoleto' => 5, 'DataAlteracao' => '2016-07-27',
					'SLABoleto' => 10, 'ContratoOriginal' => null, 'ClienteEntrega' => 5, 'TipoEnderecoEntrega' => 3, 'URLLojaNaEscola' => 'ecommerce2.visionnaire.com.br' ),
			array('Chave' => '2016000235', 'Cliente' => 5, 'NomeCliente' => 'IESAP', 'CNPJ' => '10227585000130', 'SenhaPadrao' => '23041986', 'TipoVenda' => 2,  
					'DataIniVig' => '2016-07-01 00:00:00', 'DataFimVig' => '2016-09-01 23:59:59',	'SitContrato' => 2,
					'FaturadoPor' => 2, 'ExpedidoPor' => 1, 'ParcelaMinima' => 50.00, 'PercDescontoBoleto' => 5, 'DataAlteracao' => '2016-07-27', 
					'SLABoleto' => 10, 'ContratoOriginal' => null, 'ClienteEntrega' => 5, 'TipoEnderecoEntrega' => 3, 'URLLojaNaEscola' => 'loja.moderno.com.br' ),
			array('Chave' => '2016000237', 'Cliente' => 60, 'NomeCliente' => 'COL. TOTAL', 'CNPJ' => '9334654000207', 'SenhaPadrao' => '26022008', 'TipoVenda' => 3,  
					'DataIniVig' => '2016-07-01 00:00:00', 'DataFimVig' => '2016-09-01 23:59:59',	'SitContrato' => 2,
					'FaturadoPor' => 2, 'ExpedidoPor' => 1, 'ParcelaMinima' => 10.00, 'PercDescontoBoleto' => 5, 'DataAlteracao' => '2016-07-27', 
					'SLABoleto' => 10, 'ContratoOriginal' => null, 'ClienteEntrega' => 60, 'TipoEnderecoEntrega' => 3, 'URLLojaNaEscola' => 'conveniada.editorapositivo.com.br' ),
			array('Chave' => '2016000236', 'Cliente' => 411, 'NomeCliente' => 'EDITORA POSITIVO LTDA', 'CNPJ' => '79719613000729', 'SenhaPadrao' => '05122001', 'TipoVenda' => 4,
					'DataIniVig' => '2016-07-01 00:00:00', 'DataFimVig' => '2016-09-01 23:59:59',	'SitContrato' => 2,
					'FaturadoPor' => 2, 'ExpedidoPor' => 1, 'ParcelaMinima' => 100.00, 'PercDescontoBoleto' => 5, 'DataAlteracao' => '2016-07-27',
					'SLABoleto' => 10, 'ContratoOriginal' => null, 'ClienteEntrega' => 411, 'TipoEnderecoEntrega' => 3, 'URLLojaNaEscola' => 'loja.editorapositivo.com.br' ),
	);
	private $_tipoVenda = array(array('Cod' => '1', 'Descricao' => 'SGE', 'AplicaPoliticaDesconto' => '0', 'CalculaFrete' => 0),
			array('Cod' => '2', 'Descricao' => 'Loja na Escola', 'AplicaPoliticaDesconto' => '0', 'CalculaFrete' => 1),
			array('Cod' => '3', 'Descricao' => 'Pedidos Online', 'AplicaPoliticaDesconto' => '1', 'CalculaFrete' => 0),
			array('Cod' => '4', 'Descricao' => 'Varejo', 'AplicaPoliticaDesconto' => 0, 'CalculaFrete' => 1),
	);
	private $_localidadeExpedicao = array(array('id' => '1', 'Descricao' => 'SGE', 'Cidade' => '0'),
			array('id' => '5', 'Descricao' => 'São Paulo', 'Cidade' => '88412'),
			array('id' => '6', 'Descricao' => 'Recife', 'Cidade' => '51136'),
			array('id' => '7', 'Descricao' => 'PIÁ Curitiba', 'Cidade' => '55298'),
	);
	private $_contratoFormaPagamento = array(array('Contrato' => '2016000235', 'FormaPagto' => 2, 'Descricao' => 'BOLETO BANCÁRIO'),
							array('Contrato' => '2016000235', 'FormaPagto' => 4, 'Descricao' => 'CARTÃO'),
							array('Contrato' => '2016000237', 'FormaPagto' => 2, 'Descricao' => 'BOLETO BANCÁRIO'),
							array('Contrato' => '2016000236', 'FormaPagto' => 2, 'Descricao' => 'BOLETO BANCÁRIO'),
							);
	
	private $_vigenciaParcelamento = array(array('Contrato' => '1', 'NroMaximoParcela' => 3, 'DataLimite' => '2016-09-19'),
			array('Contrato' => '1', 'NroMaximoParcela' => 4, 'DataLimite' => '2016-08-19'),
			array('Contrato' => '2', 'NroMaximoParcela' => 1, 'DataLimite' => '2017-09-19'),
			array('Contrato' => '2', 'NroMaximoParcela' => 2, 'DataLimite' => '2016-10-05'),
			array('Contrato' => '2', 'NroMaximoParcela' => 3, 'DataLimite' => '2016-09-25'),
			array('Contrato' => '2', 'NroMaximoParcela' => 4, 'DataLimite' => '2016-09-19'),
			array('Contrato' => '2016000235', 'NroMaximoParcela' => 10, 'DataLimite' => '2016-09-19'),
			array('Contrato' => '2016000235', 'NroMaximoParcela' => 9, 'DataLimite' => '2016-09-19'),
			array('Contrato' => '2016000235', 'NroMaximoParcela' => 8, 'DataLimite' => '2016-10-19'),
	);
	
	private $_remessas = array(array('Contrato' => '1', 'Bimestre' => 3, 'Corte' => 1, 'DataCorte' => '2016-09-19'),
			array('Contrato' => '1', 'Bimestre' => 2, 'Corte' => 1, 'DataCorte' => '2016-08-19'),
			array('Contrato' => '1', 'Bimestre' => 3, 'Corte' => 1, 'DataCorte' => '2017-09-19'),
			array('Contrato' => '1', 'Bimestre' => 4, 'Corte' => 1, 'DataCorte' => '2016-10-05'),
			array('Contrato' => '2', 'Bimestre' => 1, 'Corte' => 1, 'DataCorte' => '2016-09-25'),
			array('Contrato' => '2', 'Bimestre' => 2, 'Corte' => 1, 'DataCorte' => '2016-09-19'),
	);
	
	private $_contratoProdutos = array(array('Contrato' => '1', 'SKU' => '200058975', 'Descricao' => 'COLEÇÃO MAIS CORES GRUPO 3', 'DescricaoEcommerce' => 'COLEÇÃO MAIS CORES GRUPO 3',
			'Nivel' => 1, 'Serie' => 1, 'Bimestre' => 1, 'Preco' => 136.10, 'PercentualDesconto' => 0.0, 'PrecoFinal' => 136.10, 'KIT' => 0, 'DescricaoKIT' => null, 'Disponivel' => 1
	),
			array('Contrato' => '1', 'SKU' => '2000.5900', 'Descricao' => 'COLEÇÃO MAIS CORES GRUPO 6 - ALFABETIZAÇÃO', 'DescricaoEcommerce' => 'COLEÇÃO MAIS CORES GRUPO 6 - ALFABETIZAÇÃO',
					'Nivel' => 1, 'Serie' => 6, 'Bimestre' => 1, 'Preco' => 148.20, 'PercentualDesconto' => 0.0, 'PrecoFinal' => 148.20, 'KIT' => 0, 'DescricaoKIT' => null, 'Disponivel' => 1
			),
			array('Contrato' => '2', 'SKU' => '2000.5897', 'Descricao' => 'COLEÇÃO MAIS CORES GRUPO 3', 'DescricaoEcommerce' => 'COLEÇÃO MAIS CORES GRUPO 3',
					'Nivel' => 1, 'Serie' => 1, 'Bimestre' => 1, 'Preco' => 136.10, 'PercentualDesconto' => 0.0, 'PrecoFinal' => 136.10, 'KIT' => 0, 'DescricaoKIT' => null, 'Disponivel' => 1
			),
			array('Contrato' => '2', 'SKU' => '2000.5900', 'Descricao' => 'COLEÇÃO MAIS CORES GRUPO 6 - ALFABETIZAÇÃO', 'DescricaoEcommerce' => 'COLEÇÃO MAIS CORES GRUPO 6 - ALFABETIZAÇÃO',
					'Nivel' => 1, 'Serie' => 6, 'Bimestre' => 1, 'Preco' => 148.20, 'PercentualDesconto' => 0.0, 'PrecoFinal' => 148.20, 'KIT' => 0, 'DescricaoKIT' => null, 'Disponivel' => 1
			),
			array('Contrato' => '1', 'SKU' => '2000.2048', 'Descricao' => 'PRODUTO BASE DIEGO', 'DescricaoEcommerce' => 'PRODUTO BASE DIEGO',
					'Nivel' => 2, 'Serie' => 2, 'Bimestre' => 1, 'Preco' => 100.20, 'PercentualDesconto' => 0.0, 'PrecoFinal' => 100.20, 'KIT' => 0, 'DescricaoKIT' => null, 'Disponivel' => 1
			),
	);
	
	private $_produtos = array(array( 'SKU' => '2001.58975', 'DataExpiracao' => '2016-09-01', 'Descricao' => 'COLEÇÃO MAIS CORES GRUPO 3', 'DescricaoEcommerce' => 'COLEÇÃO MAIS CORES GRUPO 3',
			'Nivel' => 1, 'Serie' => 1, 'Bimestre' => 1, 'PesoLiquido' => 1000, 'PrecoTabela' => 136.10
			),
			array( 'SKU' => '2000.59000', 'DataExpiracao' => '2016-08-01', 'Descricao' => 'COLEÇÃO MAIS CORES GRUPO 6 - ALFABETIZAÇÃO', 'DescricaoEcommerce' => 'COLEÇÃO MAIS CORES GRUPO 6 - ALFABETIZAÇÃO',
					'Nivel' => 1, 'Serie' => 6, 'Bimestre' => 1, 'PesoLiquido' => 2000, 'PrecoTabela' => 148.20
			),
	);
	
	private $_estoque = array(array( 'SKU' => '2000.5897', 'EstoqueDisponivel' => 10, 'ExpedidoPor' => 1),
			array( 'SKU' => '2000.5900', 'EstoqueDisponivel' => 20, 'ExpedidoPor' => 1),
			array( 'SKU' => '2000.2048', 'EstoqueDisponivel' => 992, 'ExpedidoPor' => 1),
				
				
	);
	
	public function __construct(){
	
	}
	
	private function cleanFirst(){
		\SGE\SyncLocalidadeExpedicao::where("id",">","0")->delete();
		\SGE\SyncContrato::where("Chave","!=", "null")->delete();
		\SGE\SyncContratoFormaPagamento::where("Contrato",">","0")->delete();
		\SGE\SyncContratoProdutos::where("Contrato",">","0")->delete();
		\SGE\SyncVigenciaParcelamento::where("Contrato",">","0")->delete();
		\SGE\SyncRemessas::where("Contrato",">","0")->delete();
		\SGE\SyncProduto::where("DataHoraAlteracao",">","2016-08-08 15:19:34")->delete();
		\SGE\SyncTipoVenda::where("Chave",">", 0)->delete();
		\SGE\SyncEstoque::where("SKU","!=", "''")->delete();
	}
	
    public function index()
    {
    	$inicio = date('d/m/Y H:i:s');
    	$tempo  = time();
    	print "Início da integração: {$inicio}";
    	$this->cleanFirst();

    	\SGE\SyncLocalidadeExpedicao::insert($this->_localidadeExpedicao);
    	\SGE\SyncTipoVenda::insert($this->_tipoVenda);
    	\SGE\SyncContrato::insert($this->_contratos);
    	\SGE\SyncContratoFormaPagamento::insert($this->_contratoFormaPagamento);
    	\SGE\SyncContratoProdutos::insert($this->_contratoProdutos);
    	\SGE\SyncVigenciaParcelamento::insert($this->_vigenciaParcelamento);
    	\SGE\SyncRemessas::insert($this->_remessas);
    	\SGE\SyncProduto::insert($this->_produtos);
    	\SGE\SyncEstoque::insert($this->_estoque);
    	$this->massaContrato();
    	$fim = date('d/m/Y H:i:s');
    	$tempo_decorrido = time() - $tempo;
    	print "Fim da integração: {$inicio} - {$fim}. Tempo decorrido em segundos: ".$tempo_decorrido ." s";
    	
    	
    }
    
    private function massaContrato(){
    	$_bichos = array('urso','sapo','zebra','cavalo','vaca','tartaruga','tucano','abelha','rinoceronte','hipopotamo', 'papagaio','foca','avestruz','piriquito','leao','onca','tubarao');
    	$_produtos_nome = array('COLEÇÃO','MAIS','CORES','GRUPO','Dicionário','Lápis','Borracha');
    	for($i=6;$i<35;$i++){
    		$bichoNome = $_bichos[rand(0,9)].($i+1);
    		$_clientes = array('id' => $i+1, 'nome' => "{$bichoNome} Feliz", 'login' => "{$bichoNome}_1", 'senha' => '1234');
    		$contratosFinal[] = $_contratos = array('Chave' => $i+1, 'Cliente' => $i+1, 'TipoVenda' => $this->_tipoVenda[rand(0,2)]['Cod'], 'DataIniVig' => "2016-".sprintf("%02d",rand(7,10))."-01 00:00:00", 'DataFimVig' => "2016-".sprintf("%02d",rand(7,10))."-01 23:59:59",	
    				'SitContrato' => rand(0,1),	'FaturadoPor' => 1, 'ExpedidoPor' => rand(1,3), 'ParcelaMinima' => rand(10,60), 'PercDescontoBoleto' => rand(0,1), 
    				'DataAlteracao' => date("Y-m-d"), 'SLABoleto' => 1, 'URLLojaNaEscola' => "www.".$bichoNome."feliz.com.br", "NomeCliente" => $bichoNome."feliz.com.br", "CNPJ" => $bichoNome, "SenhaPadrao" => $bichoNome);
    		//\SGE\SyncCliente::insert($_clientes);
    		\SGE\SyncContrato::insert($_contratos);
    	}
    	for($j=0;$j<300;$j++){
    		$contratosFinal;
    		$descricao = $_produtos_nome[rand(0,count($_produtos_nome)-1)]." {$j} ". $_bichos[rand(0,count($_bichos)-1)];
    		$preco 		= rand(10,300);
    		$sku		= sprintf("%04d",rand(1000,9000)).".".sprintf("%04d",$j);
    		$_contratoProdutos = array('Contrato' => $contratosFinal[rand(0,count($contratosFinal)-10)]['Chave'], 'SKU' => $sku, 'Descricao' => $descricao, 
    		'DescricaoEcommerce' => $descricao, 'Nivel' => rand(1,3), 'Serie' => rand(1,8), 'Bimestre' => rand(1,4), 'Preco' => $preco, 
    		'PercentualDesconto' => 0.0, 'PrecoFinal' => $preco, 'KIT' => 0, 'DescricaoKIT' => null, 'Disponivel' => 1);
    		$_produtos = array( 'SKU' => $sku, 'DataExpiracao' => "2016-".sprintf("%02d",rand(7,10))."-01", 'Descricao' => $descricao, 'DescricaoEcommerce' => $descricao,
    				'Nivel' => rand(1,3), 'Serie' => rand(1,8), 'Bimestre' => rand(1,4), 'PesoLiquido' => rand(300,9000), 'PrecoTabela' => $preco
    		);
    		\SGE\SyncContratoProdutos::insert($_contratoProdutos);
    		
    		\SGE\SyncProduto::insert($_produtos);
    		$_estoque = array( 'SKU' => $sku, 'EstoqueDisponivel' => rand(0,100), 'ExpedidoPor' => rand(1,3));
    		\SGE\SyncEstoque::insert($_estoque);
    	}
    	
    }
    
    
}

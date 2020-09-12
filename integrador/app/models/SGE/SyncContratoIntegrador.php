<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncContratoIntegrador extends SyncContrato {
	
	
	use Eloquence, Mappable;
	protected $maps = [
			'id' => 'Chave',
			'cliente_id' => 'Cliente',
			'tipo_venda_id' => 'TipoVenda',
			'data_alteracao' => 'DataAlteracao',
			'data_inicio_vigencia' => 'DataIniVig',
			'data_fim_vigencia' => 'DataFimVig',
			'situacao_contrato' => 'SitContrato',
			'faturado_por' => 'FaturadoPor',
			'expedido_por' => 'ExpedidoPor',
			'parcela_minima' => 'ParcelaMinima',
			'desconto_boleto' => 'PercDescontoBoleto',
			'url_loja_escola' => 'URLLojaNaEscola',
			'nome_cliente' => 'NomeCliente',
			'cnpj'	=> 'CNPJ',
			'senha_padrao' => 'SenhaPadrao',
			'contrato_original' => 'ContratoOriginal',
			'cliente_entrega' => 'ClienteEntrega',
			'tipo_endereco_entrega' => 'TipoEnderecoEntrega'
			
	];
	protected $appends = [
			'id', 'cliente_id', 'tipo_venda_id', 'data_alteracao',
			'data_inicio_vigencia', 'data_fim_vigencia', 'situacao_contrato', 'faturado_por',
			'expedido_por', 'parcela_minima', 'desconto_boleto', 'url_loja_escola',
			'nome_cliente', 'cnpj', 'senha_padrao', 'contrato_original', 'cliente_entrega', 'tipo_endereco_entrega'
	];
	protected $hidden = [
			'Chave', 'Cliente', 'TipoVenda', 'DataAlteracao',
			'DataIniVig', 'DataFimVig', 'SitContrato', 'FaturadoPor',
			'ExpedidoPor', 'ParcelaMinima', 'PercDescontoBoleto', 'URLLojaNaEscola',
			'NomeCliente', 'CNPJ', 'SenhaPadrao', 'ContratoOriginal','ClienteEntrega','TipoEnderecoEntrega'
	];

}
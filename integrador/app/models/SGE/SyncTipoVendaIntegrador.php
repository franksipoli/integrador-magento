<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncTipoVendaIntegrador extends SyncTipoVenda {
	use Eloquence, Mappable;
	
	protected $maps = [
			'id' => 'Chave',
			'tipo_venda' => 'Descricao',
			'aplica_politica' => 'AplicaPoliticaDesconto',
			'calcula_frete' => 'CalculaFrete',
	];
	protected $appends = [
			'id', 'tipo_venda', 'aplica_politica', 'calcula_frete',
	];
	protected $hidden = [
			'Chave', 'Descricao', 'AplicaPoliticaDesconto', 'CalculaFrete',
	];
	
	
}
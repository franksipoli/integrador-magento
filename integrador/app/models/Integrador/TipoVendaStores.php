<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class TipoVendaStores extends TipoVenda {
	use Eloquence, Mappable;
	protected $maps = [
			'name' => 'tipo_venda'
	];
	protected $appends = [
			'name'
	];
	protected $hidden = [
			'tipo_venda', 'id', 'calcula_frete','aplica_politica'
	];
}
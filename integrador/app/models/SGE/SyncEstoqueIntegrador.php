<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncEstoqueIntegrador extends SyncEstoque {
	
	
	use Eloquence, Mappable;
	protected $maps = [
			'estoque_disponivel' => 'EstoqueDisponivel',
			'expedido_por' => 'ExpedidoPor',
	];
	protected $appends = [
			'estoque_disponivel', 'expedido_por'
	];
	protected $hidden = [
			'EstoqueDisponivel', 'ExpedidoPor'	]
	;

}
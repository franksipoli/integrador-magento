<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncContratoFormaPagamentoIntegrador extends SyncContratoFormaPagamento {
	
	
	use Eloquence, Mappable;
	protected $maps = [
			'codigo_forma_pagamento_id' => 'FormaPagto',
			'contrato_id' => 'Contrato',
	];
	protected $appends = [
			'codigo_forma_pagamento_id', 'contrato_id'
	];
	protected $hidden = [
			'FormaPagto', 'Contrato'
	];

}
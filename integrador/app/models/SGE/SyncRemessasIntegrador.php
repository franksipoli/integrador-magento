<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncRemessasIntegrador extends SyncRemessas {
	
	
	use Eloquence, Mappable;
	protected $maps = [
			'contrato_id' => 'Contrato',
			'data_corte' => 'DataCorte',
	];
	protected $appends = [
			'contrato_id', 'data_corte'
	];
	protected $hidden = [
			'Contrato', 'DataCorte'
	];

}
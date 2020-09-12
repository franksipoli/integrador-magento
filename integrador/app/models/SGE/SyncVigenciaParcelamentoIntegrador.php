<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncVigenciaParcelamentoIntegrador extends SyncVigenciaParcelamento {
	use Eloquence, Mappable;
	
	protected $maps = [
			'contrato_id' => 'Contrato',
			'numero_parcelas' => 'NroMaximoParcela',
			'data_limite' => 'DataLimite',
	];
	protected $appends = [
			'contrato_id', 'numero_parcelas', 'data_limite'
	];
	protected $hidden = [
			'Contrato', 'NroMaximoParcela', 'DataLimite'
	];
	
	
}
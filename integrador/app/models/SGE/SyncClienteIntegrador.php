<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SyncClienteIntegrador extends SyncCliente {
	use Eloquence, Mappable;
	protected $maps = [
			'nome1' => 'nome'
	];
	protected $appends = [
			'nome1'
	];
	protected $hidden = [
			'nome'
	];
	
	public function getMapped(){
		
		return $this;
	}
	
	
}
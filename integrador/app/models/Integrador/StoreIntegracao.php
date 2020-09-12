<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class StoreIntegracao extends Store {
	use Eloquence, Mappable;
	protected $maps = [
			'name' => 'nome',
			'code' => 'store_id'
	];
	protected $appends = [
			'name', 'code'
	];
	protected $hidden = [
			'nome', 'id', 'store_id'
	];
	
}
<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class VigenciaParcelamento extends Model {
	private $id;
	protected $table = 'sge_vigencia_parcelamento';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
}
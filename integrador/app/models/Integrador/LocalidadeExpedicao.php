<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class LocalidadeExpedicao extends Model {
	private $id;
	protected $table = 'sge_localidade_expedicao';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = false;
}
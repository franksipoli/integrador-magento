<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class TipoVenda extends Model {
	private $id;
	protected $table = 'sge_tipo_venda';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
}
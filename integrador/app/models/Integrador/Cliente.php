<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
	private $id;
	protected $table = 'sge_cliente';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
}
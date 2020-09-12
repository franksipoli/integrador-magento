<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model {
	private $id;
	protected $table = 'sge_estoque';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
}
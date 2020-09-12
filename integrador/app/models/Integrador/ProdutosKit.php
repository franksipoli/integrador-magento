<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class ProdutosKit extends Model {
	private $id;
	protected $table = 'sge_produtos_kit';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	

}
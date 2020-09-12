<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class ContratoProdutos extends Model {
	private $id;
	protected $table = 'sge_contrato_produtos';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;

}
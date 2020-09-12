<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class ContratoFormaPagamento extends Model {
	private $id;
	protected $table = 'sge_contrato_forma_pagamento';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
}
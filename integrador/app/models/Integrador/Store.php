<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class Store extends Model {
	private $id;
	protected $table = 'sge_stores';
	protected $primaryKey = "store_id";
	public $timestamps  = false;
	public static $snakeAttributes  = false;
	protected $fillable = array('store_id', 'nome', 'nome_magento');
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncRemessas extends Model {
	private $id;
	protected $table = 'SyncRemessas';
	protected $primaryKey = "Pedido";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
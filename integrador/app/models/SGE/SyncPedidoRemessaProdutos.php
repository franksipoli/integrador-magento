<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncPedidoRemessaProdutos extends Model {
	private $id;
	protected $table = 'SyncPedidoRemessaProdutos';
	protected $primaryKey = "Pedido";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
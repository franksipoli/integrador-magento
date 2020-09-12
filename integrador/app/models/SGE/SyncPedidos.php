<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncPedidos extends Model {
	private $id;
	protected $table = 'SyncPedidos';
	protected $primaryKey = "Pedido";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	protected $with                                 = array('pedidoRemessa');
	
	
	public function pedidoRemessa()
	{
		return $this->hasMany('SGE\SyncPedidoRemessa', 'Pedido', 'Pedido');
	}
}
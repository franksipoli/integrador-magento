<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncPedidoRemessa extends Model {
	private $id;
	protected $table 				= 'SyncPedidoRemessa';
	protected $primaryKey 			= "Pedido";
	protected $connection 			= 'sge';
	public $timestamps  			= false;
	public static $snakeAttributes  = true;
	protected $with                                 = array('remessaProdutos');
	
	public function remessaProdutos()
	{
		return $this->hasMany('SGE\SyncPedidoRemessaProdutos', 'PedidoRemessa', 'PedidoRemessa');
	}

	
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncProduto extends Model {
	private $id;
	protected $table = 'SyncProduto';
	protected $primaryKey = "SKU";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncCliente extends Model {
	private $id;
	protected $table = 'SyncCliente';
	protected $primaryKey = "id";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
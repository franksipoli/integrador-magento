<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncTipoVenda extends Model {
	private $id;
	protected $table = "dbo.SyncTipoVenda";
	protected $primaryKey = "Cod";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
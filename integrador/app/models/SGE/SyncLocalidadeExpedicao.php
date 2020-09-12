<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncLocalidadeExpedicao extends Model {
	private $id;
	protected $table = 'SyncLocalidadeExpedicao';
	protected $primaryKey = "SKU";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
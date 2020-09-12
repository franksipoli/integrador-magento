<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncEstoque extends Model {
	private $id;
	protected $table = 'SyncEstoque';
	protected $primaryKey = "id";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
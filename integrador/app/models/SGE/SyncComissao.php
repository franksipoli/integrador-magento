<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncComissao extends Model {
	private $id;
	protected $table = 'SyncComissao';
	protected $primaryKey = "Escola";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncContrato extends Model {
	private $id;
	protected $table = 'SyncContrato';
	protected $primaryKey = "Chave";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncContratoFormaPagamento extends Model {
	private $id;
	protected $table = 'SyncContratoFormaPagamento';
	protected $primaryKey = "Chave_Contrato";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
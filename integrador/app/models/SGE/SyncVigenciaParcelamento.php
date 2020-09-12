<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncVigenciaParcelamento extends Model {
	private $id;
	protected $table = 'SyncContratoVigenciaParcelamento';
	protected $primaryKey = "Chave_Contrato";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
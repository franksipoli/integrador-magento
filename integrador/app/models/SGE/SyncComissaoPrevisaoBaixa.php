<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncComissaoPrevisaoBaixa extends Model {
	private $id;
	protected $table = 'SyncPrevisaoBaixa';
	protected $primaryKey = "Escola";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncContratoProdutos extends Model {
	private $id;
	protected $table = 'dbo.SyncContratoProduto';
	protected $primaryKey = "Chave_Contrato";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	
}
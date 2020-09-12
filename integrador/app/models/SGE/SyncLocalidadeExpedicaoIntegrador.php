<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Mutable;

class SyncLocalidadeExpedicaoIntegrador extends Model {
	private $id;
	protected $table = 'SyncLocalidadeExpedicao';
	protected $primaryKey = "SKU";
	protected $connection = 'sge';
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	use Eloquence, Mappable, Mutable;
	
	protected $appends = [
			'descricao', 'id', 'cidade_id'
	];
	protected $hidden = [
			'Descricao', 'Cidade', 'Chave'
	];
	
	protected $maps = [
			'descricao' => 'Descricao',
			'id' => 'Chave',
			'cidade_id' => 'Cidade',
	];
	
}
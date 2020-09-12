<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model {
	private $id;
	protected $table = 'sge_contrato';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	protected $with                                 = array('formaPagamento', 'tipoVenda', 'vigenciaParcelamento', 'remessas');
	protected $hidden                               = array('contrato_id');
	
	public function formaPagamento()
	{
		return $this->hasMany('Integrador\ContratoFormaPagamento', 'contrato_id', 'id');
	}
	
	public function tipoVenda()
	{
		return $this->belongsTo('Integrador\TipoVenda', 'tipo_venda_id');
	}
	
	public function vigenciaParcelamento()
	{
		return $this->hasMany('Integrador\VigenciaParcelamento', 'contrato_id', 'id');
	}
	
	public function produtos()
	{
		return $this->hasMany('Integrador\ContratoProdutos', 'contrato_id', 'id');
	}
	
	public function remessas()
	{
		return $this->hasMany('Integrador\Remessas', 'contrato_id', 'id');
	}
	
}
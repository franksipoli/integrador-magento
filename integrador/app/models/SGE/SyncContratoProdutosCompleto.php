<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncContratoProdutosCompleto extends SyncContratoProdutos {

	protected $with                                 = array('contrato');
	
	public function contrato()
	{
		return $this->belongsTo('SGE\SyncContrato', 'Contrato', 'Chave');
	}
	
}
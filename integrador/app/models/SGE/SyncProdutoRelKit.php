<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;

class SyncProdutoRelKit extends SyncProduto {
	
	protected $with                                 = array('skurel');
	
	public function skurel()
	{
		return $this->hasMany('SGE\SyncContratoProdutosCompleto', 'Kit', 'SKU');
	}
	
	
}
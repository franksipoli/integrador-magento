<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Mutable;

class SyncProdutoKitIntegrador extends SyncProduto {
	
	
	use Eloquence, Mappable, Mutable;
	
	protected $appends = [
			'sku_kit', 'sku_produto'
	];
	protected $hidden = [
			'SKU', 'DataExpiracao', 'Descricao', 'DescricaoEcommerce',
			'Nivel', 'Serie', 'Bimestre', 'PesoLiquido', 'PrecoTabela', 'DataHoraAlteracao',
			'KitECommerce', 'ProdutoGerencial'
	];
	

	public function getSkuKitAttribute(){
		return str_replace(".","",$this->ProdutoGerencial);
	}
	
	public function getSkuProdutoAttribute(){
		return str_replace(".","",$this->SKU);
	}
	
	public function produtos()
	{
		return $this->belongsTo('SGE\SyncProduto', 'SKU', 'SKU');
	}
}
<?php
namespace SGE;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Sofa\Eloquence\Mutable;

/**
 * SyncContratoProdutosIntegrador
 *
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @author-co Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
class SyncContratoProdutosIntegrador extends SyncContratoProdutos {
	
	
	use Eloquence, Mappable, Mutable;
	protected $maps = [
			'contrato_id' => 'Contrato',
			'percentual_desconto' => 'PercentualDesconto',
			'preco_final' => 'PrecoFinal',
			'descricao_kit' => 'DescricaoKit',
			'descricao_ecommerce' => 'DescricaoEcommerce',
			'peso_liquido' => 'produtos.PesoLiquido',
			'preco_tabela' => 'produtos.PrecoTabela',
			'data_expiracao' => 'produtos.DataExpiracao'
	];
	protected $appends = [
			'contrato_id', 'percentual_desconto', 'preco_final', 'descricao_kit',
			'descricao_ecommerce', 'peso_liquido', 'preco_tabela','skuchave'
	];
	protected $hidden = [
			'Contrato', 'PercentualDesconto', 'PrecoFinal', 'DescricaoKit',
			'DescricaoEcommerce', 'produtos','produtos.SKU', 'produtos.DataExpiracao', 'produtos.Descricao', 'produtos.DescricaoEcommerce',
			'produtos.Nivel', 'produtos.Serie', 'produtos.Bimestre', 'produtos.PesoLiquido', 'produtos.PrecoTabela', 'produtos.DataHoraAlteracao',
			'produtos.KitECommerce', 'ProdutoGerencial', 'row_num'
	];
	
	protected $with                                 = array('produtos');

	public function getSkuchaveAttribute(){
		return str_replace(".","",$this->SKU);
	}
	
	
	public function produtos()
	{
		return $this->belongsTo('SGE\SyncProduto', 'SKU', 'SKU');
	}
}
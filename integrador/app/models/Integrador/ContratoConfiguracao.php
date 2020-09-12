<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;

/**
 * Entidade que relacionará a tabela de produtos que estão armazenados no integrador e fará um join com os dados de estoque
 * para gerar a tabela de configuração lá no magento.
 * @author rodrigo
 * @author-co frank
 *
 */
class ContratoConfiguracao extends Model {
	private $id;
	protected $table = 'sge_estoque';
	protected $primaryKey = "id";
	public $timestamps  = false;
	public static $snakeAttributes  = true;
	
	protected $with                                 = array('contrato_produtos', 'contrato');
	protected $hidden                               = array('id','contrato_id','descricao','descricao_ecommerce','nivel','serie','bimestre','preco','percentual_desconto',
			'preco_final', 'kit', 'preco_tabela', 'peso_liquido','skuchave','descricao_kit'
	);
	
	protected $maps = [];
	protected $appends = [];
	
	
	public function estoque()
	{
		return $this->hasMany('Integrador\ContratoProdutos', 'contrato_id', 'contrato');
	}
	
	public function contrato()
	{
		return $this->belongsTo('Integrador\Contrato', 'contrato_id');
	}
	
}
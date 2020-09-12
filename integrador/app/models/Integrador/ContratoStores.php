<?php

namespace Integrador;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Resgate das Stores, Views e websites baseados nos contratos.
 * @author rodrigo
 *
 */
class ContratoStores extends Model {
	use Eloquence, Mappable;
	private $id;
	protected $table 		= 'sge_contrato';
	protected $primaryKey 	= "id";
	public $timestamps  	= false;
	public static $snakeAttributes  = false;
	
	protected $with                                 = array('store', 'website');
	protected $hidden                               = array('id','tipo_venda_id', 'situacao_contrato', 'faturado_por', 'parcela_minima', 'desconto_boleto', 'site_loja_escola', 'descricao_ecommerce',
			'data_alteracao', 'SLABoleto','expedido_por', 'cliente_id', 'data_inicio_vigencia', 'data_fim_vigencia', 'nome_cliente', 'cnpj', 'senha_padrao', 'contrato_original',
			'cliente_entrega', 'tipo_endereco_entrega', 'nome_magento'
	);
	
	protected $maps = [
			'name' => 'url_loja_escola',
			'code' => 'cliente_id'
	];
	protected $appends = [
			'name', 'code'
	];
	
	
	public function store()
	{
		return $this->belongsTo('Integrador\TipoVendaStores', 'tipo_venda_id');
	}
	
	public function website()
	{
		return $this->belongsTo('Integrador\StoreIntegracao', 'expedido_por');
	}
	
}
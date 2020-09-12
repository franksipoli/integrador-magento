<?php

namespace Comissao;

use \App;
use \Input;

/**
 * EstoqueController
 *
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @author-co Frank Sipoli <frank@visionnaire.com.br> 
 * @copyright 2016 Editora Positivo
 */
Class ComissaoController extends \BaseController
{

	/**
	 * Endpoint inicial para apresentação dos dados de Comissão.
	 *
	 * @return json
	 */
	public function index(){
			$limite_padrao 	= 20;
			$escola_id 	= 0;
			$nrpedido		= 0;
			$notafiscal		= 0;
			$serie			= 0;
			$dataEmissaoIni	= "";
			$dataEmissaoFim	= "";
			$Duplicata      = 0;
			$NomeCliente	= '';
			$valorStart		= 0;
			$valorEnd		= 0;
			$vencimentoIni	= "";
			$vencimentoFim	= "";
			$pagamentoIni	= "";
			$pagamentoFim	= "";
			$recStart		= 0;
			$recEnd		= 0;
			$percStart	= 0;
			$percEnd	= 0;
			$comissaoStart = 0;
			$comissaoEnd = 0;
			$query_sql = '';
			//
			//
			//$escola_id 			= 1;
			//$nrpedido				= 1000001;
			//$dataEmissaoIni		= "2016-08-03";
			//$dataEmissaoFim		= "2016-08-06";
			//$valorStart		= 110;
			//$valorEnd		= 110;
			//$vencimentoIni		= "2016-08-08";
			//$vencimentoFim		= "2016-08-30";
			//
		//if(Sentry::check()){
			$input = Input::get();
			
			/** in case request come from post http form */
			$input = (is_null($input) || empty($input)) ? \Input::post() : $input;
				
			if(isset($input['limit'])){
				$limite_padrao = ($input['limit'] == "" || $input['limit']<=0)?$limite_padrao:$input['limit'];
			}
			//
			if(isset($input['escola_id'])){
				$escola_id = ($input['escola_id'] == "")?$escola_id:$input['escola_id'];
			}
			//
			if(isset($input['nrpedido'])){
				$nrpedido = ($input['nrpedido'] == "")?$nrpedido:$input['nrpedido'];
			}
			//
			if(isset($input['notafiscal'])){
				$notafiscal = ($input['notafiscal'] == "")?$notafiscal:$input['notafiscal'];
			}			
			//
			if(isset($input['serie'])){
				$serie = ($input['serie'] == "")?$serie:$input['serie'];
			}
			//
			if(isset($input['dataEmissaoIni'])){
				$dataEmissaoIni = ($input['dataEmissaoIni'] == "")?$dataEmissaoIni:$input['dataEmissaoIni'];
			}
			if(isset($input['dataEmissaoFim'])){
				$dataEmissaoFim = ($input['dataEmissaoFim'] == "")?$dataEmissaoFim:$input['dataEmissaoFim'];
			}
			//
			if(isset($input['duplicata'])){
				$Duplicata = ($input['duplicata'] == "")?$Duplicata:$input['duplicata'];
			}
			//
			if(isset($input['nomecli'])){
				$NomeCliente = ($input['nomecli'] == "")?$NomeCliente:$input['nomecli'];
			}
			//
			if(isset($input['vlrStart'])){
				$valorStart = ($input['vlrStart'] == "")?$valorStart:$input['vlrStart'];
			}
			if(isset($input['vlrEnd'])){
				$valorEnd = ($input['vlrEnd'] == "")?$valorEnd:$input['vlrEnd'];
			}
			//
			if(isset($input['vencimentoIni'])){
				$vencimentoIni = ($input['vencimentoIni'] == "")?$vencimentoIni:$input['vencimentoIni'];
			}
			if(isset($input['vencimentoFim'])){
				$vencimentoFim = ($input['vencimentoFim'] == "")?$vencimentoFim:$input['vencimentoFim'];
			}
			//
			if(isset($input['pagamentoIni'])){
				$pagamentoIni = ($input['pagamentoIni'] == "")?$pagamentoIni:$input['pagamentoIni'];
			}
			if(isset($input['pagamentoFim'])){
				$pagamentoFim = ($input['pagamentoFim'] == "")?$pagamentoFim:$input['pagamentoFim'];
			}
			//
			if(isset($input['recStart'])){
				$recStart = ($input['recStart'] == "")?$recStart:$input['recStart'];
			}
			if(isset($input['recEnd'])){
				$recEnd = ($input['recEnd'] == "")?$recEnd:$input['recEnd'];
			}
			//
			if(isset($input['percStart'])){
				$percStart = ($input['percStart'] == "")?$percStart:$input['percStart'];
			}
			if(isset($input['percEnd'])){
				$percEnd = ($input['percEnd'] == "")?$percEnd:$input['percEnd'];
			}
			//
			if(isset($input['comissaoStart'])){
				$comissaoStart = ($input['comissaoStart'] == "")?$comissaoStart:$input['comissaoStart'];
			}
			if(isset($input['comissaoEnd'])){
				$comissaoEnd = ($input['comissaoEnd'] == "")?$comissaoEnd:$input['comissaoEnd'];
			}

			//
			// Exemplo Rodrigo
			// whereRaw("DataUltAlteracao > '". date("Y-m-d", $horaAnterior) ." 00:00:00'")
			//
			//
			if($escola_id<=0){
				$entity = \SGE\SyncComissao::orderBy("DataEmissao","DESC")->take($limite_padrao)->get();
			}else
			{
			$entity = \SGE\SyncComissao::where(function($query) use($escola_id,$nrpedido,$notafiscal,$serie,$dataEmissaoIni,$dataEmissaoFim,$Duplicata,$NomeCliente,$valorStart,$valorEnd,$vencimentoIni,$vencimentoFim,$pagamentoIni,$pagamentoFim,$recStart,$recEnd,$percStart,$percEnd,$comissaoStart,$comissaoEnd,$query_sql){
			
				$query_sql = '';

				if($escola_id>0){
					$query_sql .= "Escola = '".$escola_id."' ";
				}
				if($nrpedido>0){
					if(empty($query_sql)){
						$query_sql .= " Pedido = ".$nrpedido." ";
					}else{$query_sql .= " and Pedido = ".$nrpedido." ";}
				}
				if($notafiscal>0){
					if(empty($query_sql)){
						$query_sql .= " NotaFiscal = ".$notafiscal." ";
					}else{$query_sql .= " and NotaFiscal = ".$notafiscal." ";}
				}				
				if($serie>0){
					if(empty($query_sql)){
						$query_sql .= " Serie = ".$serie." ";
					}else{$query_sql .= " and Serie = ".$serie." ";}
				}
				if(($dataEmissaoIni <> '') && ($dataEmissaoFim <> '')){
					if(empty($query_sql)){ 
						$query_sql .= " ( DataEmissao >= '".$dataEmissaoIni." 00:00:00' and DataEmissao <= '".$dataEmissaoFim." 00:00:00') "; 
					}else{ $query_sql .= " and ( DataEmissao >= '".$dataEmissaoIni." 00:00:00' and DataEmissao <= '".$dataEmissaoFim." 00:00:00') ";}
				}
				if($Duplicata>0){
					if(empty($query_sql)){
						$query_sql .= " Duplicata = '".$Duplicata."' ";
					}else{$query_sql .= " and Duplicata = '".$Duplicata."' ";}
				}
				if($NomeCliente <> ''){
					if(empty($query_sql)){
						$query_sql .= " NomeClienteFatur like '%".$NomeCliente."%' ";
					}else{$query_sql .= " and NomeClienteFatur like '%".$NomeCliente."%' ";}
				}
				if(($valorStart > 0) && ($valorEnd > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " ( ValorDuplicata >= ".$valorStart." and ValorDuplicata <= ".$valorEnd.") "; 
					}else{ $query_sql .= " and ( ValorDuplicata >= ".$valorStart." and ValorDuplicata <= ".$valorEnd.") ";}
				}
				if(($vencimentoIni <> '') && ($vencimentoFim <> '')){
					if(empty($query_sql)){ 
						$query_sql .= " ( Vencimento >= '".$vencimentoIni." 00:00:00' and Vencimento <= '".$vencimentoFim." 00:00:00') "; 
					}else{ $query_sql .= " and ( Vencimento >= '".$vencimentoIni." 00:00:00' and Vencimento <= '".$vencimentoFim." 00:00:00') ";}
				}
				if(($pagamentoIni <> '') && ($pagamentoFim <> '')){
					if(empty($query_sql)){ 
						$query_sql .= " ( DataPagamento >= '".$pagamentoIni." 00:00:00' and DataPagamento <= '".$pagamentoFim." 00:00:00') "; 
					}else{ $query_sql .= " and ( DataPagamento >= '".$pagamentoIni." 00:00:00' and DataPagamento <= '".$pagamentoFim." 00:00:00') ";}
				}
				if(($recStart > 0) && ($recEnd > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " ( Recebimento >= ".$recStart." and Recebimento <= ".$recEnd.") "; 
					}else{ $query_sql .= " and ( Recebimento >= ".$recStart." and Recebimento <= ".$recEnd.") ";}
				}
				if(($percStart > 0) && ($percEnd > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " ( Percentual >= ".$percStart." and Percentual <= ".$percEnd.") "; 
					}else{ $query_sql .= " and ( Percentual >= ".$percStart." and Percentual <= ".$percEnd.") ";}
				}
				if(($comissaoStart > 0) && ($comissaoEnd > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " ( ValorComissao >= ".$comissaoStart." and ValorComissao <= ".$comissaoEnd.") "; 
					}else{ $query_sql .= " and ( ValorComissao >= ".$comissaoStart." and ValorComissao <= ".$comissaoEnd.") ";}
				}

				//print $query_sql;

				$query->whereRaw($query_sql);

            	})->orderBy("DataEmissao","DESC")->take($limite_padrao)->get();
			
			}
			 
			if($entity){
				$this->_retorno['message']                      = 'Ok ';
				$this->_retorno['data']							= $entity;
			}else{
				$this->_retorno['message']                      = 'Registro nao encontrado';
			}
			
			$this->_retorno['success']                      = true;
			$this->_retorno['code']                 		= is_null($entity) ? 404 : 200;
		//}
		$this->retornoJson();
	}
	
	/**
	 * Endpoint inicial para apresentação dos dados de Baixa das Comissões.
	 *
	 * @return json
	 */
	public function indexBaixas()
	{
			$limite_padrao 	= 20;
			$escola_id 	= 0;
			$baixaIni	= "";
			$baixaFim	= "";
			$tipobaixa	= '';
			$valorStart		= 0;
			$valorEnd		= 0;
			$query_sql = '';
			//
			//$escola_id 			= 1;
			//$baixaIni		= "2016-08-01";
			//$baixaFim		= "2016-08-01";
			//$valorStart		= 110;
			//$valorEnd		= 110;
			//$tipobaixa	= 'baixa2';

		//if(Sentry::check()){
			$input = Input::get();
			
			/** in case request come from post http form */
			$input = (is_null($input) || empty($input)) ? \Input::post() : $input;
	
			if(isset($input['limit'])){
				$limite_padrao = ($input['limit'] == "" || $input['limit']<=0)?$limite_padrao:$input['limit'];
			}
			//
			if(isset($input['escola_id'])){
				$escola_id = ($input['escola_id'] == "")?$escola_id:$input['escola_id'];
			}
			//
			if(isset($input['baixaIni'])){
				$baixaIni = ($input['baixaIni'] == "")?$baixaIni:$input['baixaIni'];
			}
			if(isset($input['baixaFim'])){
				$baixaFim = ($input['baixaFim'] == "")?$baixaFim:$input['baixaFim'];
			}
			//
			if(isset($input['tipobaixa'])){
				$tipobaixa = ($input['tipobaixa'] == "")?$tipobaixa:$input['tipobaixa'];
			}
			//
			if(isset($input['vlrStart'])){
				$valorStart = ($input['vlrStart'] == "")?$valorStart:$input['vlrStart'];
			}
			if(isset($input['vlrEnd'])){
				$valorEnd = ($input['vlrEnd'] == "")?$valorEnd:$input['vlrEnd'];
			}
			//
			// Exemplo Rodrigo
			// whereRaw("DataUltAlteracao > '". date("Y-m-d", $horaAnterior) ." 00:00:00'")
			//
			//
			if($escola_id<=0){
				$entity = \SGE\SyncComissaoBaixas::orderBy("DataBaixa","DESC")->take($limite_padrao)->get();
			}else
			{
				$entity = \SGE\SyncComissaoBaixas::where(function($query) use($escola_id,$baixaIni,$baixaFim,$tipobaixa,$valorStart,$valorEnd,$query_sql){
			
				$query_sql = '';

				if($escola_id>0){
					$query_sql .= "Escola = '".$escola_id."' ";
				}
				if(($baixaIni <> '') && ($baixaFim <> '')){
					if(empty($query_sql)){ 
						$query_sql .= " ( DataBaixa >= '".$baixaIni." 00:00:00' and DataBaixa <= '".$baixaFim." 00:00:00') "; 
					}else{ $query_sql .= " and ( DataBaixa >= '".$baixaIni." 00:00:00' and DataBaixa <= '".$baixaFim." 00:00:00') ";}
				}
				if($tipobaixa <> ''){
					if(empty($query_sql)){
						$query_sql .= " TipoDeBaixa like '%".$tipobaixa."%' ";
					}else{$query_sql .= " and TipoDeBaixa like '%".$tipobaixa."%' ";}
				}
				if(($valorStart > 0) && ($valorEnd > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " ( ValorBaixa >= ".$valorStart." and ValorBaixa <= ".$valorEnd.") "; 
					}else{ $query_sql .= " and ( ValorBaixa >= ".$valorStart." and ValorBaixa <= ".$valorEnd.") ";}
				}

				//print $query_sql;

				$query->whereRaw($query_sql);

            	})->orderBy("DataBaixa","DESC")->take($limite_padrao)->get();
            	//$entity = \SGE\SyncComissaoBaixas::orderBy("DataBaixa","DESC")->take($limite_padrao)->get();
			}
			
			if($entity){
				$this->_retorno['message']                      = 'Ok '.$query_sql;
				$this->_retorno['data']							= $entity;
			}else{
				$this->_retorno['message']                      = 'Registro nao encontrado';
			}
			
			$this->_retorno['success']                      = true;
			$this->_retorno['code']                 		= is_null($entity) ? 404 : 200;
		//}
			$this->retornoJson();
	}
    

/**
	 * Endpoint inicial para apresentação dos dados de Baixa das Comissões.
	 *
	 * @return json
	 */
	public function indexPrevisaoBaixa()
	{
			$limite_padrao 	= 20;
			$escola_id 	= 0;
			$mesprevIni	= "";
			$anoprevIni	= "";
			$query_sql = '';
			//
			//$escola_id 	= 1;
			//$mesprevIni		= "08";
			//$anoprevIni		= "2016";

		//if(Sentry::check()){
			$input = Input::get();
			
			/** in case request come from post http form */
			$input = (is_null($input) || empty($input)) ? \Input::post() : $input;
	
			if(isset($input['limit'])){
				$limite_padrao = ($input['limit'] == "" || $input['limit']<=0)?$limite_padrao:$input['limit'];
			}
			//
			if(isset($input['escola_id'])){
				$escola_id = ($input['escola_id'] == "")?$escola_id:$input['escola_id'];
			}
			//
			if(isset($input['mesprevIni'])){
				$mesprevIni = ($input['mesprevIni'] == "")?$mesprevIni:$input['mesprevIni'];
			}
			//
			if(isset($input['anoprevIni'])){
				$anoprevIni = ($input['anoprevIni'] == "")?$anoprevIni:$input['anoprevIni'];
			}
			//
			// Exemplo Rodrigo
			// whereRaw("DataUltAlteracao > '". date("Y-m-d", $horaAnterior) ." 00:00:00'")
			//
			//
			if($escola_id<=0){
				$entity = \SGE\SyncComissaoPrevisaoBaixa::orderBy("Ano","DESC")->orderBy("Mes", "ASC")->take($limite_padrao)->get();
			}else
			{
				$entity = \SGE\SyncComissaoPrevisaoBaixa::where(function($query) use($escola_id,$mesprevIni,$anoprevIni,$query_sql){
			
				$query_sql = '';

				if($escola_id>0){
					$query_sql .= "Escola = '".$escola_id."' ";
				}
				//
				if(($mesprevIni > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " Mes = ".$mesprevIni." "; 
					}else{ $query_sql .= " and  Mes = ".$mesprevIni." ";}
				}
				if(($anoprevIni > 0)){
					if(empty($query_sql)){ 
						$query_sql .= " Ano = ".$anoprevIni." "; 
					}else{ $query_sql .= " and Ano = ".$anoprevIni." ";}
				}

				//print $query_sql;

				$query->whereRaw($query_sql);

            	})->orderBy("Ano","DESC")->orderBy("Mes", "ASC")->take($limite_padrao)->get();
            	
			}
			
			if($entity){
				$this->_retorno['message']                      = 'Ok '.$query_sql;
				$this->_retorno['data']							= $entity;
			}else{
				$this->_retorno['message']                      = 'Registro nao encontrado';
			}
			
			$this->_retorno['success']                      = true;
			$this->_retorno['code']                 		= is_null($entity) ? 404 : 200;
		//}
			$this->retornoJson();
	}

}
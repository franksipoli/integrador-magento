<?php

namespace Utils;

/**
 * UtilsController
 *
 * @author Rodrigo Otávio <rodrigo@visionnaire.com.br>
 * @copyright 2016 Editora Positivo
 */
Class UtilsController extends \BaseController
{
	public static function validaUrlStores($url_loja_escola){
		// vamos tratar aqui a url da escola para poder enviar ao Magento. Pois a url tem que ter uma barra no final.
		$barrafinal = substr($url_loja_escola, -1);	// pega o último caracter.
		if($barrafinal != "/"){
			$url_loja_escola .= "/";
		}
		
		// vamos tratar aqui se a url tem http:// no começo também.
		$httpcomeco = preg_match("^((http[s]?|ftp):\/)?\/?^", $url_loja_escola, $retorno);
		if(!isset($retorno[0]) || $retorno[0] == ""){
			$url_loja_escola = "http://".$url_loja_escola;
		}
		return $url_loja_escola;
	}
}

?>
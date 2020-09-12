<?php

/**
 * Soap Config
 *
 * Arquivo contendo os dados de configuração para o acesso via SOAP no Magento.
 * @author Rodrigo / Frank
 * @copyright 2016 Editora Positivo
 */

$config['soap'] = array(
    'login'       	=> 'frank',
	'senha'			=> 'minhachave', 
	'servidor'		=> 'http://rods.lojavarejo.com/api/v2_soap'					// Esse � o servidor em que o Integrador vai fazer comunica��o com o Magento. O ideal � ser o Varejo.
);

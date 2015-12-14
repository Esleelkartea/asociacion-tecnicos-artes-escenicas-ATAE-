<?php
/****************************************************************************************************/
/* Pantalla: ajaxCargaPaginas.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, carga los datos de páginas...
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	14/03/2012	Creación               
/*
/****************************************************************************************************/

if(!defined('THEMEPATH')) define('THEMEPATH', dirname(__FILE__));
if(!defined('PLUGINPATH')) define('PLUGINPATH', dirname(__FILE__).'/../../plugins/doconline/');

if(!$_GET['idDocumento']) echo '<option value="">Error de documento</option>';
else {
	$idDocumento = $_GET['idDocumento'];
	$modo = (isset($_GET['modo'])) ? $_GET['modo'] : 'select' ;

	include(PLUGINPATH.'class/datos.class.php');

	// Obtenemos las páginas
	$paginas = Datos::getPaginas($idDocumento);
	if($paginas === false) echo '<option value="">Error al obtener páginas de '.$idDocumento.'</option>';
	else {
		switch($modo) {
			case 'select':
				if(!is_array($paginas)) echo '<option value="">El documento carece de páginas</option>';
				else {
					echo '<option value="">Seleccione una página</option>';
					foreach($paginas as $pagina) {
						echo '<option value="'.$pagina['id_pagina'].'">'.utf8_encode($pagina['referencia']).'</option>';
					}
				}
				break;
		}
	}
}
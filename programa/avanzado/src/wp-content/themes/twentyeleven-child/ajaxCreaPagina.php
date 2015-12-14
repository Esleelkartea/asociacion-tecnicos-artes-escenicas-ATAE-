<?php
/****************************************************************************************************/
/* Pantalla: ajaxCreaPagina.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, crea una página para un documento...
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

if(!$_POST['idDocumento']) echo 'error[;;]Error de parámetros, no se encuentra idDocumento';
else {
	$idDocumento = $_POST['idDocumento'];
	$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : 'pagina';

	include(PLUGINPATH.'class/datos.class.php');

	$idPagina = Datos::creaPagina($idDocumento,$tipo);
	if($idPagina === false) echo 'error[;;]Error al crear la página '.$tipo.' para el documento '.$idDocumento;
	else if($idPagina == 0) echo 'aviso[;;]Ya se encuentra la página de tipo '.$tipo.' para el documento '.$idDocumento;
	else {
		// Hallamos sus datos:
		$pagina = Datos::getPaginaData($idPagina);
		if($pagina === false) echo 'error[;;]Error al obtener los datos de la página '.$idPagina.' para el documento '.$idDocumento;
		else {
			$res = array();
			$res[] = 'success';
			foreach($pagina as $cData => $data) $res[] = $cData.'[::]'.$data; // datos
			echo implode('[;;]',$res);
		}
	}
}
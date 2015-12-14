<?php
/****************************************************************************************************/
/* Pantalla: ajaxModDocumento.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, modifica los datos de un documento...
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	15/03/2012	Creación               
/*
/****************************************************************************************************/

if(!defined('THEMEPATH')) define('THEMEPATH', dirname(__FILE__));
if(!defined('PLUGINPATH')) define('PLUGINPATH', dirname(__FILE__).'/../../plugins/doconline/');

if(!$_POST['idDocumento']) echo 'error[;;]Error de parámetros, no se encuentra idDocumento';
else if(!$_POST['nombre']) echo 'error[;;]Error de parámetros, no se encuentra nombre';
else if(!$_POST['version']) echo 'error[;;]Error de parámetros, no se encuentra version';
else if(!$_POST['alto']) echo 'error[;;]Error de parámetros, no se encuentra alto';
else if(!$_POST['ancho']) echo 'error[;;]Error de parámetros, no se encuentra ancho';
else {
	$idDocumento = $_POST['idDocumento'];
	$nombre = $_POST['nombre'];
	$version = $_POST['version'];
	$alto = $_POST['alto'];
	$ancho = $_POST['ancho'];
	include(PLUGINPATH.'class/datos.class.php');
	$referencia = ($_POST['referencia']) ? $_POST['referencia'] : NULL;
	$descripcion = ($_POST['descripcion']) ? $_POST['descripcion'] : NULL;
	$numerada = ($_POST['numerada']) ? $_POST['numerada'] : NULL;
	$args = array (
		'idDocumento' => $idDocumento,
		'nombre' => ($nombre != NULL) ? utf8_decode($nombre) : NULL,
		'version' => ($version != NULL) ? utf8_decode($version) : NULL,
		'alto' => $alto,
		'ancho' => $ancho,
		'referencia' => ($referencia != NULL) ? utf8_decode($referencia) : NULL,
		'descripcion' => ($descripcion != NULL) ? utf8_decode($descripcion) : NULL,
		'numerada' => ($numerada != NULL) ? $numerada : NULL,
	);
	$r = Datos::updDocumento($args);
	if($r === false) echo 'error[;;]Error al modificar el documento '.$idDocumento;
	else echo 'success[;;]ok';
}


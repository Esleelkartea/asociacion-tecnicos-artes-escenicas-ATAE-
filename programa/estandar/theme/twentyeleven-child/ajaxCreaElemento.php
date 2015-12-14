<?php
/****************************************************************************************************/
/* Pantalla: ajaxCreaElemento.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, crea un elemento para una página...
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	21/03/2012	Creación               
/*
/****************************************************************************************************/

if(!defined('THEMEPATH')) define('THEMEPATH', dirname(__FILE__));
if(!defined('PLUGINPATH')) define('PLUGINPATH', dirname(__FILE__).'/../../plugins/doconline/');

if(!$_POST['idElemento']) echo 'error[;;]Error de parámetros, no se encuentra idElemento';
if(!$_POST['idPagina']) echo 'error[;;]Error de parámetros, no se encuentra idPagina';
if(!$_POST['tipo']) echo 'error[;;]Error de parámetros, no se encuentra tipo';
if(!$_POST['codigo']) echo 'error[;;]Error de parámetros, no se encuentra codigo';
if(!$_POST['alto']) echo 'error[;;]Error de parámetros, no se encuentra alto';
if(!$_POST['ancho']) echo 'error[;;]Error de parámetros, no se encuentra ancho';
else {
	$args = array (
		'idElemento' => $_POST['idElemento'],
		'idPagina' => $_POST['idPagina'],
		'tipo' => $_POST['tipo'],
		'codigo' => $_POST['codigo'],
		'alto' => $_POST['alto'],
		'ancho' => $_POST['ancho'],
		'referencia' => (isset($_POST['referencia'])) ? $_POST['referencia'] : NULL,
		'dtop' => (isset($_POST['dtop'])) ? $_POST['dtop'] : 0,
		'dleft' => (isset($_POST['dleft'])) ? $_POST['dleft'] : 0,
		'zindex' => (isset($_POST['zindex'])) ? $_POST['zindex'] : 1000,
		'mtop' => (isset($_POST['mtop'])) ? $_POST['mtop'] : 0,
		'mright' => (isset($_POST['mright'])) ? $_POST['mright'] : 0,
		'mbottom' => (isset($_POST['mbottom'])) ? $_POST['mbottom'] : 0,
		'mleft' => (isset($_POST['mleft'])) ? $_POST['mleft'] : 0,
		'ptop' => (isset($_POST['ptop'])) ? $_POST['ptop'] : 0,
		'pright' => (isset($_POST['pright'])) ? $_POST['pright'] : 0,
		'pbottom' => (isset($_POST['pbottom'])) ? $_POST['pbottom'] : 0,
		'pleft' => (isset($_POST['pleft'])) ? $_POST['pleft'] : 0,
		'cfondo' => (isset($_POST['cfondo'])) ? $_POST['cfondo'] : NULL,
		'borde' => (isset($_POST['borde'])) ? $_POST['borde'] : 0,
		'cborde' => (isset($_POST['cborde'])) ? $_POST['cborde'] : NULL,
	);

	include(PLUGINPATH.'class/datos.class.php');

	$idElemento = Datos::creaElemento($args);
	if($idElemento === false) echo 'error[;;]Error al crear el elemento para la página '.$_POST['idPagina'];
	else {
		$res = array();
		$res[] = 'success';
		$res[] = 'ok';
		echo implode('[;;]',$res);
	}
}
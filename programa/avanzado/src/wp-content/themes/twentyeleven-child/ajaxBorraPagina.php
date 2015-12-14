<?php
/****************************************************************************************************/
/* Pantalla: ajaxBorraPagina.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, elimina una página...
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	27/03/2012	Creación               
/*
/****************************************************************************************************/

if(!defined('THEMEPATH')) define('THEMEPATH', dirname(__FILE__));
if(!defined('PLUGINPATH')) define('PLUGINPATH', dirname(__FILE__).'/../../plugins/doconline/');

if(!$_POST['idPagina']) echo 'error[;;]Error de parámetros, no se encuentra idPagina';
else {
	$idPagina = $_POST['idPagina'];
	include(PLUGINPATH.'class/datos.class.php');
	$r = Datos::delPagina($idPagina);
	if($r === false) echo 'error[;;]Error al borrar la página '.$idPagina;
	else echo 'success[;;]ok';
}
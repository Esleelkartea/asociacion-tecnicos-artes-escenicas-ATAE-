<?php
/****************************************************************************************************/
/* Pantalla: ajaxModPagina.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, modifica los datos de una página...
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

if(!$_POST['idPagina']) echo 'error[;;]Error de parámetros, no se encuentra idPagina';
else {
	$idPagina = $_POST['idPagina'];
	include(PLUGINPATH.'class/datos.class.php');
	$referencia = ($_POST['referencia']) ? $_POST['referencia'] : NULL;
	$contenido = ($_POST['contenido']) ? $_POST['contenido'] : NULL;
	//echo 'Contenido es: '.utf8_decode($contenido).'<br/>';
	$args = array (
		'idPagina' => $idPagina,
		'referencia' => ($referencia != NULL) ? utf8_decode($referencia) : NULL,
		'contenido' => ($contenido != NULL) ? utf8_decode($contenido) : NULL,
	);
	$r = Datos::updPagina($args);
	if($r === false) echo 'error[;;]Error al modificar la página '.$idPagina;
	else echo 'success[;;]ok';
}


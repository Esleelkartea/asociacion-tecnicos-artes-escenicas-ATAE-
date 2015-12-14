<?php
/****************************************************************************************************/
/* Pantalla: ajaxCargaPagina.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, carga una página para un documento...
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
	$pagina = Datos::getPaginaData($idPagina);
	if($pagina === false) echo 'error[;;]Error al obtener datos de la página '.$idPagina;
	else {
		$res = array();
		$res[] = 'success';
		foreach($pagina as $cData => $data) $res[] = ($cData=='contenido') ? $cData.'[::]'.str_replace('[["]]',"'",utf8_encode($data)) : $cData.'[::]'.utf8_encode($data); // datos
		echo implode('[;;]',$res);
	}
}

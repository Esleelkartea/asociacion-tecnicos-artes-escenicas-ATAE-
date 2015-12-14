<?php
/****************************************************************************************************/
/* Pantalla: ajaxCargaDocumento.php
/* Theme: doconline
/* Descripción: código ajax lanzado por jquery, carga los datos de un documento...
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	13/03/2012	Creación               
/*
/****************************************************************************************************/

if(!defined('THEMEPATH')) define('THEMEPATH', dirname(__FILE__));
if(!defined('PLUGINPATH')) define('PLUGINPATH', dirname(__FILE__).'/../../plugins/doconline/');

if(!$_POST['idDocumento']) echo 'error[;;]Error de parámetros, no se encuentra idDocumento';
$idDocumento = $_POST['idDocumento'];

include(PLUGINPATH.'class/datos.class.php');

// obtenemos sus datos:
$docData = Datos::getDocumentoData($idDocumento);
if($docData === false) echo 'error[;;]Error al obtener los datos del documento '.$idDocumento;
else {
	//echo 'Tenemos idDocumento '.$idDocumento.' con path "'.MYPATH.'"';
	$res = array();
	$res[] = 'success'; // Todo bien...
	foreach($docData as $cData => $data) if($cData != 'meta') $res[] = $cData.'[::]'.$data; // datos
	if(is_array($docData['meta'])) foreach($docData['meta'] as $cData => $data) $res[] = 'meta_'.$cData.'[::]'.$data; // datos
	echo implode('[;;]',$res);
}

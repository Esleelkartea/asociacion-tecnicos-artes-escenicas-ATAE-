<?php
/****************************************************************************************************/
/* Pantalla: _desinstalarTablas.php
/* Plugin: doconline
/* Descripción: include para la desinstalación de tablas del plugin
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		10/08/2011	Creación               
/*
/****************************************************************************************************/

// CONSTANTES
if (!defined('DODBPREFIX')) define('DODBPREFIX','dop_');

// borrado de tablas
$tablas = array (
	DODBPREFIX."varios",
	//DODBPREFIX."historicos",
	//DODBPREFIX."elementos",
	DODBPREFIX."paginas",
	//DODBPREFIX."meta_documentos",
	DODBPREFIX."documentos",
);
foreach($tablas as $tabla) {
	$sql = "drop table if exists $tabla cascade";
	$wpdb->query($sql);
}

$sql = "alter table ".$wpdb->prefix."users ENGINE= MyISAM;";
$wpdb->query($sql);	

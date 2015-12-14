<?php
/****************************************************************************************************/
/* Pantalla: utils.class.php
/* Descripción: Clase para utilidades genéricas
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	07/03/2012	Creación          
/*
/****************************************************************************************************/

class Util {
	
// Constantes

// Variables privadas:

// Constructor:
function __construct() {
}

/* MÉTODOS */

// Convierte píxeles en mm segun dpi y un factor de conversión
public static function getMm($pixels=1,$dpi=72,$factor=1) {
	$mm = ($pixels * 25.4) / $dpi;
	return $mm;
}

// Convierte mm en píxeles según dpi y un factor de conversión
public static function getPixels($mm=1,$dpi=72,$factor=1) {
	$pixels = ($mm * $dpi) / 25.4;
	return $pixels;
}


	
}

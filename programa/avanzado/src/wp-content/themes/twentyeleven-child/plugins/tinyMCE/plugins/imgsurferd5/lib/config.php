<?php

	// FICHERO DE CONFIGURACION
	
	/*
	 * aqui se configuran las rutas del directorio de imagenes
	 * BASE_RUTA es una ruta física y 
	 * BASE_RUTA_HTTP es una ruta web que es la que es guardara en el
	 * editor y por tanto en la base de datos

	*/
	$myPath = dirname(__FILE__);
	$myUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$myPath = substr($myPath,0,strpos($myPath,'wp-content')+11);
	$myUrl = substr($myUrl,0,strpos($myUrl,'wp-content')+11);

	if(!defined('BASE_RUTA')) define('BASE_RUTA', $myPath.'plugins/doconline/images/elementos/');
	if(!defined('BASE_RUTA_HTTP')) define('BASE_RUTA_HTTP', $myUrl.'plugins/doconline/images/elementos/');
	
?>

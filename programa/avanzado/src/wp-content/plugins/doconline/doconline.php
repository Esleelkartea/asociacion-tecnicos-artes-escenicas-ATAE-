<?php
/*
Plugin Name: doconline
Plugin URI: www.digital5.es
Description: Plugin necesario para el módulo de documentación on-line
Version: 1.0
Author: Digital5 (David Calvo)
Author URI: www.digital5.es
*/

// CONSTANTES GENERALES
if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL',get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR',ABSPATH.'wp-content');
if (!defined('WP_PLUGIN_URL')) define('WP_PLUGIN_URL',WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR')) define('WP_PLUGIN_DIR',WP_CONTENT_DIR.'/plugins');

if (!defined('DOPNAME')) define('DOPNAME','doconline');

// Instalador
function instalar_doconline() {
	global $wpdb;
	// Check for capability
	if (!current_user_can('activate_plugins')) return;
	require_once(WP_PLUGIN_DIR.'/'.DOPNAME.'/_instalarTablas.php');
}

// Desinstalador
function desinstalar_doconline() {
	global $wpdb;
	require_once(WP_PLUGIN_DIR.'/'.DOPNAME.'/_desinstalarTablas.php');
}

// WIDGETS



// Comprueba que todo halla ido correctamente:
if(get_option('init_check') != false) {
	add_action('admin_notices',create_function('','echo \'<div id="message" class="error"><p><strong>'.get_option("init_check").'</strong></p></div>\';'));
	update_option( "init_check",false);
}

// Acciones de instalación / desinstalación
add_action('activate_doconline/doconline.php','instalar_doconline');
add_action('deactivate_doconline/doconline.php','desinstalar_doconline');

<?php
/****************************************************************************************************/
/* Pantalla: _instalarTablas.php
/* Plugin: doconline
/* Descripción: include para la instalación de tablas del plugin
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		06/03/2012	Creación               
/*
/****************************************************************************************************/

// CONSTANTES
if (!defined('DODBPREFIX')) define('DODBPREFIX','dop_');

// CHARSET
$charset_collate = '';
if (version_compare(mysql_get_server_info(), '4.1.0', '>=')) {
	if (!empty($wpdb->charset)) $charset_collate = " DEFAULT CHARACTER SET $wpdb->charset";
	$charset_collate .= " ENGINE= InnoDB";
}
$sql = "alter table ".$wpdb->prefix."users ENGINE= InnoDB;";
$wpdb->query($sql);	

/* TABLAS GENERALES */

// varios
$tabla = DODBPREFIX."varios";
$sql = "create table $tabla (";
$sql .= "id_varios mediumint(9) unsigned NOT NULL AUTO_INCREMENT, ";
$sql .= "dominio varchar(50) NOT NULL, ";
$sql .= "concepto varchar(50), ";
$sql .= "patron varchar(50) NOT NULL, ";
$sql .= "valor text, ";
$sql .= "extra text, ";
$sql .= "primary key (id_varios)";
$sql .= ")$charset_collate;";
$wpdb->query($sql);
// Comprobación
if(!$wpdb->get_var( "show tables like '$tabla'")) {
	update_option( "init_check","DocOnline: error al crear la tabla $tabla");
	return;
}

// historicos
/*
$tabla = DODBPREFIX."historicos";
$sql = "create table $tabla (";
$sql .= "id_historico mediumint(9) NOT NULL AUTO_INCREMENT, ";
$sql .= "concepto varchar(50) NOT NULL, ";
$sql .= "referencia varchar(50) NOT NULL, ";
$sql .= "valor text, ";
$sql .= "fecha timestamp NOT NULL , ";
$sql .= "primary key (id_historico)";
$sql .= ")$charset_collate;";
$wpdb->query($sql);
// Comprobación
if(!$wpdb->get_var( "show tables like '$tabla'")) {
	update_option( "init_check","DocOnline: error al crear la tabla $tabla");
	return;
}
*/

// documentos
$tabla = DODBPREFIX."documentos";
$sql = "create table $tabla (";
$sql .= "id_documento bigint(20) unsigned NOT NULL AUTO_INCREMENT, ";
$sql .= "id_usuario bigint(20) unsigned NOT NULL, ";
$sql .= "codigo varchar(20) NOT NULL, ";
$sql .= "version varchar(20) NOT NULL, ";
$sql .= "referencia varchar(20), "; // por si lo basamos en otro documento
$sql .= "tipo varchar(20) NOT NULL default 'A4', ";
$sql .= "nombre varchar(50) NOT NULL, ";
$sql .= "descripcion varchar(500), ";
$sql .= "contenido text, ";
$sql .= "alto float NOT NULL default 297, ";
$sql .= "ancho float NOT NULL default 210, ";
$sql .= "numerada varchar(1) NOT NULL DEFAULT 'N', ";
$sql .= "dpi int NOT NULL default 300, ";
$sql .= "vistas mediumint(9), "; // Veces que se ha visto el elemento
$sql .= "descargas mediumint(9), "; // Veces que se ha descargado
$sql .= "estado varchar(20) NOT NULL default 'nuevo', ";
$sql .= "fec_alta timestamp NULL DEFAULT NULL, ";
$sql .= "fec_mod timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ";
$sql .= "primary key (id_documento),";
$sql .= "foreign key (id_usuario) references ".$wpdb->prefix."users(ID) ON DELETE CASCADE ON UPDATE CASCADE";
$sql .= ")$charset_collate;";

$wpdb->query($sql);
// Comprobación
if(!$wpdb->get_var( "show tables like '$tabla'")) {
	update_option( "init_check","DocOnline: error al crear la tabla $tabla");
	return;
}

// meta documentos
/*
$tabla = DODBPREFIX."meta_documentos";
$sql = "create table $tabla (";
$sql .= "id_meta_documento bigint(20) unsigned NOT NULL AUTO_INCREMENT, ";
$sql .= "id_documento bigint(20) unsigned NOT NULL, ";
$sql .= "meta_key varchar(50) NOT NULL, ";
$sql .= "meta_extra varchar(20), ";
$sql .= "meta_value text, ";
$sql .= "primary key (id_meta_documento),";
$sql .= "foreign key (id_documento) references ".DODBPREFIX."documentos(id_documento) ON DELETE CASCADE ON UPDATE CASCADE";
$sql .= ")$charset_collate;";
$wpdb->query($sql);
// Comprobación
if(!$wpdb->get_var( "show tables like '$tabla'")) {
	update_option( "init_check","DocOnline: error al crear la tabla $tabla");
	return;
}
*/

// páginas
$tabla = DODBPREFIX."paginas";
$sql = "create table $tabla (";
$sql .= "id_pagina bigint(20) unsigned NOT NULL AUTO_INCREMENT, ";
$sql .= "id_documento bigint(20) unsigned NOT NULL, ";
$sql .= "codigo varchar(20) NOT NULL, ";
$sql .= "referencia varchar(20), "; // por si lo basamos en otro documento
$sql .= "tipo varchar(20) NOT NULL default 'pagina', "; // puede ser: plantilla, portada, pagina y contraportada
$sql .= "numerada varchar(1) NOT NULL DEFAULT 'N', ";
$sql .= "posicion varchar(2) NOT NULL DEFAULT 'N', "; // N: no, PD: par derecha, PI: impar derecha, D: derecha, I: izquierda
$sql .= "numero int, ";
$sql .= "contenido text, ";
$sql .= "estado varchar(20) NOT NULL default 'nuevo', ";
$sql .= "fec_alta timestamp NULL DEFAULT NULL, ";
$sql .= "fec_mod timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ";
$sql .= "primary key (id_pagina),";
$sql .= "foreign key (id_documento) references ".DODBPREFIX."documentos(id_documento) ON DELETE CASCADE ON UPDATE CASCADE";
$sql .= ")$charset_collate;";
$wpdb->query($sql);
// Comprobación
if(!$wpdb->get_var( "show tables like '$tabla'")) {
	update_option( "init_check","DocOnline: error al crear la tabla $tabla");
	return;
}

// elementos
/*
$tabla = DODBPREFIX."elementos";
$sql = "create table $tabla (";
$sql .= "id_elemento bigint(20) unsigned NOT NULL, ";
$sql .= "id_pagina bigint(20) unsigned NOT NULL, ";
$sql .= "codigo varchar(20) NOT NULL, ";
$sql .= "referencia varchar(20), ";
$sql .= "tipo varchar(20) NOT NULL default 'libre', "; // puede ser: libre, fijo
$sql .= "orden int, "; // por si es fijo
$sql .= "dtop int NOT NULL default 0, "; // por si es libre
$sql .= "dleft int NOT NULL default 0, "; // por si es libre
$sql .= "zindex mediumint NOT NULL default 1000,"; // por si es libre
$sql .= "alto float NOT NULL default 50, ";
$sql .= "acho float NOT NULL default 50, ";
$sql .= "mtop int NOT NULL default 0, "; // margen superior
$sql .= "mright int NOT NULL default 0, "; // margen derecho
$sql .= "mbottom int NOT NULL default 0, "; // margen inferior
$sql .= "mleft int NOT NULL default 0, "; // margen izquierdo
$sql .= "ptop int NOT NULL default 0, "; // padding superior
$sql .= "pright int NOT NULL default 0, "; // padding derecho
$sql .= "pbottom int NOT NULL default 0, "; // padding inferior
$sql .= "pleft int NOT NULL default 0, "; // padding izquierdo
$sql .= "borde int NOT NULL default 0, ";
$sql .= "cborde varchar(7) NOT NULL default '#000000', "; // color del borde
$sql .= "eborde varchar(20), "; // estilo del borde
$sql .= "cfondo varchar(7) NOT NULL default '#FFFFFF', "; // color del fondo
$sql .= "ifondo varchar(500), "; // imágen de fondo
$sql .= "rfondo varchar(20), "; // repetición de imágen de fondo
$sql .= "pfondo varchar(20), "; // posición de imágen de fondo
$sql .= "contenido text, ";
$sql .= "estado varchar(20) NOT NULL default 'nuevo', ";
$sql .= "fec_alta timestamp NULL DEFAULT NULL, ";
$sql .= "fec_mod timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ";
$sql .= "primary key (id_elemento,id_pagina),";
$sql .= "foreign key (id_pagina) references ".DODBPREFIX."paginas(id_pagina) ON DELETE CASCADE ON UPDATE CASCADE";
$sql .= ")$charset_collate;";
$wpdb->query($sql);
// Comprobación
if(!$wpdb->get_var( "show tables like '$tabla'")) {
	update_option( "init_check","DocOnline: error al crear la tabla $tabla");
	return;
}
*/

/* valores por defecto */

// VARIOS
$tabla = DODBPREFIX."varios";
$formatos = array ('%s','%s','%s','%s','%s');

// indicaré un ejemplo de límites de tiempo que podrá estar un anuncio según el tipo y pantalla
// también un servicio que puede ofrecer BMarket
$valores = array (
	// tipos de documento
	array (
		'dominio' => 'documento',
		'concepto' => 'plantilla',
		'patron' => 'A3',
		'valor' => '594x420', // tamaño
		'extra' => 'mm', // unidades de medida
	),
	array (
		'dominio' => 'documento',
		'concepto' => 'plantilla',
		'patron' => 'A4',
		'valor' => '297x210', // tamaño
		'extra' => 'mm', // unidades de medida
	),
	array (
		'dominio' => 'documento',
		'concepto' => 'plantilla',
		'patron' => 'CARPETA A',
		'valor' => '310x220', // tamaño
		'extra' => 'mm', // unidades de medida
	),
	array (
		'dominio' => 'documento',
		'concepto' => 'plantilla',
		'patron' => 'FOLLETO A',
		'valor' => '210x99', // tamaño
		'extra' => 'mm', // unidades de medida
	),
	array (
		'dominio' => 'documento',
		'concepto' => 'plantilla',
		'patron' => 'SOBRE A',
		'valor' => '260x182', // tamaño
		'extra' => 'mm', // unidades de medida
	),
	
);

foreach($valores as $valor) {
	if(!$wpdb->insert($tabla,$valor,$formatos)) {
		update_option( "init_check","DocOnline: error al alimentar la tabla $tabla");
		return;
	}
}
$valores = NULL; // limpieza

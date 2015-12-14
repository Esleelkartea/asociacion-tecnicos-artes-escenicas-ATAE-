<?php
/****************************************************************************************************/
/* Pantalla: _filtros.php
/* Theme: doconline
/* Descripción: filtros para el listado...
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	26/03/2012	Creación               
/*
/****************************************************************************************************/

$filtros = array (
	// codigo
	'codigo' => array (
		'nombre' => 'Código',
		'tipo' => 'like',
		'max' => 20,
		'size' => 20,
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// referencia
	'referencia' => array (
		'nombre' => 'Referencia',
		'tipo' => 'like',
		'max' => 20,
		'size' => 20,
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// tipo
	'tipo' => array (
		'nombre' => 'Tipo',
		'tipo' => 'select',
		'opciones' => NULL,
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// nombre
	'nombre' => array (
		'nombre' => 'Nombre',
		'tipo' => 'like',
		'max' => 20,
		'size' => 20,
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// alta
	'fec_alta_desde' => array (
		'nombre' => 'Alta posterior a',
		'tipo' => 'date-mayor-igual',
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	'fec_alta_hasta' => array (
		'nombre' => 'Alta previa a',
		'tipo' => 'date-menor-igual',
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// usuario
	'id_usuario' => array (
		'nombre' => 'Usuario',
		'tipo' => 'fk-like-usuario',
		'max' => 20,
		'size' => 10,
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// estado
	'estado' => array (
		'nombre' => 'Estado',
		'tipo' => 'select',
		'opciones' => array('' => 'sin filtros','nuevo' => 'nuevo','pagado' => 'definitivo','anulado' => 'anulado'),
		'meta' => 'N',
		'comillas' => 'S',
		'formato' => '%s',
		'default' => NULL,
	),
	// ORDEN
	'orderBy' => array (
		'nombre' => 'Ordenar por',
		'tipo' => 'orderBy',
		'opciones' => array('fec_alta' => 'Fecha de alta','codigo' => 'Código de documento','estado' => 'Estado'),
		'comillas' => 'S',
		'formato' => '%s',
		'default' => 'fec_pago',
	),
	'ascDesc' => array (
		'nombre' => 'Tipo de orden',
		'tipo' => 'ascDesc',
		'opciones' => array('desc' => 'Descendente','asc' => 'Acendente'),
		'comillas' => 'S',
		'formato' => '%s',
		'default' => 'desc',
	),
	
);

// los tipos
$tipos = Datos::getTipoDocumentos();
$opciones = array();
$opciones[""] = 'sin filtros';
foreach($tipos as $cTipo => $dTipo) $opciones[$cTipo] = $dTipo['nombre'];
$filtros['tipo']['opciones'] = $opciones;

// obtenemos el valor
foreach($filtros as $cFiltro => $dFiltro) {
	$nFiltro = 'filtro_'.$cFiltro;
	$filtros[$cFiltro]['valor'] = ($_POST[$nFiltro] != NULL) ? $_POST[$nFiltro] : $filtros[$cFiltro]['default'];
}

// en caso de ser suscriptor
if($userData['rol'] != 'Administrator') {
	// algo
	$filtros['id_usuario']['tipo'] = 'fijo';
	$filtros['id_usuario']['valor'] = $userData['id'];
}

$pFlags['oculto_filtros'] = ($_POST['oculto_filtros'] && $_POST['oculto_filtros'] != NULL) ? $_POST['oculto_filtros'] : 'oculto';

?>
<div class="ventana-pagina">
	<div class="titulo-pagina">
		<div class="icono-titulo-pagina">
			<a id="mostrar-filtros" href="#"><img border="0" id="img-mostrar-filtros" class="img-desplegar" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/cerrar.gif'; ?>" /></a>
		</div>
		<p>Filtros</p>
	</div>
	<div id="filtros-pantalla" class="contenido-gestion <?php echo $pFlags['oculto_filtros']; ?>">
		<input type="hidden" name="oculto_filtros" id="oculto_filtros" value="<?php echo $pFlags['oculto_filtros']; ?>" />
		<?php
		$contenido = Campos::makeFiltros($filtros,$campos['prefijo']);
		if(!$contenido) $errores[] = 'Error al crear los filtros';
		else {
			echo $contenido;
		?>
		<div class="botonera">
			<input type="button" class="boton" name="filtrar" id="filtrar" value="Filtrar" onclick="javascript:filtrarDatos();" />
		</div>
		<?php
		}
		?>
	</div>

</div>


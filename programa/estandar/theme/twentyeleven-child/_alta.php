<?php
/****************************************************************************************************/
/* Include: _alta.php
/* Plugin: doconline
/* Descripción: include con el módulo de alta
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	12/03/2012	Creación               
/*
/****************************************************************************************************/

// obtenemos los datos de los tipos
$tipos = Datos::getTipoDocumentos();
$opTipos = array();
foreach($tipos as $tipo => $dTipo) $opTipos[$tipo] = $dTipo['nombre'];

$pFlags['oculto_alta'] = ($_POST['oculto_alta'] && $_POST['oculto_alta'] != NULL) ? $_POST['oculto_alta'] : 'oculto';

// Documentos en los que basarse:
$filtros = ' order by codigo ';
$r = Datos::getDocumentos($filtros,NULL,NULL);
$otrosDoc = array('' => 'Sin referencia');
if(is_array($r)) foreach($r as $registro) $otrosDoc[$registro['id_documento']] = $registro['codigo'];

$campos = array (
	0 => array (
		'nombre' => 'datos del documento',
		'campos' => array (
			'codigo' => array (
				'nombre' => 'Código de referencia interno*',
				'tipo' => 'autoref',
				'title' => 'El valor lo da la aplicación',
				'max' => 20,
				'size' => 20,
				'notnull' => 'N',
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
				'readonly' => 'S',
			),
			'version' => array (
				'nombre' => 'Versión del documento',
				'tipo' => 'vchar',
				'title' => NULL,
				'max' => 10,
				'size' => 8,
				'notnull' => 'N',
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
				'readonly' => 'N',
			),
			'referencia' => array (
				'nombre' => 'Código de referencia propio',
				'tipo' => 'vchar',
				'title' => 'El valor lo da el dueño',
				'max' => 50,
				'size' => 30,
				'notnull' => 'N',
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
				'readonly' => 'N',
			),
			'tipo' => array (
				'nombre' => 'Tipo',
				'tipo' => 'select',
				'title' => 'Tipo de documento',
				'opciones' => $opTipos,
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
				'especial' => 'chgMedidas',
			),
			'nombre' => array (
				'nombre' => 'Nombre del documento',
				'tipo' => 'vchar',
				'max' => 50,
				'size' => 30,
				'notnull' => 'S',
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
			),
			'descripcion' => array (
				'nombre' => 'Descripción del documento',
				'tipo' => 'text',
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
			),
			'numerada' => array (
				'nombre' => 'Documento numerado',
				'tipo' => 'select',
				'opciones' => array('N' => 'No', 'S' => 'Si'),
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
			),
		),
	),
	1 => array (
		'nombre' => 'detalles del documento',
		'campos' => array (
			'alto' => array (
				'nombre' => 'Alto',
				'tipo' => 'float',
				'max' => 20,
				'size' => 8,
				'notnull' => 'S',
				'meta' => 'N',
				'comillas' => 'N',
				'formato' => '%f',
				'valor' => $tipos['A4']['alto'],
			),
			'ancho' => array (
				'nombre' => 'Ancho',
				'tipo' => 'float',
				'max' => 20,
				'size' => 8,
				'notnull' => 'S',
				'meta' => 'N',
				'comillas' => 'N',
				'formato' => '%f',
				'valor' => $tipos['A4']['ancho'],
			),
		),
	),
	2 => array (
		'nombre' => 'documento referencial',
		'campos' => array (
			'idReferencia' => array (
				'nombre' => 'Documento...',
				'tipo' => 'select',
				'title' => 'Documento en el que basarse',
				'opciones' => $otrosDoc,
				'meta' => 'N',
				'comillas' => 'S',
				'formato' => '%s',
				'especial' => 'docBase',
			),
		),
	),
);


?>
<script language="javascript">
var medidaDocumentos = new Array;
<?php foreach($tipos as $tipo => $dTipo) { ?>
medidaDocumentos['<?php echo $tipo; ?>'] = new Array;
medidaDocumentos['<?php echo $tipo; ?>']['alto'] = <?php echo $dTipo['alto']; ?>;
medidaDocumentos['<?php echo $tipo; ?>']['ancho'] = <?php echo $dTipo['ancho']; ?>;
<?php } ?>
function chgMedidas() {
	var tipo = document.getElementById("new_tipo").value;
	document.getElementById("new_alto").value = medidaDocumentos[tipo]['alto'];
	document.getElementById("new_ancho").value = medidaDocumentos[tipo]['ancho'];
}
</script>
<div class="ventana-pagina">
	<div class="titulo-pagina">
		<div class="icono-titulo-pagina">
			<a id="mostrar-alta" href="#"><img border="0" id="img-mostrar-alta" class="img-desplegar" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/cerrar.gif'; ?>" /></a>
		</div>
		<p>Alta de documento</p>
	</div>
	<div id="alta-pantalla" class="contenido-gestion <?php echo $pFlags['oculto_alta']; ?>">
		<input type="hidden" name="oculto_alta" id="oculto_alta" value="<?php echo $pFlags['oculto_alta']; ?>" />
		<?php
		echo Campos::makeCampos($campos);
		?>
		<div class="botonera">
			<input type="button" class="boton" name="crear" id="crear" value="Crear" onclick="javascript:crearRegistro();" />
		</div>
	</div>

</div>

<?php
/****************************************************************************************************/
/* Include: _listado.php
/* Plugin: doconline
/* Descripción: include con el listado
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	12/03/2012	Creación               
/*
/****************************************************************************************************/

$camposLista = array();
$camposLista['codigo'] = array(
	'nombre' => __('R. Interna'),
	'titulo' => __('Código de referencia interna'),
	'width' => 120,
	'align' => 'left',
	'max' => 18,
);
$camposLista['version'] = array(
	'nombre' => __('Vr.'),
	'titulo' => __('Versión'),
	'width' => 40,
	'align' => 'left',
	'max' => 8,
);
$camposLista['nombre'] = array(
	'nombre' => __('Nombre'),
	'titulo' => __('Nombre del documento'),
	'width' => NULL,
	'align' => 'left',
	'max' => 16,
);
$camposLista['tipo'] = array(
	'nombre' => __('Tipo'),
	'titulo' => NULL,
	'width' => 70,
	'align' => 'left',
	'max' => 14,
);
$camposLista['alto'] = array(
	'nombre' => __('Alto'),
	'titulo' => __('Atura del documento en milímetros'),
	'width' => 40,
	'align' => 'left',
	'max' => NULL,
);
$camposLista['ancho'] = array(
	'nombre' => __('Ancho'),
	'titulo' => __('Ancho del documento en milímetros'),
	'width' => 40,
	'align' => 'left',
	'max' => NULL,
);
if($userData['rol'] == 'Administrator') {
	$camposLista['id_usuario'] = array(
		'nombre' => __('Usuario'),
		'titulo' => __('Usuario que ha creado el documento'),
		'width' => 120,
		'align' => 'left',
		'max' => 18,
	);
	$camposLista['estado'] = array(
		'nombre' => __('Estado'),
		'titulo' => __('Estado del documento. Solo se podrá imprimir documentos Nuevos y definitivos. Los nuevos llevarán marca de agua'),
		'width' => 120,
		'align' => 'left',
		'max' => NULL,
	);
}

// los filtros:
$where = Campos::makeWhere($filtros);
// Order By dinámico, DCS a 16/02/2012
$nOrderBy = 'filtro_orderBy';
$vOrderBy = ($_POST[$nOrderBy] != NULL) ? $_POST[$nOrderBy] : 'id_documento';
$nAscDesc = 'filtro_ascDesc';
$vAscDesc = ($_POST[$nAscDesc] != NULL) ? $_POST[$nAscDesc] : 'desc';
$orderByListado = 'order by '.$vOrderBy.' '.$vAscDesc;
$where .= ' '.$orderByListado;

?>
<div class="ventana-pagina">
	<div class="titulo-pagina">
		<?php if(RCOUNT != NULL && RCOUNT > 0) include('_pag.php'); ?>
		<p>Listado de documentos</p>
	</div>
	<div class="listado">
		<table class="tabla-cabecera" align="center" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<?php
			foreach ($camposLista as $i => $value) {
				$td = '<td class="cabecera"';
				if($value['titulo'] != NULL) $td .= ' title="'.$value['titulo'].'" style="cursor:help;"';
				if($value['width'] != NULL) $td .= ' width="'.$value['width'].'"';
				$td .= ($value['width'] != NULL) ? '><p style="width:'.$value['width'].'px;">'.$value['nombre'].'</p></td>' : '><p>'.$value['nombre'].'</p></td>';
				echo "\t\t\t".$td."\n";
			}
			$numCols = count($camposLista) + 1;
			?>
			<td class="cabecera" width="110"><p style="width: 110px;">acciones</p></td>
		</tr>
		<?php
		// hallamos registros
		$orden = 'nombre';
		$registros = Datos::getDocumentos($where,RCOUNT,$pagActual);
		?>
		<?php if(!is_array($registros) || count($registros) == 0) { ?>
		<tr>
			<td>&nbsp;</td>
			<td class="row-impar" colspan="<?php echo $numCols; ?>"><p><?php echo __("No hay documentos creados");?></p></td>
		</tr>
		<?php } else { // else if de count para rows ?>
		<?php
		$c = 0;
		?>
		<?php foreach($registros as $registro) { ?>
		<?php
		$c++;
		$odd = ($c%2==0) ? 'row-par' : 'row-impar';
		?>
		<tr>
			<?php
			foreach ($camposLista as $iCampo => $dCampo) {		
				$txt = NULL;
				switch($iCampo) {
					case 'id_usuario':
						$txt = Datos::getUserName($registro[$iCampo]);
						break;
					case 'estado':
						$txt = '<select class="elige" style="margin-top: 0; margin-bottom: 6px; padding: 0;" name="estado-listado-'.$registro['id_documento'].'" id="estado-listado-'.$registro['id_documento'].'">';
						$opciones = array(
							'nuevo' => 'nuevo',
							'pagado' => 'definitivo',
							'anulado' => 'anulado',
						);
						foreach($opciones as $cOpcion => $dOpcion) {
							$selected = ($cOpcion == $registro[$iCampo]) ? 'selected="selected"' : '';
							$txt .= '<option value="'.$cOpcion.'" '.$selected.'>'.$dOpcion.'</option>';
						}
						$txt .= '</select>';
						break;
					default:
						$txt = $registro[$iCampo];
						break;
					
				}
				$td = '<td class="'.$odd.'"';
				if($dCampo['width'] != NULL) $td .= ' width="'.$dCampo['width'].'"';
				if($dCampo['align'] != NULL) $td .= ' align="'.$dCampo['align'].'"';
				$td .= '>';
				if($dCampo['max'] != NULL) {
					$tLen = strlen($txt);
					$txt = ($tLen > $dCampo['max']) ? '<p style="cursor: help; width: '.$dCampo['width'].'px" title="'.$txt.'">'.substr($txt,0,$dCampo['max']).'...</p>' : '<p style="width: '.$dCampo['width'].'px">'.$txt.'</p>';
				} else $txt = '<p style="width: '.$dCampo['width'].'px">'.$txt.'</p>';
				$td .= $txt.'</td>';
				echo $td;
			}
			?>		
			<td class="<?php echo $odd; ?>" width="110">
				<div class="botonera-row">
					<a class="link-editar-documento" rel="<?php echo $registro['id_documento']; ?>">
					<img border="0" class="img-accion" alt="editar" title="editar" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/edit.gif'; ?>" />
					</a>
					<a href="javascript:borrar(<?php echo $registro['id_documento']; ?>);">
					<img border="0" class="img-accion" alt="borrar" title="borrar" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/delete.gif'; ?>" />
					</a>		
					<a href="javascript:imprimir(<?php echo $registro['id_documento']; ?>);">
					<img border="0" class="img-accion" alt="descargar" title="descargar" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/descargar.gif'; ?>" />
					</a>									
					<?php if($userData['rol'] == 'Administrator') { ?>
					<a href="javascript:guardar(<?php echo $registro['id_documento']; ?>);">
					<img border="0" class="img-accion" alt="guardar" title="guardar" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/guardar.gif'; ?>" />
					</a>		
					<a href="javascript:chgEstado(<?php echo $registro['id_documento']; ?>);">
					<img border="0" class="img-accion" alt="modificar estado" title="modificar estado" src="<?php echo WP_CONTENT_URL.'/themes/'.NTHEME.'/images/iconos/ok.gif'; ?>" />
					</a>
					<?php } ?>
				</div>
			</td>	
		</tr>
		<?php } // end foreach de rows ?>
		<?php } // end if de count para rows ?>
		</table>
		<!--
		<script>
		function prImprimir() {
			document.getElementById("docId").value = "pruebas";
			document.getElementById("accion").value = "pr-imprimir";
			document.forms["formDOP"].target="_blank";
			document.forms["formDOP"].action = document.getElementById("urlContent").value + "/themes/twentyeleven-child/pdf.php";
			document.forms["formDOP"].submit();
			document.forms["formDOP"].target="";
			document.forms["formDOP"].action="";
		}
		</script>
		<input type="button" value="prImprimir" onclick="prImprimir();" />
		-->
	</div>
</div>
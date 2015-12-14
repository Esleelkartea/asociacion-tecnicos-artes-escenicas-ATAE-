<?php
/****************************************************************************************************/
/* Include: _pag.php
/* Plugin: doconline
/* Descripción: include con la paginación del listado
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		09/03/2012	Creación               
/*
/****************************************************************************************************/

$pagTotales = 0;
$offset = 0;
$pagActual = 1;
if(isset($_POST['pagActual']) && $_POST['pagActual'] != NULL) $pagActual = $_POST['pagActual'];
// Hallamos los registros totales:
$totales = Datos::getTotalDocumentos($userData['id']);

$pagTotales = ceil($totales / RCOUNT);
$offset = ($pagActual - 1) * RCOUNT;

if($totales > 0) {
?>
<div class="paginacion">
	<input type="hidden" name="pagActual" id="pagActual" value="<?php echo $pagActual; ?>" />
	<?php	if($pagActual > 1) { ?>
	<a href="javascript:paginar('principal',1,<?php echo $pagTotales; ?>);" title="primera">&lt;&lt;</a>
	&nbsp;
	<a href="javascript:paginar('principal',2,<?php echo $pagTotales; ?>);" title="anterior">&lt;</a>
	&nbsp;
	<?php } ?>
	<?php echo $pagActual; ?> / <?php echo $pagTotales;?>
	<?php if($pagActual < $pagTotales) { ?>
	&nbsp;
	<a href="javascript:paginar('principal',3,<?php echo $pagTotales; ?>);" title="siguiente">&gt;</a>
	&nbsp;
	<a href="javascript:paginar('principal',4,<?php echo $pagTotales; ?>);" title="última">&gt;&gt;</a>
	<?php } ?>
</div>
<?php
}
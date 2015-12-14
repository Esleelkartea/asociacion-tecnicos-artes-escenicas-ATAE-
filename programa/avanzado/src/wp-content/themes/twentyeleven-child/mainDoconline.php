<?php
/****************************************************************************************************/
/* Pantalla: mainhDoconline.php
/* Theme: doconline
/* Descripción: cuerpo del template para la página de documentación on-line
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		05/03/2012	Creación               
/*
/****************************************************************************************************/

?>
<form name="formDOP" id="formDOP" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="urlContent" id="urlContent" value="<?php echo WP_CONTENT_URL; ?>" />
<input type="hidden" name="estado-listado" id="estado-listado" value="" />
<input type="hidden" name="docId" id="docId" value="" />
<input type="hidden" name="accion" id="accion" value="" />
<?php include('_filtros.php'); ?>
<?php include('_listado.php'); ?>
<div id="mensajes-doc"></div>
<?php include('_alta.php'); // temporalmente para pruebas ?>
<?php include('_modal.php'); ?>

</form>
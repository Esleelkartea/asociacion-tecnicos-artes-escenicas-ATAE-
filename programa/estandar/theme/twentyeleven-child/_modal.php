<?php
/****************************************************************************************************/
/* Pantalla: _modal.php
/* Theme: doconline
/* Descripción: prepara la pantalla modal
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		07/03/2012	Creación               
/*
/****************************************************************************************************/

?>
		
<!-- modal content -->
<input type="hidden" name="idDocumento" id="idDocumento" value="" />
<input type="hidden" name="idPagina" id="idPagina" value="" />
<input type="hidden" name="idElemento" id="idElemento" value="" />
<input type="hidden" name="contenidoDoc" id="contenidoDoc" value="" />
<input type="hidden" name="contenidoPag" id="contenidoPag" value="" />
<input type="hidden" name="contenidoEle" id="contenidoEle" value="" />
<input type="hidden" name="hPagMm" id="hPagMm" value="" />
<input type="hidden" name="hPagPx" id="hPagPx" value="" />
<input type="hidden" name="flagModificado" id="flagModificado" value="N" />
<div id="estilos-modal"><style></style></div>
<div id="basic-modal-content" style="position: absolute;">
	<div id="cuadro-mando">
		<div id="tabs">
		<ul>
			<li id="li-tabs-documento"><a href="#tabs-documento">Documento</a></li>
			<li id="li-tabs-pagina"><a href="#tabs-pagina">Página</a></li>
			<li id="li-tabs-detalle"><a href="#tabs-detalle">Detalle</a></li>
			<li id="li-tabs-contenido"><a href="#tabs-contenido">Contenido</a></li>
		</ul>
		<?php
		include('_tabDocumento.php');
		include('_tabPagina.php');
		include('_tabDetalle.php');
		include('_tabContenido.php');
		?>
		</div>
		<div><input type="button" value="ver cfuente" onclick="javascript:alert(document.getElementById('contenido-documento').innerHTML);" /></div>
	</div>
	<div id="marco-documento">
		<div id="contenido-documento" style="position: relative;">
		</div>
	</div>
</div>

<!-- preload the images -->
<div style='display:none'>
	<img src='<?php echo WP_CONTENT_URL.'/themes/'.NTHEME; ?>/plugins/simplemodal/basic/img/basic/x.png' alt='' />
</div>
		
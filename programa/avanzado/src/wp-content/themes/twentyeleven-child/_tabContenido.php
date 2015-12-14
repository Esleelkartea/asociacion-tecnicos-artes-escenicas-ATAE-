<?php
/****************************************************************************************************/
/* Pantalla: _tabContenido.php
/* Theme: doconline
/* Descripción: pestaña de detalle
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	15/03/2012	Creación               
/*
/****************************************************************************************************/

?>
<div id="tabs-contenido">
	<div class="seccion-titulo"><p>Contenido</p></div>
	<div class="seccion-tabla">
		<input type="hidden" name="elem_contenido" id="elem_contenido" value="" />
		<textarea id="editor" name="editor" class="texto" cols="20" rows="10"></textarea>
		<div style="height: 30px;">
			<div class="ui-state-default ui-corner-all icono" style="margin-right: 14px;" title="Copiar el texto">
				<span class="ui-icon ui-icon-check enviar-texto"></span>
			</div>
		</div>
	</div>
</div>
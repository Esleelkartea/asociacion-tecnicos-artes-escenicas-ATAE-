<?php
/****************************************************************************************************/
/* Pantalla: _tabDetalle.php
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
<div id="tabs-detalle" style="min-height: 310mm;">
	<!-- Datos propios -->
	<?php
	$wCampo = 50;
	$wAcciones = 50;
	?>
	<div class="seccion-titulo"><p>Datos propios</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Código -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Código</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="elem_codigo" name="elem_codigo" readonly="readonly" size="22" value="" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Eliminar elemento">
					<span class="ui-icon ui-icon-trash eliminar-elemento"></span>
					</div>
				</td>
			</tr>
			<!-- Tipo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Tipo</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="elem_tipo" name="elem_tipo" readonly="readonly" size="18" value="" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">&nbsp;</td>
			</tr>
		</table>
	</div>
	<!-- Datos estructurales -->
	<?php
	$wCampo = 50;
	$wAcciones = 50;
	?>
	<div class="seccion-titulo"><p>Datos estructurales</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Alto -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Alto</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_alto" name="elem_alto" class="text valor-celda float elem-modificable" size="8" maxlength="30" value="50" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el alto">
						<span class="ui-icon ui-icon-plus sumar-alto-elemento bot-modificador" rel="elem_alto"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el alto">
						<span class="ui-icon ui-icon-minus restar-alto-elemento bot-modificador" rel="elem_alto"></span>
					</div>
				</td>
			</tr>
			<!-- Ancho -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Ancho</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_ancho" name="elem_ancho" class="text valor-celda float elem-modificable" size="8" maxlength="30" value="50" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Aumentar el ancho">
						<span class="ui-icon ui-icon-plus sumar-alto-elemento bot-modificador" rel="elem_ancho"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el ancho">
						<span class="ui-icon ui-icon-minus restar-alto-elemento bot-modificador" rel="elem_ancho"></span>
					</div>
				</td>
			</tr>
			<!-- Top -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Posición superior (solo afecta a los elementos libres)">Pos. S.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_dtop" name="elem_dtop" class="info" size="8" maxlength="30" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<!--
					<div class="ui-state-default ui-corner-all icono" title="Ampliar posición superior">
						<span class="ui-icon ui-icon-plus sumar-top" rel="elem_dtop"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir posición superior">
						<span class="ui-icon ui-icon-minus restar-top" rel="elem_dtop"></span>
					</div>
					-->
				</td>
			</tr>
			<!-- Left -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Posición izquierda (solo afecta a los elementos libres)">Pos. I.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_dleft" name="elem_dleft" class="info" size="8" maxlength="30" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<!--
					<div class="ui-state-default ui-corner-all icono" title="Ampliar posición izquierda">
						<span class="ui-icon ui-icon-plus sumar-top" rel="elem_dleft"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir posición izquierda">
						<span class="ui-icon ui-icon-minus restar-top" rel="elem_dleft"></span>
					</div>
					-->
				</td>
			</tr>
			<!-- z-index -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Visibilidad con respecto a otros elementos">Vis.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_zindex" name="elem_zindex" class="text valor-celda float elem-modificable" size="8" maxlength="30" value="1000" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar visibilidad">
						<span class="ui-icon ui-icon-plus sumar-visibilidad bot-modificador" rel="elem_zindex"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir visibilidad">
						<span class="ui-icon ui-icon-minus restar-visibilidad bot-modificador" rel="elem_zindex"></span>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<!-- Datos de margen -->
	<?php
	$wCampo = 50;
	$wAcciones = 50;
	?>
	<div class="seccion-titulo"><p>Datos de margen</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Margen superior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen superior">M. Sup.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_mtop" name="elem_mtop" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_mtop"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_mtop"></span>
					</div>
				</td>
			</tr>
			<!-- Margen derecho -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen derecho">M. Der.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_mright" name="elem_mright" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_mright"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_mright"></span>
					</div>
				</td>
			</tr>
			<!-- Margen inferior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen inferior">M. Inf.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_mbottom" name="elem_mbottom" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_mbottom"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_mbottom"></span>
					</div>
				</td>
			</tr>
			<!-- Margen izquierdo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen izquierdo">M. Izq.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_mleft" name="elem_mleft" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_mleft"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_mleft"></span>
					</div>
				</td>
			</tr>
			<!-- Padding superior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) superior">P. Sup.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_ptop" name="elem_ptop" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_ptop"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_ptop"></span>
					</div>
				</td>
			</tr>
			<!-- Padding derecho -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) derecho">P. Der.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_pright" name="elem_pright" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_pright"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_pright"></span>
					</div>
				</td>
			</tr>
			<!-- Padding inferior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) inferior">P. Inf.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_pbottom" name="elem_pbottom" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_pbottom"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_pbottom"></span>
					</div>
				</td>
			</tr>
			<!-- Padding izquierdo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) izquierdo">P. Izq.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_pleft" name="elem_pleft" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen bot-modificador" rel="elem_pleft"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen bot-modificador" rel="elem_pleft"></span>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<!-- Datos de composición -->
	<?php
	$wCampo = 50;
	$wAcciones = 50;
	?>
	<div class="seccion-titulo"><p>Datos de composición</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- borde -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Grosor del borde">Borde</p></td>
				<td class="seccion-celda-valor">
					<input type="text" id="elem_borde" name="elem_borde" class="text valor-celda int elem-modificable" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el borde">
						<span class="ui-icon ui-icon-plus sumar-borde bot-modificador" rel="elem_borde"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el borde">
						<span class="ui-icon ui-icon-minus restar-borde bot-modificador" rel="elem_borde"></span>
					</div>
				</td>
			</tr>
			<!-- color de borde -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Color del borde">C. Borde</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="color {hash:true} texto elem-modificable" name="elem_cborde" id="elem_cborde" value="#000000" size="6" maxlength="7" readonly="readonly" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<input type="checkbox" id="elem_flg_cborde" name="elem_flg_cborde" class="elem-modificable" value="MC" title="Mostrar Color" />
				</td>
			</tr>
			<!-- color de fondo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Color del fondo">C. Fondo</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="color {hash:true} texto elem-modificable" name="elem_cfondo" id="elem_cfondo" value="#FFFFFF" size="6" maxlength="7" readonly="readonly" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<input type="checkbox" id="elem_flg_cfondo" name="elem_flg_cfondo" class="elem-modificable" value="MC" title="Mostrar Color" />
				</td>
			</tr>
		</table>
	</div>
	<!-- Fondo -->
	<div class="seccion-titulo"><p>Detalles de fondo</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- imagen de fondo por tinyMCE -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help; width: <?php echo $wCampo; ?>px" title="Imagen de fondo por tinyMCE">I. Fondo</p></td>
				<td class="seccion-celda-valor">
					<textarea id="txtSelFondo" name="txtSelFondo"></textarea>
				</td>
			</tr>
			<!-- Repetición de la imágen fondo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Repetición de la imágen de fondo">R. Fondo</p></td>
				<td class="seccion-celda-valor">
					<select class="elige elem-modificable" id="elem_rfondo" name="elem_rfondo">
					<option value="no">sin repeticón</option>
					<option value="x">repetir horizontalmente</option>
					<option value="y">repetir verticalmente</option>
					<option value="xy">repetir horizontal y verticalmente</option>
					</select>
				</td>
			</tr>
			<!-- Posición de la imágen fondo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Posición de la imágen de fondo">P. Fondo</p></td>
				<td class="seccion-celda-valor">
					<select class="elige elem-modificable" id="elem_pfondo" name="elem_pfondo">
					<option value="no">sin imagen de fondo</option>
					<option value="">sin indicar</option>
					<option value="lt">Izquierda Superior</option>
					<option value="lc">Izquierda Central</option>
					<option value="lb">Izquierda Inferior</option>
					<option value="rt">Derecha Superior</option>
					<option value="rc">Derecha Central</option>
					<option value="rb">Derecha Inferior</option>
					<option value="ct">Centrado Superior</option>
					<option value="cc">Centrado Central</option>
					<option value="cb">Centrado Inferior</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<!-- Acciones -->
	<div class="seccion-titulo"><p>Acciones de fondo</p></div>
	<div class="seccion-tabla">
		<div class="seccion-tabla-acciones">
			<div class="ui-state-default ui-corner-all icono" title="Subir fondo">
			<span class="ui-icon ui-icon-circle-plus subir-fondo"></span>
			</div>
			<div class="ui-state-default ui-corner-all icono" title="Actualizar fondo">
			<span class="ui-icon ui-icon-circle-minus vaciar-fondo"></span>
			</div>
		</div>
	</div>
	<!-- Contenido -->
	<!--
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
	-->
</div>
<?php
/****************************************************************************************************/
/* Pantalla: _tabPagina.php
/* Theme: doconline
/* Descripción: pestaña de página
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	15/03/2012	Creación               
/*
/****************************************************************************************************/

?>
<div id="tabs-pagina">
	<!-- Datos propios -->
	<div class="seccion-titulo"><p>Datos propios</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Código -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Código</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="pag_codigo" name="pag_codigo" readonly="readonly" size="22" value="" />
				</td>
			</tr>
			<!-- Tipo -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Tipo</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="pag_tipo" name="pag_tipo" readonly="readonly" size="18" value="" />
				</td>
			</tr>
			<!-- Referencia -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Referencia externa">Ref.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="texto flagable" id="pag_referencia" name="pag_referencia" size="16" maxlength="20" value="" />
				</td>
			</tr>
			<!-- Numero -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Número de página">Num.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="pag_numero" name="pag_numero" readonly="readonly" size="6" value="" />
				</td>
			</tr>
		</table>
	</div>
	<!-- Acciones -->
	<div class="seccion-titulo"><p>Acciones</p></div>
	<div class="seccion-tabla">
		<div class="seccion-tabla-acciones">
			<div class="ui-state-default ui-corner-all icono" title="Aceptar los cambios">
			<span class="ui-icon ui-icon-disk aceptar-cambios-pagina"></span>
			</div>
		</div>
	</div>
	<!-- Elementos -->
	<?php
	$wCampo = 50;
	$wAcciones = 50;
	?>
	<div class="seccion-titulo"><p>Crear elemento</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Tipo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Tipo</p></td>
				<td class="seccion-celda-valor">
					<select class="elige flagable" id="div_f_tipo" name="div_f_tipo">
					<option value="libre">libre</option>
					<option value="fijo">fijo</option>
					</select>
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Crear elemento">
					<span class="ui-icon ui-icon-circle-check crear-div-f"></span>
					</div>
				</td>
			</tr>
			<!-- Alto -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Alto</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_alto" name="div_f_alto" class="text valor-celda float" size="8" maxlength="30" value="50" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el alto">
						<span class="ui-icon ui-icon-plus sumar-alto-elemento" rel="div_f_alto"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el alto">
						<span class="ui-icon ui-icon-minus restar-alto-elemento" rel="div_f_alto"></span>
					</div>
				</td>
			</tr>
			<!-- Ancho -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p>Ancho</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_ancho" name="div_f_ancho" class="text valor-celda float" size="8" maxlength="30" value="50" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Aumentar el ancho">
						<span class="ui-icon ui-icon-plus sumar-alto-elemento" rel="div_f_ancho"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el ancho">
						<span class="ui-icon ui-icon-minus restar-alto-elemento" rel="div_f_ancho"></span>
					</div>
				</td>
			</tr>
			<!-- Top -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Posición superior (solo afecta a los elementos libres)">Pos. S.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_dtop" name="div_f_dtop" class="text valor-celda float" size="8" maxlength="30" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar posición superior">
						<span class="ui-icon ui-icon-plus sumar-top" rel="div_f_dtop"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir posición superior">
						<span class="ui-icon ui-icon-minus restar-top" rel="div_f_dtop"></span>
					</div>
				</td>
			</tr>
			<!-- Left -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Posición izquierda (solo afecta a los elementos libres)">Pos. I.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_dleft" name="div_f_dleft" class="text valor-celda float" size="8" maxlength="30" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar posición izquierda">
						<span class="ui-icon ui-icon-plus sumar-top" rel="div_f_dleft"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir posición izquierda">
						<span class="ui-icon ui-icon-minus restar-top" rel="div_f_dleft"></span>
					</div>
				</td>
			</tr>
			<!-- z-index -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Visibilidad con respecto a otros elementos">Vis.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_zindex" name="div_f_zindex" class="text valor-celda float" size="8" maxlength="30" value="1000" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar visibilidad">
						<span class="ui-icon ui-icon-plus sumar-visibilidad" rel="div_f_zindex"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir visibilidad">
						<span class="ui-icon ui-icon-minus restar-visibilidad" rel="div_f_zindex"></span>
					</div>
				</td>
			</tr>
			<!-- Margen superior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen superior">M. Sup.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_mtop" name="div_f_mtop" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_mtop"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_mtop"></span>
					</div>
				</td>
			</tr>
			<!-- Margen derecho -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen derecho">M. Der.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_mright" name="div_f_mright" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_mright"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_mright"></span>
					</div>
				</td>
			</tr>
			<!-- Margen inferior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen inferior">M. Inf.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_mbottom" name="div_f_mbottom" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_mbottom"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_mbottom"></span>
					</div>
				</td>
			</tr>
			<!-- Margen izquierdo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Margen izquierdo">M. Izq.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_mleft" name="div_f_mleft" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_mleft"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_mleft"></span>
					</div>
				</td>
			</tr>
			<!-- Padding superior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) superior">P. Sup.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_ptop" name="div_f_ptop" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_ptop"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_ptop"></span>
					</div>
				</td>
			</tr>
			<!-- Padding derecho -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) derecho">P. Der.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_pright" name="div_f_pright" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_pright"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_pright"></span>
					</div>
				</td>
			</tr>
			<!-- Padding inferior -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) inferior">P. Inf.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_pbottom" name="div_f_pbottom" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_pbottom"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_pbottom"></span>
					</div>
				</td>
			</tr>
			<!-- Padding izquierdo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Padding (margen interior) izquierdo">P. Izq.</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_pleft" name="div_f_pleft" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el margen">
						<span class="ui-icon ui-icon-plus sumar-margen" rel="div_f_pleft"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el margen">
						<span class="ui-icon ui-icon-minus restar-margen" rel="div_f_pleft"></span>
					</div>
				</td>
			</tr>
			<!-- borde -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Grosor del borde">Borde</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="div_f_borde" name="div_f_borde" class="text valor-celda int" size="2" maxlength="2" value="0" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">
					<div class="ui-state-default ui-corner-all icono" title="Ampliar el borde">
						<span class="ui-icon ui-icon-plus sumar-borde" rel="div_f_borde"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir el borde">
						<span class="ui-icon ui-icon-minus restar-borde" rel="div_f_borde"></span>
					</div>
				</td>
			</tr>
			<!-- color de borde -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Color del borde">C. Borde</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="color {hash:true} texto flagable" name="div_f_cborde" id="div_f_cborde" value="#000000" size="6" maxlength="7" readonly="readonly" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">&nbsp;</td>
			</tr>
			<!-- color de fondo -->
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Color del fondo">C. Fondo</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="color {hash:true} texto flagable" name="div_f_cfondo" id="div_f_cfondo" value="#FFFFFF" size="6" maxlength="7" readonly="readonly" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">&nbsp;</td>
			</tr>
			<!-- imagen de fondo -->
			<!--
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help; width: <?php echo $wCampo; ?>px" title="Imagen de fondo">I. Fondo</p></td>
				<td class="seccion-celda-valor">
					<input type="file" class="texto flagable" name="div_f_ifondo" id="div_f_ifondo" value="" size="12" maxlength="500" />
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>"><div style="width:<?php echo $wAcciones; ?>px">&nbsp;</div></td>
			</tr>
			-->
			<!-- Repetición de la imágen fondo -->
			<!--
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Repetición de la imágen de fondo">R. Fondo</p></td>
				<td class="seccion-celda-valor">
					<select class="elige flagable" id="div_f_rfondo" name="div_f_rfondo">
					<option value="no">sin repeticón</option>
					<option value="x">repetir horizontalmente</option>
					<option value="y">repetir verticalmente</option>
					<option value="xy">repetir horizontal y verticalmente</option>
					</select>
				</td>
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">&nbsp;</td>
			</tr>
			-->
			<!-- Posición de la imágen fondo -->
			<!--
			<tr>
				<td class="seccion-celda-campo" width="<?php echo $wCampo; ?>"><p style="cursor: help;" title="Posición de la imágen de fondo">P. Fondo</p></td>
				<td class="seccion-celda-valor">
					<select class="elige flagable" id="div_f_pfondo" name="div_f_pfondo">
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
				<td class="seccion-celda-acciones" width="<?php echo $wAcciones; ?>">&nbsp;</td>
			</tr>
			-->
		</table>
	</div>
	
</div>
<?php
/****************************************************************************************************/
/* Pantalla: _tabDocumento.php
/* Theme: doconline
/* Descripción: pestaña de documento
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	15/03/2012	Creación               
/*
/****************************************************************************************************/

?>
<div id="tabs-documento">
	<!-- Datos propios -->
	<div class="seccion-titulo"><p>Datos propios</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Código -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Código</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="doc_codigo" name="doc_codigo" readonly="readonly" size="22" value="" />
				</td>
			</tr>
			<!-- Tipo -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Tipo</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="info" id="doc_tipo" name="doc_tipo" readonly="readonly" size="18" value="" />
				</td>
			</tr>
			<!-- Nombre -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Nombre</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="texto flagable" id="doc_nombre" name="doc_nombre" size="22" maxlength="50" value="" />
				</td>
			</tr>
			<!-- Versión -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Versión</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="texto flagable" id="doc_version" name="doc_version" size="8" maxlength="20" value="" />
				</td>
			</tr>
			<!-- Referencia -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Referencia externa">Ref.</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="texto flagable" id="doc_referencia" name="doc_referencia" size="16" maxlength="20" value="" />
				</td>
			</tr>
			<!-- Descripción -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Descripción">Desc.</p></td>
				<td class="seccion-celda-valor">
					<textarea class="texto flagable" id="doc_descripcion" name="doc_descripcion" cols="30" rows="3"></textarea>
				</td>
			</tr>
			<!-- Numerada -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Numerada">Num.</p></td>
				<td class="seccion-celda-valor">
					<select class="elige flagable" id="doc_numerada" name="doc_numerada">
					<option value="N">No</option>
					<option value="S">Si</option>
					</select>
				</td>
			</tr>
			<!-- Color de fondo -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Fondo</p></td>
				<td class="seccion-celda-valor">
					<input type="text" class="color {hash:true} texto flagable" name="doc_meta_fondo" id="doc_meta_fondo" value="#FFFFFF" size="6" maxlength="7" readonly="readonly" />
				</td>
			</tr>
			
		</table>
	</div>
	
	<!-- Datos estructurales -->
	<div class="seccion-titulo"><p>Datos estructurales</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Alto -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Alto</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="doc_alto" name="doc_alto" class="text valor-celda float" size="8" maxlength="30" value="" />
				</td>
				<td class="seccion-celda-acciones" width="90">
					<div class="ui-state-default ui-corner-all icono" title="Aumentar en gran media el alto">
						<span class="ui-icon ui-icon-circle-plus sumar-alto-grande" rel="doc_alto"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Aumentar ligeramente el alto">
						<span class="ui-icon ui-icon-plus sumar-alto" rel="doc_alto"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir ligeramente el alto">
						<span class="ui-icon ui-icon-minus restar-alto" rel="doc_alto"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir en gran medida el alto">
						<span class="ui-icon ui-icon-circle-minus restar-alto-grande" rel="doc_alto"></span>
					</div>
				</td>
			</tr>
			<!-- Ancho -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p>Ancho</p></td>
				<td class="seccion-celda-valor">
					<input type="text flagable" id="doc_ancho" name="doc_ancho" class="text valor-celda float" size="8" maxlength="30" value="" />
				</td>
				<td class="seccion-celda-acciones" width="90">
					<div class="ui-state-default ui-corner-all icono" title="Aumentar en gran media el ancho">
						<span class="ui-icon ui-icon-circle-plus sumar-alto-grande" rel="doc_ancho"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Aumentar ligeramente el ancho">
						<span class="ui-icon ui-icon-plus sumar-alto" rel="doc_ancho"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir ligeramente el ancho">
						<span class="ui-icon ui-icon-minus restar-alto" rel="doc_ancho"></span>
					</div>
					<div class="ui-state-default ui-corner-all icono" title="Disminuir en gran medida el ancho">
						<span class="ui-icon ui-icon-circle-minus restar-alto-grande" rel="doc_ancho"></span>
					</div>
				</td>
			</tr>
			
		</table>
	</div>
	<!-- Páginas -->
	<div class="seccion-titulo"><p>Páginas</p></div>
	<div class="seccion-tabla">
		<table cellpadding="0" cellspacing="0">
			<!-- Seleccionar -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Selecciona página">Página:</p></td>
				<td class="seccion-celda-valor">
					<select class="elige" id="doc-paginas" name="doc-paginas">
					</select>
				</td>
				<td class="seccion-celda-acciones" width="48">
					<div class="seccion-tabla-acciones">
						<div class="ui-state-default ui-corner-all icono" title="Eliminar la página">
						<span class="ui-icon ui-icon-trash borrar-pagina"></span>
						</div>
						<div class="ui-state-default ui-corner-all icono" title="Seleccionar la página">
						<span class="ui-icon ui-icon-circle-triangle-e sel-pagina"></span>
						</div>
					</div>
				</td>
			</tr>
			<!-- Alta -->
			<tr>
				<td class="seccion-celda-campo" width="50"><p style="cursor: help;" title="Dar de alta una página">Nueva:</p></td>
				<td class="seccion-celda-valor">
					<select class="elige" id="tipo-pagina-doc" name="tipo-pagina-doc">
					<option value="portada">portada</option>
					<option value="pagina">página</option>
					<option value="contraportada">contraportada</option>
					</select>
				</td>
				<td class="seccion-celda-acciones" width="48">
					<div class="seccion-tabla-acciones">
						<div class="ui-state-default ui-corner-all icono" title="Dar de alta la página">
						<span class="ui-icon ui-icon-circle-check alta-pagina"></span>
						</div>
					</div>
				</td>
			</tr>
			
		</table>
	</div>
	
	<!-- Acciones -->
	<div class="seccion-titulo"><p>Acciones</p></div>
	<div class="seccion-tabla">
		<div class="seccion-tabla-acciones">
			<div class="ui-state-default ui-corner-all icono" title="Aceptar los cambios">
			<span class="ui-icon ui-icon-disk aceptar-cambios-doc"></span>
			</div>
		</div>
	</div>
	
</div>
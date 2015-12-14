<?php
/****************************************************************************************************/
/* Pantalla: _ejemplo.php
/* Theme: doconline
/* Descripción: página de ejemplo para pruebas de impresión
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		07/03/2012	Creación               
/*
/****************************************************************************************************/

?>
<div id="lienzo-general">
	
	<div id="tapiz-principal">
		<div id="cuerpo-tapiz">
			<div id="cabecera-tapiz">
				<div id="escala-medida">
					<p>
					<span id="lienzo-ancho" class="medidas-lienzo">21.00</span>
					x
					<span id="lienzo-alto" class="medidas-lienzo">29.70</span>
					cm
					[escala <span id="lienzo-escala" class="medidas-lienzo">3/2</span>]
					</p>
				</div>
				<div id="escala-principal">

				</div>
			</div>
			<div id="estilos-tapiz"></div>
			<div id="contenido-tapiz" style="height: 297mm;	width: 210mm;">
				
				<style>
				h4 {
							font-family: sans;
							font-weight: bold;
							margin-top: 1em;
							margin-bottom: 0.5em;
				}
				div {
							padding:1em;
							margin-bottom: 1em;
							text-align:justify;
				}
				.marco-pdf {
					background-color: #EFEFEF;
					position: relative;
					width: 210mm;
					height: 297mm;
				}
				.myfixed2 { position: absolute;
					overflow: visible;
					left: 25;
					top: 40;
					border: 1px solid #880000;
					background-color: #FFEEDD;
					background-gradient: linear #dec7cd #fff0f2 0 1 0 0.5;
					padding: 1.5em;
					font-family:sans;
					margin: 0;
					height: 200px;
					width: 230px;
				}
				.myfixed1 { position: absolute;
					overflow: visible;
					left: 5;
					top: 20;
					border: 1px solid #880000;
					background-color: #FFEEDD;
					background-gradient: linear #dec7cd #fff0f2 0 1 0 0.5;
					padding: 1.5em;
					font-family:sans;
					margin: 0;
					height: 200px;
					width: 230px;
				}
				.marco1 {
					background-color: #0000FF;
					margin: 0;
					padding: 0;
					border: 0;
					position: relative;
					overflow: visible;
					height: 297mm;
					width: 210mm;
				}
				.marcoA {
					background-color: #666666;
					margin-top: 2mm;
					margin-left: 2mm;
					margin-right: 2mm;
					margin-bottom: 2mm;
					padding: 0;
					border-top: 0.5mm solid #FFFFFF;
					border-right: 0.5mm solid #FFFFFF;
					border-bottom: 0.5mm solid #FFFFFF;
					border-left: 0.5mm solid #FFFFFF;
					overflow: hidden;
					height: 150mm;
					width: 150mm;
				}
				.div-izquierdo {
					background-color: #EFEFEF;
					margin-left: 2mm;
					padding: 0;
					border-top: 0.5mm solid #000000;
					border-right: 0.5mm solid #000000;
					border-bottom: 0.5mm solid #000000;
					border-left: 0.5mm solid #000000;
					height: 100mm;
					width: 50mm;
					float: left;
					
				}
				.div-derecho {
					background-color: #FF0000;
					margin-top: 5mm;
					margin-right: 2mm;
					padding: 0;
					border-top: 0.5mm solid #FFFFFF;
					border-right: 0.5mm solid #FFFFFF;
					border-bottom: 0.5mm solid #FFFFFF;
					border-left: 0.5mm solid #FFFFFF;
					height: 110mm;
					width: 40mm;
					float: right;
					
				}
				.div-normal {
					background-color: #00FF00;
					margin-top: 10mm;
					margin-left: 60mm;
					margin-right: 50mm;
					padding: 0;
					height: 70mm;
					width: 20mm;
					font-family: Arial, Verdana, Helvetica, sans-serif;
					font-size: 11px;
					font-weight: bold;
					color: #3F3F3F;
				}
				
				</style>
				<div class="marco1">
					<div>
						<h4>CSS "Position"</h4>
						At the bottom of the page are two DIV elements with position:fixed and position:absolute set
					</div>
					<div class="marcoA">
						<div class="div-izquierdo">Es un div izquierdo</div>
						<div class="div-derecho">Es un div derecho</div>
						<div class="div-normal">Estamos en el contenido</div>
					</div>
				</div>
				<div class="myfixed1">1 Praesent pharetra nulla in turpis. Sed ipsum nulla, sodales nec, vulputate in,
				scelerisque vitae, magna. Praesent pharetra nulla in turpis. Sed ipsum nulla, sodales nec, vulputate
				in, scelerisque vitae, magna. Sed egestas justo nec ipsum. Nulla facilisi. Praesent sit amet pede quis
				metus aliquet vulputate. Donec luctus. Cras euismod tellus vel leo. Sed egestas justo nec ipsum. Nulla
				facilisi. Praesent sit amet pede quis metus aliquet vulputate. Donec luctus. Cras euismod tellus vel
				leo.</div>
				<div class="myfixed2">2 Praesent pharetra nulla in turpis. Sed ipsum nulla, sodales nec, vulputate in,
				scelerisque vitae, magna. Sed egestas justo nec ipsum. Nulla facilisi. Praesent sit amet pede quis
				metus aliquet vulputate. Donec luctus. Cras euismod tellus vel leo.</div>
				
			</div>
		</div>
	</div>
</div>
<input type="button" value="imprimir" onclick="javascript:imprimirDoc();" />
<div class="float-sep"></div>
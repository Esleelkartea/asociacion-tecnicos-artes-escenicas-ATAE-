/***************************************************************/
/* js principal para el módulo de diseño de documentos y papelería
/* Requiere jquery 1.6.2 + así como el jquery.ui
/***************************************************************/

if (typeof jQuery == "undefined") {
	alert("Atención!!! No se ha cargado correctamente jQuery. Consulte con el responsable técnico.");
} else {
	// Tener un cuenta un sangrado!!!!
	
	// Límites
	var limSup = 594;
	var limInf = 2;
	
	// Unidades de cambio de medidas
	var cambioAlto = 1;
	var cambioAltoGr = 20;
	var cambioAltoElemento = 10;
	var cambioTop = 5;
	var cambioVisibilidad = 50;
	var cambioMargen = 0.5;
	var cambioBorde = 0.5;
	
	var $DDP = jQuery.noConflict();
	
	$DDP(document).ready(function(){ 
		// Mostrar u ocultar...
		$DDP("#mostrar-alta").click(function(event) {  
			event.preventDefault();  
			var urlContent = document.getElementById("urlContent").value;
			$DDP("#alta-pantalla").slideToggle();  
			if ($DDP("#oculto_alta").attr("value") == 'oculto') {
				$DDP("#oculto_alta").attr("value","no-oculto");
				$DDP("#img-mostrar-alta").attr("src",urlContent + "/themes/twentyeleven-child/images/iconos/abrir.gif");
			}	else {
				$DDP("#oculto_alta").attr("value","oculto");
				$DDP("#img-mostrar-alta").attr("src",urlContent + "/themes/twentyeleven-child/images/iconos/cerrar.gif");
			}
		}); 
		
		$DDP("#mostrar-filtros").click(function(event) {  
			event.preventDefault();  
			var urlContent = document.getElementById("urlContent").value;
			$DDP("#filtros-pantalla").slideToggle();  
			if ($DDP("#oculto_filtros").attr("value") == 'oculto') {
				$DDP("#oculto_filtros").attr("value","no-oculto");
				$DDP("#img-mostrar-filtros").attr("src",urlContent + "/themes/twentyeleven-child/images/iconos/abrir.gif");
			}	else {
				$DDP("#oculto_filtros").attr("value","oculto");
				$DDP("#img-mostrar-filtros").attr("src",urlContent + "/themes/twentyeleven-child/images/iconos/cerrar.gif");
			}
		}); 

		// Campo que puede activar el flag de documento modificado
		/*
		$DDP(".flagable").change(function(event) {  
			$DDP("#flagModificado").attr("value","S");
		});
		*/
		
		// Carga un documento...
		$DDP(".link-editar-documento").click(function(event) {  
			event.preventDefault();  
			var idDocumento = $DDP(this).attr("rel");
			//addInfo("Cargamos el documento " + idDocumento,"aviso");
			var php = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxCargaDocumento.php";
			var pars = "idDocumento=" + idDocumento;
			var phpPaginas = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxCargaPaginas.php?modo=select&" + pars;
			// datos de medidas:
			// ajax
			$DDP.post(php,pars,function(datos) {
				var pos = datos.indexOf("[;;]");
				var mensaje;
				if(pos === -1) {
					addInfo("Error de función, nos da <strong>" + datos + "</strong>","error");
				} else {
					var split = datos.split("[;;]");
					switch(split[0]) {
						case "success":
							// cargo los input...
							var datosCampo = "";
							var cid = "";
							for(i=1;i < split.length;i++) {
								datosCampo = split[i].split("[::]");
								switch(datosCampo[0]) {
									// los hidden
									case "id_documento":
										document.getElementById("idDocumento").value = datosCampo[1];
										break;
									// informativos
									case "codigo":
									case "tipo":
										cid = "doc_" + datosCampo[0];
										document.getElementById(cid).value = datosCampo[1];
										break;
									// texto
									case "version":
									case "referencia":
									case "nombre":
									case "alto":
									case "ancho":
										cid = "doc_" + datosCampo[0];
										document.getElementById(cid).value = datosCampo[1];
										break;
									// textarea
									case "descripcion":
										cid = "doc_" + datosCampo[0];
										document.getElementById(cid).innerText = datosCampo[1];
										break;
									// numerada
									case "numerada":
										cid = "doc_" + datosCampo[0];
										document.getElementById(cid).value = datosCampo[1];
										break;
									/*
									// metas
									case "meta_fondo":
										cid = "doc_" + datosCampo[0];
										document.getElementById(cid).value = datosCampo[1];
										break;
									*/
									// contenido
									case 'contenido':
										document.getElementById("contenidoDoc").value = datosCampo[1];
										break;
									
								}
								//addInfo("<strong>" + datosCampo[0] + ":</strong> " + datosCampo[1],"aviso");
							}
							// A partir de las medidas genero los estilos...
							var alto = document.getElementById("doc_alto").value;
							var ancho = document.getElementById("doc_ancho").value;
							var altoContainer = medidaModalTipo(alto,"altoContainer");
							var altoContent = medidaModalTipo(alto,"altoContent");
							var anchoContainer = medidaModalTipo(ancho,"anchoContainer");
							var anchoContent = medidaModalTipo(ancho,"anchoContent");
							estilosModal(alto,ancho);
							// Estilos del documento, alto, ancho y color de fondo...
							var fondo = document.getElementById("doc_meta_fondo").value;
							if(fondo == "") fondo = "#FFFFFF";
							$DDP("#contenido-documento").css({'background-color':fondo,'height':alto+'mm','width':ancho+'mm'});
							//alert("alto " + altoContent + ", ancho: " + anchoContent);
							$DDP("#basic-modal-content").css({'height':altoContent+'mm','width':anchoContent+'mm'});
							$DDP("#simplemodal-container").css({'height':altoContainer+'mm','width':anchoContainer+'mm'});
							// Cargamos contenido:
							var miContenido = document.getElementById("contenidoDoc").value;
							if(miContenido != "") $DDP("#contenido-documento").html = miContenido;
							// Cargamos las páginas
							$DDP("#doc-paginas").load(phpPaginas);
							// lanzamos la modal...
							$DDP('#basic-modal-content').modal({
								appendTo: 'body',
								position: [10,],
								onShow: function(dialog) {
								 if (!dialog) dialog = $.modal.impl.d
									dialog.container.css('position', 'absolute');
									//dialog.container.css('display', 'block');
									dialog.origHeight = 0;
									$DDP.modal.setContainerDimensions();
									$DDP.modal.setPosition();
								},
								onOpen: function (dialog) {
									// De esta manera cargamos el TinyMCE en la pestaña de detalle puesto de que si no lo hacemos aqui da error de incopatibilidad. Jon Angulo a 22/03/2012
									tinyMCE.init({ 
										mode : "exact",
										elements: "editor",
										theme : "advanced",
										width : 230,//con esto nos da el ancho que queremos
										plugins : "autolink,lists,imgsurfer,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",
										theme_advanced_buttons1 : "fontselect,fontsizeselect,forecolor,backcolor,image,imgsurfer",
										theme_advanced_buttons2 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo",
										theme_advanced_buttons3 :"tablecontrols",
						
										theme_advanced_toolbar_location : "top",
										theme_advanced_toolbar_align : "left",
										theme_advanced_path_location : "bottom",
										extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
											 // De esta manera podermos agregar todos los tipos de fuente que queramos asi como quitarlos por defecto estan los siguientes:
											/*theme_advanced_fonts : "Andale Mono=andale mono,times;"+
											"Arial=arial,helvetica,sans-serif;"+
											"Arial Black=arial black,avant garde;"+
											"Book Antiqua=book antiqua,palatino;"+
											"Comic Sans MS=comic sans ms,sans-serif;"+
											"Courier New=courier new,courier;"+
											"Georgia=georgia,palatino;"+
											"Helvetica=helvetica;"+
											"Impact=impact,chicago;"+
											"Symbol=symbol;"+
											"Tahoma=tahoma,arial,helvetica,sans-serif;"+
											"Terminal=terminal,monaco;"+
											"Times New Roman=times new roman,times;"+
											"Trebuchet MS=trebuchet ms,geneva;"+
											"Verdana=verdana,geneva;"+
											"Webdings=webdings;"+
											"Wingdings=wingdings,zapf dingbats",	
											*/
											theme_advanced_fonts :
											"Arial=arial,helvetica,sans-serif;"+
											//"Arial Black=arial black,avant garde;"+
											"Book Antiqua=book antiqua,palatino;"+
											"Courier New=courier new,courier;"+
											"Georgia=georgia,palatino;"+
											"Helvetica=helvetica;"+
											"Impact=impact,chicago;"+										
											"Tahoma=tahoma,arial,helvetica,sans-serif;"+
											"Times New Roman=times new roman,times;"+
											"Trebuchet MS=trebuchet ms,geneva;"+
											"Verdana=verdana,geneva;"
										//A la hora de pasarlo al pdf he cambiado la version por la nueva MPDF54
										//ya que la otra era la anterior de esta manera se hace mas compatible.
									});
									// Cargo un 2º tinyMCE para la imágen de fondo
									tinyMCE.init({ 
										mode : "exact",
										elements: "txtSelFondo",
										theme : "advanced",
										width : 230,//con esto nos da el ancho que queremos
										plugins : "imgsurferd5",
										theme_advanced_buttons1 : "imgsurferd5",
										theme_advanced_buttons2 : "",//tenemos que ponerlo de manera de que solo guarde un boton
										theme_advanced_buttons3 : "",
										theme_advanced_buttons4 : "",
										theme_advanced_toolbar_location : "top",
										theme_advanced_toolbar_align : "left"
									});
									dialog.overlay.fadeIn('slow', function () {
										dialog.container.slideDown('slow', function () {
											dialog.data.fadeIn('slow');
										});
									});
								},
								onClose: function (dialog) {
									//var flg = document.getElementById("flagModificado").value;
									//if(flg == "S") if(confirm("¿Desea salir sin guardar los cambios?")) flg = "N";
									//if(flg == "N") {
										dialog.data.fadeOut('slow', function () {
											dialog.container.slideUp('slow', function () {
												dialog.overlay.fadeOut('slow', function () {
													$DDP.modal.close(); // must call this!
													document.getElementById("accion").value = "";
													document.forms["formDOP"].submit();
												});
											});
										});
									//}
								}
							});
							break;
						case "alert":
							addInfo("<strong>ATENCIÓN!!!</strong><br/>" + split[1] + "</strong>","error");
							break;
						case "error":
							addInfo("<strong>ERROR!!!</strong><br/>" + split[1] + "</strong>","error");
							break;
						default:
							addInfo("<strong>" + split[0] + "</strong> es desconocido","error");
							break;
					}
				}
			});
		});
		
		// Guarda los datos de un documento:
		$DDP(".aceptar-cambios-doc").click(function(event) {
			// Se comprueban campos
			if(chkCamposDocumento() == "S") {
				var php = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxModDocumento.php";
				var pars = "idDocumento=" + document.getElementById("idDocumento").value;
				pars += "&nombre=" + document.getElementById("doc_nombre").value;
				pars += "&version=" + document.getElementById("doc_version").value;
				pars += "&alto=" + document.getElementById("doc_alto").value;
				pars += "&ancho=" + document.getElementById("doc_ancho").value;
				pars += "&referencia=" + document.getElementById("doc_referencia").value;
				pars += "&descripcion=" + document.getElementById("doc_descripcion").value;
				pars += "&numerada=" + document.getElementById("doc_numerada").value;
				// ajax
				$DDP.post(php,pars,function(datos) {
					var pos = datos.indexOf("[;;]");
					var mensaje;
					if(pos === -1) {
						alert("Error de función, nos da " + datos);
					} else {
						var split = datos.split("[;;]");
						switch(split[0]) {
							case "success":
								//alert("Datos modificados correctamente.");
								break;
							default:
								alert(split[0] + "!!! " + split[1]);
								//document.getElementById("doc_descripcion").value = datos;
								break;
						}
					}
				});
			}
		});
		
		// Selecciona una página:
		$DDP(".sel-pagina").click(function(event) {
			var idPagina = document.getElementById("doc-paginas").value;
			if(idPagina == "") alert("Ha de seleccionar una página.");
			else {
				var php = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxCargaPagina.php";
				var pars = "idPagina=" + idPagina;
				//alert("a por la página " + idPagina);
				// ajax
				$DDP.post(php,pars,function(datos) {
					var pos = datos.indexOf("[;;]");
					var mensaje;
					if(pos === -1) {
						alert("Error de función, nos da " + datos);
					} else {
						var split = datos.split("[;;]");
						switch(split[0]) {
							case "success":
								// cargo los input...
								var datosCampo = "";
								var cid = "";
								for(i=1;i < split.length;i++) {
									datosCampo = split[i].split("[::]");
									switch(datosCampo[0]) {
										// los hidden
										case "id_pagina":
											document.getElementById("idPagina").value = datosCampo[1];
											break;
										// informativos
										case "codigo":
										case "tipo":
										case "numero":
											cid = "pag_" + datosCampo[0];
											document.getElementById(cid).value = datosCampo[1];
											break;
										// texto
										case "referencia":
											cid = "pag_" + datosCampo[0];
											document.getElementById(cid).value = datosCampo[1];
											break;
										// contenido
										case 'contenido':
											document.getElementById("contenidoPag").value = datosCampo[1];
											break;
										
									}
									//addInfo("<strong>" + datosCampo[0] + ":</strong> " + datosCampo[1],"aviso");
								}
								// Cargamos contenido:
								var miContenido = document.getElementById("contenidoPag").value;
								if(miContenido != "") {
									$DDP("#contenido-documento").html(miContenido);
									// preparamos los objetos draggables
									sonDraggables();
								}
								// Avisamos
								//alert("La página ha sido cargada.");
								// eliminamos clases
								$DDP("#li-tabs-documento").removeClass("ui-tabs-selected");
								$DDP("#li-tabs-documento").removeClass("ui-state-active");
								// añadimos clases
								$DDP("#li-tabs-pagina").addClass("ui-tabs-selected");
								$DDP("#li-tabs-pagina").addClass("ui-state-active");
								// escondemos la actual
								$DDP("#tabs-documento").addClass("ui-tabs-hide");
								$DDP("#tabs-pagina").removeClass("ui-tabs-hide");
								break;
							default:
								alert(split[0] + "!!! " + split[1]);
								break;
						}
					}
				});
			}
		});
		
		// Crear página
		$DDP(".alta-pagina").click(function(event) {  
			var idDocumento = $DDP("#idDocumento").attr("value");
			var tipo = $DDP("#tipo-pagina-doc").find(':selected').val();
			var php = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxCreaPagina.php";
			var pars = "idDocumento=" + idDocumento + "&tipo=" + tipo;
			var phpPaginas = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxCargaPaginas.php?modo=select&idDocumento=" + idDocumento;
			//alert("creamos página de tipo " + tipo + " para documento " + idDocumento);
			// ajax
			$DDP.post(php,pars,function(datos) {
				var pos = datos.indexOf("[;;]");
				var mensaje;
				if(pos === -1) {
					alert("Error de función, nos da " + datos);
				} else {
					var split = datos.split("[;;]");
					switch(split[0]) {
						case "success":
							// cargo los input...
							var datosCampo = "";
							var cid = "";
							for(i=1;i < split.length;i++) {
								datosCampo = split[i].split("[::]");
								switch(datosCampo[0]) {
									// los hidden
									case "id_pagina":
										document.getElementById("idPagina").value = datosCampo[1];
										break;
									// informativos
									case "codigo":
									case "tipo":
									case "numero":
										cid = "pag_" + datosCampo[0];
										document.getElementById(cid).value = datosCampo[1];
										break;
									// texto
									case "referencia":
										cid = "pag_" + datosCampo[0];
										document.getElementById(cid).value = datosCampo[1];
										break;
									// contenido
									case 'contenido':
										document.getElementById("contenidoPag").value = datosCampo[1];
										break;
									
								}
								//addInfo("<strong>" + datosCampo[0] + ":</strong> " + datosCampo[1],"aviso");
							}
							// Cargamos contenido:
							var miContenido = document.getElementById("contenidoPag").value;
							if(miContenido != "") $DDP("#contenido-documento").html(miContenido);
							// Cargamos las páginas
							$DDP("#doc-paginas").load(phpPaginas);
							// Avisamos
							alert("La página ha sido creada.");
							break;
						default:
							alert(split[0] + "!!! " + split[1]);
							break;
					}
				}
			});
			
		});
		
		// Guarda los datos de una página:
		$DDP(".aceptar-cambios-pagina").click(function(event) {
			// primero depuramos las posiciones de las páginas...
			recorrer();
			var php = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxModPagina.php";
			var params = {idPagina:document.getElementById("idPagina").value, referencia:document.getElementById("pag_referencia").value, contenido:document.getElementById("contenido-documento").innerHTML};
			// ajax
			$DDP.post(php,params,function(datos) {
				var pos = datos.indexOf("[;;]");
				var mensaje;
				if(pos === -1) {
					alert("Error de función, nos da " + datos);
				} else {
					var split = datos.split("[;;]");
					switch(split[0]) {
						case "success":
							alert("Datos modificados correctamente.");
							break;
						default:
							alert(split[0] + "!!! " + split[1]);
							//document.getElementById("doc_descripcion").value = datos;
							break;
					}
				}
			});
		});
		
		// Elimina una página
		$DDP(".borrar-pagina").click(function(event) {
			if(confirm("¿Desea eliminar la página?")) {
				var idDocumento = $DDP("#idDocumento").attr("value");
				var phpPaginas = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxCargaPaginas.php?modo=select&idDocumento=" + idDocumento;
				var php = document.getElementById("urlContent").value + "/themes/twentyeleven-child/ajaxBorraPagina.php";
				var params = {idPagina:document.getElementById("doc-paginas").value};
				// ajax
				$DDP.post(php,params,function(datos) {
					var pos = datos.indexOf("[;;]");
					var mensaje;
					if(pos === -1) {
						alert("Error de función, nos da " + datos);
					} else {
						var split = datos.split("[;;]");
						switch(split[0]) {
							case "success":
								alert("Página correctamente eliminada.");
								// Cargamos las páginas
								$DDP("#doc-paginas").load(phpPaginas);
								break;
							default:
								alert(split[0] + "!!! " + split[1]);
								//document.getElementById("doc_descripcion").value = datos;
								break;
						}
					}
				});
			}
		});
		
		// Genera elementos de la página
		$DDP(".crear-div-f").click(function(event) {
			var r = chkCamposNElemento();
			if(r == "S") {
				var tipo = document.getElementById("div_f_tipo").value;
				var alto = document.getElementById("div_f_alto").value;
				var ancho = document.getElementById("div_f_ancho").value;
				var dtop = document.getElementById("div_f_dtop").value;
				var dleft = document.getElementById("div_f_dleft").value;
				var zindex = document.getElementById("div_f_zindex").value;
				var mtop = document.getElementById("div_f_mtop").value;
				var mright = document.getElementById("div_f_mright").value;
				var mbottom = document.getElementById("div_f_mbottom").value;
				var mleft = document.getElementById("div_f_mleft").value;
				var ptop = document.getElementById("div_f_ptop").value;
				var pright = document.getElementById("div_f_pright").value;
				var pbottom = document.getElementById("div_f_pbottom").value;
				var pleft = document.getElementById("div_f_pleft").value;
				var cfondo = document.getElementById("div_f_cfondo").value;
				var borde = document.getElementById("div_f_borde").value;
				var cborde = document.getElementById("div_f_cborde").value;
				//alert("Se crea un elemento en contenido-documento...");
				var nClase = "elemento-" + tipo;
				// Obtenemos el número actual:
				var numElem = ultimoElemento(nClase);
				var eId = nClase + "-" + numElem;
				// Hallamos el id de la página
				var pNum = document.getElementById("pag_numero").value;
				if(pNum==0 || pNum == "") pNum = 1;
				var pId = "#pagina-" + document.getElementById("idDocumento").value + "-" + document.getElementById("pag_tipo").value + "-" + pNum;
				//alert("Hay " + numElem + " elementos de tipo " + nClase);
				var estilo = "<style>";
				estilo += "#" + eId + " { ";
				if(cfondo != "") estilo += "background-color:" + cfondo + "; ";
				if(tipo != "libre") {
					if(mtop != "" && esNum(mtop)) estilo += "margin-top:" + mtop + "mm; ";
					if(mright != "" && esNum(mright)) estilo += "margin-right:" + mright + "mm; ";
					if(mbottom != "" && esNum(mbottom)) estilo += "margin-bottom:" + mbottom + "mm; ";
					if(mleft != "" && esNum(mleft)) estilo += "margin-left:" + mleft + "mm; ";
				}
				if(ptop != "" && esNum(ptop)) estilo += "padding-top:" + ptop + "mm; ";
				if(pright != "" && esNum(pright)) estilo += "padding-right:" + pright + "mm; ";
				if(pbottom != "" && esNum(pbottom)) estilo += "padding-bottom:" + pbottom + "mm; ";
				if(pleft != "" && esNum(pleft)) estilo += "padding-left:" + pleft + "mm; ";
				estilo += "height:" + alto + "mm; ";
				estilo += "width:" + ancho + "mm; ";
				if(borde != "" && borde > 0) {
					var dBorde = borde + "mm solid " + cborde + "; ";
					estilo += "border-top:" + dBorde;
					estilo += "border-right:" + dBorde;
					estilo += "border-bottom:" + dBorde;
					estilo += "border-left:" + dBorde;
				}
				if(zindex != "" && esNum(zindex)) estilo += "z-index:" + zindex + "; ";
				estilo += " } "
				estilo += "</style>"
				var divEstilos = document.createElement("div");
				divEstilos.id = "estilos-" + eId;
				divEstilos.innerHTML = estilo;
				//alert("pId: " + pId);
				if(tipo == "libre") $DDP("#contenido-documento").append(divEstilos);
				else $DDP(pId).append(divEstilos);
				var miElemento = '<div id="' + eId + '" rel="' + numElem + '" onclick="seleccionarElemento(\'' + nClase + "-" + numElem + '\',' + numElem + ');"></div>';
				if(tipo == "libre") $DDP("#contenido-documento").append(miElemento);
				else $DDP(pId).append(miElemento);
				eId = "#" + eId;
				// Añadimos las clases para el manejo de la interfaz
				$DDP(eId).addClass("elemento-pagina");
				$DDP(eId).addClass("elemento-" + tipo);
				if(tipo == "libre") $DDP(eId).addClass("elemento-draggable");
				// Añadimos estilos
				if(tipo == "libre") $DDP(eId).css("position","absolute");
				if(tipo == "libre") $DDP(eId).css("top",dtop + "mm");
				if(tipo == "libre") $DDP(eId).css("left",dleft + "mm");
				// lo hago draggable
				if(tipo == "libre") esDraggable(eId);
				// cargamos los datos en la pestaña de detalles
				document.getElementById("elem_codigo").value = eId;
				document.getElementById("elem_tipo").value = tipo;
				document.getElementById("elem_alto").value = alto;
				document.getElementById("elem_ancho").value = ancho;
				document.getElementById("elem_dtop").value = dtop;
				document.getElementById("elem_dleft").value = dleft;
				document.getElementById("elem_zindex").value = zindex;
				document.getElementById("elem_mtop").value = mtop;
				document.getElementById("elem_mright").value = mright;
				document.getElementById("elem_mbottom").value = mbottom;
				document.getElementById("elem_mleft").value = mleft;
				document.getElementById("elem_ptop").value = ptop;
				document.getElementById("elem_pright").value = pright;
				document.getElementById("elem_pbottom").value = pbottom;
				document.getElementById("elem_pleft").value = pleft;
				document.getElementById("elem_borde").value = borde;
				document.getElementById("elem_cborde").value = cborde;
				if(cborde != "") document.getElementById("elem_flg_cborde").checked = true;
				else document.getElementById("elem_flg_cborde").checked = false;
				document.getElementById("elem_cfondo").value = cfondo;
				if(cfondo != "") document.getElementById("elem_flg_cfondo").checked = true;
				else document.getElementById("elem_flg_cfondo").checked = false;
				//document.getElementById("elem_ifondo").value = "";
				document.getElementById("elem_rfondo").value = "no";
				document.getElementById("elem_pfondo").value = "";
				document.getElementById("elem_contenido").value = "";
				//document.getElementById("elem_tcontenido").innerText = "";
				document.getElementById("idElemento").value = numElem; // Cargamos el Id...
			}

		});
		
		// elimina un elemento
		$DDP(".eliminar-elemento").click(function(event) {
			var codElemento = document.getElementById("elem_codigo").value;
			if(codElemento == "") {
				alert("No hay elemento seleccionado.");
				return;
			}
			if(confirm("Está a punto de eliminar el elemento. ¿Desea continuar?")) {
				$DDP("#" + codElemento).remove();
				// vaciamos los campos...
				document.getElementById("elem_codigo").value = "";
				document.getElementById("elem_tipo").value = "";
				document.getElementById("elem_alto").value = 0;
				document.getElementById("elem_ancho").value = 0;
				document.getElementById("elem_dtop").value = 0;
				document.getElementById("elem_dleft").value = 0;
				document.getElementById("elem_zindex").value = 1000;
				document.getElementById("elem_mtop").value = 0;
				document.getElementById("elem_mright").value = 0;
				document.getElementById("elem_mbottom").value = 0;
				document.getElementById("elem_mleft").value = 0;
				document.getElementById("elem_ptop").value = 0;
				document.getElementById("elem_pright").value = 0;
				document.getElementById("elem_pbottom").value = 0;
				document.getElementById("elem_pleft").value = 0;
				document.getElementById("elem_borde").value = 0;
				document.getElementById("elem_cborde").value = "#000000";
				document.getElementById("elem_flg_cborde").checked = false;
				document.getElementById("elem_cfondo").value = "#FFFFFF";
				document.getElementById("elem_flg_cfondo").checked = false;
				document.getElementById("elem_rfondo").value = "no";
				document.getElementById("elem_pfondo").value = "";
				document.getElementById("elem_contenido").value = "";
				document.getElementById("idElemento").value = "";
			}
		});
		

		// Cambio de campo de elemento
		$DDP(".elem-modificable").change(function(event) {
			actualizaElemento($DDP(this).attr("id"));
			/*
			var idElemento = document.getElementById("idElemento").value;
			if(idElemento != "") {
				var codigo = document.getElementById("elem_codigo").value;
				var miName = $DDP(this).attr("id");
				var valor = document.getElementById(miName).value;
				if(miName == "elem_dtop" || miName == "elem_dleft" || miName == "elem_pfondo" || miName == "elem_rfondo") {
					switch(miName) {
						case "elem_dtop":
							//$DDP("#" + codigo).css("top",valor + "mm");
							break;
						case "elem_dleft":
							//$DDP("#" + codigo).css("left",valor + "mm");
							break;
						case "elem_pfondo":
							switch(valor) {
								case "":
									$DDP("#" + codigo).css("background-position","");
									break;
								case "no":
									$DDP("#" + codigo).css("background-position","");
									$DDP("#" + codigo).css("background-image","");
									break;
								case "lt":
									$DDP("#" + codigo).css("background-position","left top");
									break;
								case "lc":
									$DDP("#" + codigo).css("background-position","left center");
									break;
								case "lb":
									$DDP("#" + codigo).css("background-position","left bottom");
									break;
								case "ct":
									$DDP("#" + codigo).css("background-position","center top");
									break;
								case "cc":
									$DDP("#" + codigo).css("background-position","center center");
									break;
								case "cb":
									$DDP("#" + codigo).css("background-position","center bottom");
									break;
								case "rt":
									$DDP("#" + codigo).css("background-position","right top");
									break;
								case "rc":
									$DDP("#" + codigo).css("background-position","right center");
									break;
								case "rb":
									$DDP("#" + codigo).css("background-position","right bottom");
									break;
							}
							break;
						case "elem_rfondo":
							switch(valor) {
								case "no":
									$DDP("#" + codigo).css("background-repeat","");
									break;
								case "x":
									$DDP("#" + codigo).css("background-repeat","repeat-x");
									break;
								case "y":
									$DDP("#" + codigo).css("background-repeat","repeat-y");
									break;
								case "xy":
									$DDP("#" + codigo).css("background-repeat","repeat");
									break;
							}
							break;	
					}
				} else {
					var styleId = "estilos-" + codigo;
					var styleHTML = document.getElementById(styleId).innerHTML;
					var temp = styleHTML.split("{");
					temp = temp[1].split("}");
					var tEstilos = temp[0].split(";");
					var cEstilos = new Array;
					var vEstilos = new Array;
					var i = 0;
					var temp;
					for(iEstilo in tEstilos) {
						estilo = tEstilos[iEstilo].split(":");
						if(estilo[0] != "" && estilo[1] != undefined) {
							temp = estilo[0].replace(/^(\s)*|(\s)*$/g,"");
							cEstilos[i] = temp;
							vEstilos[i] = estilo[1];
							i++;
						}
					}
					var indice = "";
					switch(miName) {
						case "elem_alto":
							indice = getIndice(cEstilos,"height");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_ancho":
							indice = getIndice(cEstilos,"width");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_zindex":
							indice = getIndice(cEstilos,"z-index");
							if(indice != "") vEstilos[indice] = valor;
							break;
						case "elem_mtop":
							indice = getIndice(cEstilos,"margin-top");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_mright":
							indice = getIndice(cEstilos,"margin-right");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_mbottom":
							indice = getIndice(cEstilos,"margin-bottom");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_mleft":
							indice = getIndice(cEstilos,"margin-left");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_ptop":
							indice = getIndice(cEstilos,"padding-top");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_pright":
							indice = getIndice(cEstilos,"padding-right");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_pbottom":
							indice = getIndice(cEstilos,"padding-bottom");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_pleft":
							indice = getIndice(cEstilos,"padding-left");
							if(indice != "") vEstilos[indice] = valor + "mm";
							break;
						case "elem_borde":
						case "elem_cborde":
						case "elem_flg_cborde":
							var gBorde = document.getElementById("elem_borde").value;
							var cBorde = document.getElementById("elem_cborde").value;
							var fBorde = document.getElementById("elem_flg_cborde").checked;
							var dBorde = (fBorde) ? gBorde + "mm solid " + cBorde : "0mm";
							indice = getIndice(cEstilos,"border-top");
							if(indice != "") vEstilos[indice] = dBorde;
							indice = getIndice(cEstilos,"border-right");
							if(indice != "") vEstilos[indice] = dBorde;
							indice = getIndice(cEstilos,"border-bottom");
							if(indice != "") vEstilos[indice] = dBorde;
							indice = getIndice(cEstilos,"border-left");
							if(indice != "") vEstilos[indice] = dBorde;
							break;
						case "elem_cfondo":
						case "elem_flg_cfondo":
							var cFondo = document.getElementById("elem_cfondo").value;
							var fFondo = document.getElementById("elem_flg_cfondo").checked;
							valor = (fFondo) ? cFondo : "";
							indice = getIndice(cEstilos,"background-color");
							vEstilos[indice] = valor;
							break;
					}
					// preparamos la cadena HTML
					var newStyle = "<style>#" + codigo + " { ";
					for(cEstilo in cEstilos) if(vEstilos[cEstilo] != "" && vEstilos[cEstilo] != undefined) newStyle += cEstilos[cEstilo] + ": " + vEstilos[cEstilo] + "; ";
					newStyle += " } </style>";
					estilos = null;
					document.getElementById(styleId).innerHTML = newStyle;
				}
			}
			*/
		});
		
		// Envío el texto del tinyMCE
		$DDP(".enviar-texto").click(function(){				
			var idPagina = document.getElementById("idPagina").value;
			var idElemento = document.getElementById("idElemento").value;
			var codigo = document.getElementById("elem_codigo").value;
			if(idPagina == "") alert("No está cargada la página");
			else if(idElemento == "") alert("No está cargado el elemento");
			else if(codigo == "") alert("Elemento desconocido");
			else {
				var ed = tinyMCE.get('editor');
				ed.setProgressState(1); 
				window.setTimeout(function() {
					ed.setProgressState(0); 
					document.getElementById("elem_contenido").value = ed.getContent();
					document.getElementById(codigo).innerHTML = ed.getContent();
					//alert(ed.getContent());
				}, 10);
			}
		});
		
		// Subir un fondo
		$DDP(".subir-fondo").click(function(){				
			var ed = tinyMCE.get('txtSelFondo');
			var contenido = ed.getContent();
			var patron = /<img src=\"\.\.\/wp\-content([^"]+)\"/gi;
			var encuentro = contenido.match(patron);
			var repeticion = document.getElementById("elem_rfondo").value;
			var posicion = document.getElementById("elem_pfondo").value;
			var destino = document.getElementById("elem_codigo").value;
			if(destino == "") alert("No hay elemento seleccionado para cargar el fondo.");
			else if(!contenido.match(patron)) alert("No hay imagen cargada");
			else if(posicion == "no") alert("Se ha indicado que no se desea imágen de fondo (Posición de la imágen de fondo).");
			else {
				var resultado = encuentro.toString().replace(patron,"$1");
				var ifondo = document.getElementById("urlContent").value + resultado;
				var pfondo = "";
				switch(posicion) {
					case "lt":
						pfondo = "left top";
						break;
					case "lc":
						pfondo = "left center";
						break;
					case "lb":
						pfondo = "left bottom";
						break;
					case "ct":
						pfondo = "center top";
						break;
					case "cc":
						pfondo = "center center";
						break;
					case "cb":
						pfondo = "center bottom";
						break;
					case "rt":
						pfondo = "right top";
						break;
					case "rc":
						pfondo = "right center";
						break;
					case "rb":
						pfondo = "right bottom";
						break;
					case "":
						pfondo = "";
						break;
					
				}
				var rfondo = "";
				switch(repeticion) {
					case "x":
						rfondo = "repeat-x";
						break;
					case "y":
						rfondo = "repeat-y";
						break;
					case "xy":
						rfondo = "repeat";
						break;
					case "no":
						rfondo = "no-repeat";
						break;
				}
				$DDP("#" + destino).css("background-image","url(" + ifondo + ")");
				$DDP("#" + destino).css("background-position",pfondo);
				$DDP("#" + destino).css("background-repeat",rfondo);
			}
		});
		
		// vaciar un fondo
		$DDP(".vaciar-fondo").click(function(){				
			var destino = document.getElementById("elem_codigo").value;
			if(destino == "") alert("No hay elemento seleccionado para cargar el fondo.");
			else if(confirm("¿Desea elminar el fondo?")) {
				$DDP("#" + destino).css("background-image","");
				$DDP("#" + destino).css("background-position","");
				$DDP("#" + destino).css("background-repeat","");
			}
		});
	
		// preparo las tabs de la zona de detalles
		$DDP(function() {
			$DDP( "#tabs" ).tabs();
		});
		
		// Botones de la tabla
		$DDP(function(){
			$DDP('.ui-state-default').hover(
				function(){ $DDP(this).addClass('ui-state-hover'); }, 
				function(){ $DDP(this).removeClass('ui-state-hover'); }
			);
			
			// Sumar
			$DDP('.sumar-alto').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < limSup) valor = parseFloat(valor) + parseFloat(cambioAlto);
				if(valor > limSup) valor = limSup;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
			});
			$DDP('.sumar-alto-grande').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < limSup) valor = parseFloat(valor) + parseFloat(cambioAltoGr);
				if(valor > limSup) valor = limSup;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.sumar-alto-elemento').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < limSup) valor = parseFloat(valor) + parseFloat(cambioAltoElemento);
				if(valor > limSup) valor = limSup;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.sumar-top').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < limSup) valor = parseFloat(valor) + parseFloat(cambioTop);
				if(valor > limSup) valor = limSup;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.sumar-visibilidad').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < 10000) valor = parseFloat(valor) + parseFloat(cambioVisibilidad);
				if(valor > 10000) valor = 10000;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.sumar-margen').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < 10) valor = parseFloat(valor) + parseFloat(cambioMargen);
				if(valor > 10) valor = 10;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.sumar-borde').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor < 10) valor = parseFloat(valor) + parseFloat(cambioBorde);
				if(valor > 10) valor = 10;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			
			// Restar
			$DDP('.restar-alto').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > limInf) valor -= cambioAlto;
				if(valor < limInf) valor = limInf;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.restar-alto-grande').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > limInf) valor -= cambioAltoGr;
				if(valor < limInf) valor = limInf;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.restar-alto-elemento').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > limInf) valor -= cambioAltoElemento;
				if(valor < limInf) valor = limInf;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.restar-top').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > 0) valor -= cambioTop;
				if(valor < 0) valor = 0;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.restar-visibilidad').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > 500) valor -= cambioVisibilidad;
				if(valor < 500) valor = 500;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.restar-margen').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > 0) valor -= cambioMargen;
				if(valor < 0) valor = 0;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});
			$DDP('.restar-borde').click(function(){				
				var destino = $DDP("#" + $DDP(this).attr("rel"));
				var valor = destino.attr("value");
				if(valor > 0) valor -= cambioBorde;
				if(valor < 0) valor = 0;
				destino.attr("value",valor);
				// Acciones extra según destino
				if($DDP(this).hasClass("bot-modificador")) actualizaElemento($DDP(this).attr("rel"));
				
			});

		});
		
	});
	
	// Función que prepara un elemento como draggable
	function esDraggable(obj) {
		var pNum = document.getElementById("pag_numero").value;
		if(pNum==0 || pNum == "") pNum = 1;
		var pId = "#pagina-" + document.getElementById("idDocumento").value + "-" + document.getElementById("pag_tipo").value + "-" + pNum;
		$DDP(function() {
			$DDP(obj).draggable({
				containment: pId,
				drag: (function(event, ui){
					var dtop = ui.position.top;
					var dleft = ui.position.left;
					if(dleft != "" && esNum(dleft)) document.getElementById("elem_dleft").value = getInMm(dleft);
					if(dtop != "" && esNum(dtop)) document.getElementById("elem_dtop").value = getInMm(dtop);
				})
		 });
		});

	}
	
	function sonDraggables() {
		$DDP(function() {
			var pNum = document.getElementById("pag_numero").value;
			if(pNum==0 || pNum == "") pNum = 1;
			var pId = "#pagina-" + document.getElementById("idDocumento").value + "-" + document.getElementById("pag_tipo").value + "-" + pNum;
			$DDP(".elemento-draggable").draggable({
				containment: pId,
				drag: (function(event, ui){
					var dtop = ui.position.top;
					var dleft = ui.position.left;
					if(dleft != "" && esNum(dleft)) document.getElementById("elem_dleft").value = getInMm(dleft);
					if(dtop != "" && esNum(dtop)) document.getElementById("elem_dtop").value = getInMm(dtop);
				})
			});
		});
	}
	
}

// FUNCIONES NORMALES

// Selecciona un elemento
function seleccionarElemento(oid,eid) {
	var tmp = oid.split("-");
	var tipo = tmp[1];
	var styleId = "estilos-" + oid;
	var styleHTML = document.getElementById(styleId).innerHTML;
	//alert("el innerHTML para oid" + oid + " y eid " + eid + " es " + styleHTML);
	var temp = styleHTML.split("{");
	if(temp[1] != "undefined" && temp[1] != undefined) temp = temp[1].split("}");
	var estilos = temp[0].split(";");
	var estilo = "";
	var valores = "";
	var valor = "";
	for(iEstilo in estilos) {
		estilo = estilos[iEstilo].split(":");
		var cEstilo = (estilo[0] != "" && estilo[0] != undefined) ? estilo[0].replace(/^(\s)*|(\s)*$/g,"") : "";
		var dEstilo = (estilo[1] != "" && estilo[1] != undefined) ? estilo[1].replace(/^(\s)*|(\s)*$/g,"") : "";
		//alert("ahora ..." + cEstilo + "... > ..." + dEstilo + "...");
		switch(cEstilo) {
			case "background-color":
				document.getElementById("elem_cfondo").value = (dEstilo != "" && dEstilo != undefined) ? dEstilo : "";
				if(dEstilo != "" && dEstilo != undefined) document.getElementById("elem_flg_cfondo").checked = true;
				else document.getElementById("elem_flg_cfondo").checked = false;
				break;
			case "margin-top":
				valor = (tipo == "fijo") ? dEstilo.substr(0,dEstilo.length-2) : 0;
				document.getElementById("elem_mtop").value = valor;
				break;
			case "margin-right":
				valor = (tipo == "fijo") ? dEstilo.substr(0,dEstilo.length-2) : 0;
				document.getElementById("elem_mright").value = valor;
				break;
			case "margin-bottom":
				valor = (tipo == "fijo") ? dEstilo.substr(0,dEstilo.length-2) : 0;
				document.getElementById("elem_mbottom").value = valor;
				break;
			case "margin-left":
				valor = (tipo == "fijo") ? dEstilo.substr(0,dEstilo.length-2) : 0;
				document.getElementById("elem_mleft").value = valor;
				break;
			case "padding-top":
				valor = dEstilo.substr(0,dEstilo.length-2);
				document.getElementById("elem_ptop").value = valor;
				break;
			case "padding-right":
				valor = dEstilo.substr(0,dEstilo.length-2);
				document.getElementById("elem_pright").value = valor;
				break;
			case "padding-bottom":
				valor = dEstilo.substr(0,dEstilo.length-2);
				document.getElementById("elem_pbottom").value = valor;
				break;
			case "padding-left":
				valor = dEstilo.substr(0,dEstilo.length-2);
				document.getElementById("elem_pleft").value = valor;
				break;
			case "height":
				valor = dEstilo.substr(0,dEstilo.length-2);
				document.getElementById("elem_alto").value = valor;
				break;
			case "width":
				valor = dEstilo.substr(0,dEstilo.length-2);
				document.getElementById("elem_ancho").value = valor;
				break;
			case "border-top": // valdría cualquier borde
				//alert("para border top (" + cEstilo + ") estilo es ..." + dEstilo + "...");
				if(cEstilo != "") {
					valores = dEstilo.split(" ");
					valor = valores[0].substr(0,valores[0].length-2);
					document.getElementById("elem_borde").value = valor;
					document.getElementById("elem_cborde").value = valores[2];
					document.getElementById("elem_flg_cborde").checked = true;
				} else {
					document.getElementById("elem_borde").value = 0;
					document.getElementById("elem_cborde").value = "#000000";
					document.getElementById("elem_flg_cborde").checked = false;
				}
				break;
			case "z-index":
				document.getElementById("elem_zindex").value = dEstilo;
				break;
		}
	}
	// quedaría top, left, imágen de fondo
	var position = $DDP("#" + oid).position();
	var dtop = (tipo == "libre") ? position.top : 0;
	var dleft = (tipo == "libre") ? position.left : 0;
	if(dleft != "" && esNum(dleft)) dleft = getInMm(dleft);
	if(dtop != "" && esNum(dtop)) dtop = getInMm(dtop);;
	document.getElementById("elem_dleft").value = dleft;
	document.getElementById("elem_dtop").value = dtop;
	var bImage = $DDP("#" + oid).css("background-image");
	//alert("bImage es ..." + bImage + "... con " + bImage.length);
	if(bImage != "none") {
		var bIRepeat = $DDP("#" + oid).css("background-repeat");
		switch(bIRepeat) {
			case "repeat-x":
			case "repeat no-repeat":
				document.getElementById("elem_rfondo").value = "x";
				break;
			case "repeat-y":
			case "no-repeat repeat":
				document.getElementById("elem_rfondo").value = "y";
				break;
			case "repeat":
			case "repeat repeat":
				document.getElementById("elem_rfondo").value = "xy";
				break;
			default:
				document.getElementById("elem_rfondo").value = "no";
				break;
		}
		var bIPosition = $DDP("#" + oid).css("background-position");
		switch(bIPosition) {
			case "left top":
			case "0% 0%":
				document.getElementById("elem_pfondo").value = "lt";
				break;
			case "left center":
			case "0% 50%":
				document.getElementById("elem_pfondo").value = "lc";
				break;
			case "left bottom":
			case "0% 100%":
				document.getElementById("elem_pfondo").value = "lb";
				break;
			case "right top":
			case "100% 0%":
				document.getElementById("elem_pfondo").value = "rt";
				break;
			case "right center":
			case "100% 50%":
				document.getElementById("elem_pfondo").value = "rc";
				break;
			case "right bottom":
			case "100% 100%":
				document.getElementById("elem_pfondo").value = "rb";
				break;
			case "center top":
			case "50% 0%":
				document.getElementById("elem_pfondo").value = "ct";
				break;
			case "center center":
			case "50% 50%":
				document.getElementById("elem_pfondo").value = "cc";
				break;
			case "center bottom":
			case "50% 100%":
				document.getElementById("elem_pfondo").value = "cb";
				break;
			default:
				document.getElementById("elem_pfondo").value = "";
				break;
		}
	} else {
		document.getElementById("elem_rfondo").value = "no";
		document.getElementById("elem_pfondo").value = "no";
	}
	
	// El contenido...
	var ed = tinyMCE.get('editor');
	// Do you ajax call here, window.setTimeout fakes ajax call
	ed.setProgressState(1); // Show progress
	window.setTimeout(function() {
		ed.setProgressState(0); // Hide progress
		ed.setContent(document.getElementById(oid).innerHTML);
	}, 3000);
	
	// por último el código, tipo e idElemento
	document.getElementById("elem_tipo").value = tipo;
	document.getElementById("elem_codigo").value = oid;
	document.getElementById("idElemento").value = eid;
	
}
				

// Añade un bloque informativo
function addInfo(texto,tipo) {
	var marco = document.getElementById("mensajes-doc");
	var previo = marco.innerHTML;
	var mensaje = '<div class="panel-' + tipo + '"><p>' + texto + '</p></div>';
	marco.innerHTML += "\n" + mensaje;
}

// Prepara los estilos de la modal
function estilosModal(alto,ancho) {
	var capaEstilos = document.getElementById("estilos-modal");
	var altoContainer = (parseFloat(alto) + parseFloat(20) > 310) ? parseFloat(alto) + parseFloat(20) : 310;
	var altoContent = (parseFloat(alto) + parseFloat(10) > 300) ? parseFloat(alto) + parseFloat(10) : 300;
	var anchoContainer = parseFloat(ancho) + parseFloat(113);
	var anchoContent = parseFloat(ancho) + parseFloat(103);
	
	var contenido = "<style>\n";
	contenido += "#simplemodal-container {height:" + altoContainer + "mm; width: " + anchoContainer + "mm;}\n";
	contenido += "#basic-modal-content {height:" + altoContent + "mm; width: " + anchoContent + "mm;}\n";
	contenido += "#marco-documento {height:" + alto + "mm; width: " + ancho + "mm;}\n";
	contenido += "</style>\n";
	capaEstilos.innerHTML = contenido;
	// para internet explorer:
	/*
	document.getElementById("simplemodal-container").style.height = altoContainer + "mm";
	document.getElementById("simplemodal-container").style.width = anchoContainer + "mm";
	document.getElementById("basic-modal-content").style.height = altoContent + "mm";
	document.getElementById("basic-modal-content").style.width = anchoContent + "mm";
	document.getElementById("marco-documento").style.height = alto + "mm";
	document.getElementById("marco-documento").style.width = ancho + "mm";
	*/
}

// obtiene medidas
function medidaModalTipo(valor,tipo) {
	var res = 0;
	switch(tipo) {
		case "altoContainer":
			res = (parseFloat(valor) + parseFloat(20) > 310) ? parseFloat(valor) + parseFloat(20) : 310;
			break;
		case "altoContent":
			res = (parseFloat(valor) + parseFloat(10) > 300) ? parseFloat(valor) + parseFloat(10) : 300;
			break;
		case "anchoContainer":
			res = parseFloat(valor) + parseFloat(113);
			break;
		case "anchoContent":
			res = parseFloat(valor) + parseFloat(103);
			break;
		
	}
	return res;
}

// Imprime un documento:
function imprimirDoc() {
	var contenidoDoc = document.getElementById("contenido-documento").innerHTML;
	document.getElementById("contenidoDoc").value = contenidoDoc;
	document.getElementById("accion").value = "imprimir-doc";
	document.forms["formDOP"].target="_blank";
	document.forms["formDOP"].submit();
	document.forms["formDOP"].target="";
}

function imprimirDocumento() {
	var contenido = document.getElementById("contenido-documento").innerHTML;
	if(contenido == "") {
		alert("no hay contenido");
	} else {
		recorrer();
		document.getElementById("contenidoDoc").value = contenido;
		document.getElementById("accion").value = "imprimir-doc";
		document.forms["formDOP"].target="_blank";
		document.forms["formDOP"].submit();
		document.forms["formDOP"].target="";
		//alert("se imprimiría: " + contenido);
	}
}

function imprimir(id) {
	document.getElementById("docId").value = id;
	document.getElementById("accion").value = "imprimir";
	document.forms["formDOP"].target="_blank";
	document.forms["formDOP"].action = document.getElementById("urlContent").value + "/themes/twentyeleven-child/pdf.php";
	document.forms["formDOP"].submit();
	document.forms["formDOP"].target="";
	document.forms["formDOP"].action="";
}

function guardar(id) {
	document.getElementById("docId").value = id;
	document.getElementById("accion").value = "guardar-doc";
	document.forms["formDOP"].submit();
}

// Check de formulario
function chkForm(pElement) {
	var patron;
	var elementos = document.forms["formDOP"].elements.length;
	var elemento;
	for(i=0;i<elementos;i++) {
		if(!(typeof document.forms["formDOP"].elements[i].name === "undefined")) {
			if(document.forms["formDOP"].elements[i].name.match(pElement)) {
				elemento = document.forms["formDOP"].elements[i];
				/* comprobaciones */
				// obligatorio
				patron = /obligatorio/;
				if(elemento.className.match(patron) && elemento.value == "") return elemento.name + ":el campo ha de tener un valor";
				//patron = /campo-fk/;
				//if(elemento.className.match(patron) && elemento.value == "") return elemento.name + ":el campo de referencia ha de tener un valor";
				// entero
				patron = /campo-integer/;
				if(elemento.className.match(patron) && elemento.value != "" && !esEntero(elemento.value)) return elemento.name + ":el campo ha de ser un número entero";
				// float
				patron = /campo-float/;
				if(elemento.className.match(patron) && elemento.value != "" && !esNum(elemento.value)) return elemento.name + ":el campo ha de ser un número";
				// datetime
				patron = /campo-datetime/;
				if(elemento.className.match(patron) && elemento.value != "" && !esTimeStamp(elemento.value)) return elemento.name + ":el campo ha de ser una fecha completa válida dd/mm/yyyy hh:mm:ss";
				// date
				patron = /campo-date\s/;
				if(elemento.className.match(patron) && elemento.value != "" && !esFecha(elemento.value)) return elemento.name + ":el campo ha de ser una fecha válida dd/mm/yyyy";
				
			}
		}
	}
	return "S";
}

// Alta de doumento
function crearRegistro() {
	var patron = /new_/;
	var r = chkForm(patron);
	if(r != "S") {
		var opciones = r.split(":");
		alert(opciones[1]);
		document.getElementById(opciones[0]).focus();
	} else {
		document.getElementById("accion").value = 'alta';
		document.forms["formDOP"].submit();
	}
}

// COMPROBACIONES
// comprueba la validez de una fecha.
function esFecha(p_fecha) {
  var v_ar_dias = new Array;
  var v_dia = null;
  var v_mes = null;
  var v_ani = null;
	
  v_ar_dias[1] = 31;
  v_ar_dias[2] = 28;
  v_ar_dias[3] = 31;
  v_ar_dias[4] = 30;
  v_ar_dias[5] = 31;
  v_ar_dias[6] = 30;
  v_ar_dias[7] = 31;
  v_ar_dias[8] = 31;
  v_ar_dias[9] = 30;
  v_ar_dias[10] = 31;
  v_ar_dias[11] = 30;
  v_ar_dias[12] = 31;
	
  if(p_fecha.length != 10 && p_fecha.length != 8) {
    //alert("La fecha indicada ha de tener 8 o 10 caracteres dd/mm/yy o dd/mm/yyyy.");
    return false;
  }
	
  var v_sep = '/';
  if(p_fecha.indexOf(v_sep) < 0)
    v_sep = '-';
  if(p_fecha.indexOf(v_sep) < 0) {
    //alert("La fecha debe tener como separador de dia mes y a?o el caracter / o - dd/mm/yyyy o dd-mm-yyyy"); 
    return false
  }
	
  v_dia = p_fecha.substr(0,2);
  v_mes = p_fecha.substr(3,2);
  v_ani = p_fecha.substr(6,4);
	
  if(!esEntero(v_dia)) {
    //alert("El dia indicado no es un valor numerico valido.");
    return false;
  }
  if(!esEntero(v_mes)) {
    //alert("El mes indicado no es un valor numerico valido.");
    return false;
  }
  if(!esEntero(v_ani)) {
    //alert("El a?o indicado no es un valor numerico valido.");
    return false;
  }
  if((p_fecha.substr(2,1) != '-' && p_fecha.substr(2,1) != '/') || (p_fecha.substr(5,1) != '-' && p_fecha.substr(5,1) != '/')) {
	//alert("Los separadores no son correctos.");
    return false;
  }
	
  if(parseInt(v_ani,10) % 4 == 0 && (!(parseInt(v_ani,10) % 100 == 0) || parseInt(v_ani,10) % 400 == 0))
    v_ar_dias[2] = 29;
	
  if(parseInt(v_mes,10) < 1 || parseInt(v_mes,10) > 12) {
    //alert("El mes ha de tener un valor comprendido entre 1 y 12.");
    return false;
  }
	
  if(parseInt(v_dia,10) < 1 || parseInt(v_dia,10) > v_ar_dias[parseInt(v_mes,10)]) {
    //alert("Para el mes " + v_mes + " el dia ha de tener un valor comprendido entre 1 y " + v_ar_dias[parseInt(v_mes,10)] + ".");
    return false;
  }
	
  return true;
}

// TIME
function esTime(p_time) {
	var k_sep = ":";
  var v_hora = 0;
  var v_minutos = 0;
	var v_segundos = 0;
  var v_sep1 = k_sep;
	var v_sep2 = k_sep;
  if(p_time.length != 5 && p_time.length != 8) return false;
  v_hora = p_time.substr(0,2);
  v_sep1 = p_time.substr(2,1);
  v_minutos = p_time.substr(3,2);
	if(p_time.length == 8) {
		v_sep2 = p_time.substr(5,1);
		v_segundos = p_time.substr(6,2);
	}
  if(!esEntero(v_hora) || v_hora < 0 || v_hora > 24) return false;
  if(!esEntero(v_minutos) || v_minutos < 0 || v_minutos > 59) return false;
	if(!esEntero(v_segundos) || v_segundos < 0 || v_segundos > 59) return false;
  if(v_sep1 != k_sep || v_sep2 != k_sep ) return false;
  return true;
}

// TIMESTAMP
function esTimeStamp(p_tstamp) {
	if(p_tstamp.indexOf(" ") < 0) return false;
	var arrTStamp = p_tstamp.split(" ");
	var fecha = arrTStamp[0];
	var hora = arrTStamp[1];
	if(!esFecha(fecha)) return false;
	if(!esTime(hora)) return false;
	return true;
}

function puedeSerTimeStamp(p_tstamp) {
	if(p_tstamp.indexOf(" ") < 0) {
		return esFecha(p_tstamp);
	} else {
		return esTimeStamp(p_tstamp);
	}
}

// Función que indica si una cadena es un entero o no.
function esEntero(p_numero) {
  v_numero = String(p_numero);
  for(v_i=0;v_i<v_numero.length;v_i++) {
    if(v_numero.charAt(v_i) < '0' || v_numero.charAt(v_i) > '9')
      return false;
  }
  return true;
}

//Functión que devuelve si un valor es numerico o no
function esNum(p_num) {
	
  var v_flg_signo = 0;
  var v_num_coma = 0;
  var v_num_punto = 0;	
    
  p_num = p_num.toString();

  //Se sustituyen la coma por el punto
  while (p_num.indexOf(',') != -1) {
	p_num = p_num.replace(',','.');
  }    

  if (p_num.length == 0) return true;

  for (var n = 0; n < p_num.length; n++){
   	if ((n == 0 ) && ((p_num.substring(0, 1) == '+') || (p_num.substring(0, 1) == '-'))) {
	  v_flg_signo = 1; // En principio no tiene utilidad.
    } else if (p_num.substring(n, n+1) == "." ) {
	  v_num_punto = v_num_punto + 1;
	} else if (p_num.substring(n, n+1) == "," ) {
	  v_num_coma = v_num_coma + 1;
	} else if (p_num.substring(n, n+1) < "0" || p_num.substring(n, n+1) > "9") {
	  //alert("El campo introducido debe ser un numerico !!");
	  return false;
	}
  }
		
  if (v_num_punto > 1 || v_num_coma > 0) { // no debe tener comas
	//alert("El campo introducido debe ser un numerico !!");			
	return false;
  }
  return true;
}

// Validación de mail...
function esMail(mail) {
	//expresion regular  
  var b=/^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/;
  //devuelve verdadero si validacion OK, y falso en caso contrario  
  return b.test(mail)
}

// NIF
function esNIF(nif) {
	dni=nif.substring(0,nif.length-1)
	let=nif.charAt(nif.length-1)
	if (!isNaN(let)) {
		alert('Falta la letra')
		document.formulario.nif.focus()
		return false
	} else {
		cadena="TRWAGMYFPDXBNJZSQVHLCKET"
		posicion = dni % 23
		letra = cadena.substring(posicion,posicion+1)
		if (letra!=let.toUpperCase()) {
			alert("Nif no válido")
			document.formulario.nif.focus()
			return false
		}
	}
	alert("Nif válido");
}

// comprueba campos de documento
function chkCamposDocumento() {
	if(document.getElementById("idDocumento").value == "") {
		alert("No hay documento seleccionado.");
		return "N";
	}
	if(document.getElementById("doc_nombre").value == "") {
		alert("Ha de indicar un nombre para el documento.");
		document.getElementById("doc_nombre").focus();
		return "N";
	}
	if(document.getElementById("doc_version").value == "") {
		alert("Ha de indicar una versión para el documento.");
		document.getElementById("doc_version").focus();
		return "N";
	}
	if(document.getElementById("doc_alto").value == "") {
		alert("Ha de indicar un alto para el documento.");
		document.getElementById("doc_alto").focus();
		return "N";
	}
	if(!esNum(document.getElementById("doc_alto").value)) {
		alert("El alto ha de ser un número válido (los decimales se separan con comas)");
		document.getElementById("doc_alto").focus();
		return "N";
	}
	if(document.getElementById("doc_ancho").value == "") {
		alert("Ha de indicar un ancho para el documento.");
		document.getElementById("doc_ancho").focus();
		return "N";
	}
	if(!esNum(document.getElementById("doc_ancho").value)) {
		alert("El ancho ha de ser un número válido (los decimales se separan con comas)");
		document.getElementById("doc_ancho").focus();
		return "N";
	}
	if(confirm("El cambio de dimensiones puede causar desconfiguración de sus elementos. ¿Desea continuar con el cambio?")) return "S";
	return "N";
}

// comprueba campos nuevo elemento
function chkCamposNElemento() {
	if(document.getElementById("idPagina").value == "") {
		alert("No hay página seleccionada en check.");
		return "N";
	}
	if(document.getElementById("div_f_alto").value == "") {
		alert("Ha de indicar un alto para el elemento.");
		document.getElementById("div_f_alto").focus();
		return "N";
	}
	if(!esNum(document.getElementById("div_f_alto").value)) {
		alert("El alto ha de ser un número válido (los decimales se separan con comas)");
		document.getElementById("div_f_alto").focus();
		return "N";
	}
	if(document.getElementById("div_f_ancho").value == "") {
		alert("Ha de indicar un ancho para el elemento.");
		document.getElementById("div_f_ancho").focus();
		return "N";
	}
	if(!esNum(document.getElementById("div_f_ancho").value)) {
		alert("El ancho ha de ser un número válido (los decimales se separan con comas)");
		document.getElementById("div_f_ancho").focus();
		return "N";
	}
	var elementosInt = new Array;
	var i=0;
	elementosInt[i++] = "div_f_dtop";
	elementosInt[i++] = "div_f_dleft";
	elementosInt[i++] = "div_f_zindex";
	elementosInt[i++] = "div_f_mtop";
	elementosInt[i++] = "div_f_mright";
	elementosInt[i++] = "div_f_mbottom";
	elementosInt[i++] = "div_f_mleft";
	elementosInt[i++] = "div_f_ptop";
	elementosInt[i++] = "div_f_pright";
	elementosInt[i++] = "div_f_pbottom";
	elementosInt[i++] = "div_f_pleft";
	elementosInt[i++] = "div_f_borde";
	for(i=0;i<elementosInt.length;i++) {
		if(document.getElementById(elementosInt[i]).value != "" && !esNum(document.getElementById(elementosInt[i]).value)) {
			alert("La posición ha de ser un número válido (los decimales se separan con puntos)");
			document.getElementById(elementosInt[i]).focus();
			return "N";
		}
	}
	return "S";
}

function getInMm(valor) {
	// La idea es una simple regla de tres. Obtenemos el valor del alto del documento en mm que tenemos en el input y el valor en píxeles por CSS.
	// Por parámetro obtenemos un valor en píxeles y creamos una regla de 3 con la que obtendremos la posición en mm...
	if(valor == "" || !esNum(valor)) {
		alert("Error de parámetro");
		return 0;
	}
	var paginaIH = $DDP(".pagina").innerHeight();
	var paginaHMm = document.getElementById("doc_alto").value;
	//alert("pagina tiene " + paginaIH + " de inner y " + paginaHMm + " de doc");
	if(paginaIH == "") {
		alert("No hay página seleccionada para pasara a mm");
		return 0;
	}
	var res = valor * paginaHMm / paginaIH;
	//alert("res es " + valor + " * " + paginaHMm + " / " + paginaIH);
	return Math.round(res*100)/100;
}

function recorrer() {
	var i = 0;
	var position;
	var topPx = 0;
	var leftPx = 0;
	var contenido = document.getElementById("contenido-documento").innerHTML;
	var pos = contenido.indexOf("px;");
	if(pos != -1) {
		alert("Atención!!! para la correcta impresión se reestructuran las medidas...");
		$DDP(".elemento-libre").each(function (index) {
			//$(this).removeClass();
			//$(this).addClass("parrafo");
			//$(this).text('Parrafo ' + index);
			i++;
			position = $DDP(this).position();
			$DDP(this).css("top",Math.round(getInMm(position.top)) + "mm");
			$DDP(this).css("left",Math.round(getInMm(position.left)) + "mm");
		});
	}
}

function ultimoElemento(tipo) {
	var patron = "." + tipo;
	var num = 0;
	$DDP(patron).each(function (index) {
		if(esEntero($DDP(this).attr("rel"))) num = ($DDP(this).attr("rel") > num) ? $DDP(this).attr("rel") : num;
	});
	num++;
	return num;
}

function getIndice(obj,valor) {
	var indice = "";
	var i=0;
	var enc = false;
	while(i<obj.length && !enc){
		if(obj[i] == valor){
			enc = true;
			indice = i;
		}
		i++;
	}
	return indice;
}

// comprueba campos de filtros
function chkFiltros() {
	if(document.getElementById("filtro_fec_alta_desde").value != "" && !esFecha(document.getElementById("filtro_fec_alta_desde").value)) {
		alert("No se ha indicado una fecha válida.");
		document.getElementById("filtro_fec_alta_desde").focus();
		return "N";
	}
	if(document.getElementById("filtro_fec_alta_hasta").value != "" && !esFecha(document.getElementById("filtro_fec_alta_hasta").value)) {
		alert("No se ha indicado una fecha válida.");
		document.getElementById("filtro_fec_alta_hasta").focus();
		return "N";
	}
	return "S";
}

// filtrar
function filtrarDatos() {
	var r = chkFiltros();
	if(r == "S") {
		document.getElementById("accion").value = "";
		document.forms["formDOP"].submit();
	}
}

// Esto vale para recoger todo en formato html de area de texto, Jon Angulo a 22/03/2012
function ajaxSave() {
	var ed = tinyMCE.get('editor');
	ed.setProgressState(1); 
	window.setTimeout(function() {
		ed.setProgressState(0); 
		alert(ed.getContent());
	}, 10);
}

function ifondoSave() {
	var ed = tinyMCE.get('txtSelFondo');
	var contenido = ed.getContent();
	var patron = /<img src=\"\.\.\/wp\-content([^"]+)\"/gi;
	var encuentro = contenido.match(patron);
	var repeticion = document.getElementById("elem_rfondo").value;
	var posicion = document.getElementById("elem_pfondo").value;
	if(!contenido.match(patron)) alert("No hay imagen cargada");
	else if(posicion == "no") alert("Se ha indicado que no se desea imágen de fondo (Posición de la imágen de fondo).");
	else {
		//var temp = contenido.split
		var resultado = encuentro.toString().replace(patron,"$1");
		var ifondo = document.getElementById("urlContent").value + resultado;
		var pfondo = "";
		switch(posicion) {
			case "lt":
				pfondo = "left top";
				break;
			case "lc":
				pfondo = "left center";
				break;
			case "lb":
				pfondo = "left bottom";
				break;
			case "ct":
				pfondo = "center top";
				break;
			case "cc":
				pfondo = "center center";
				break;
			case "cb":
				pfondo = "center bottom";
				break;
			case "rt":
				pfondo = "right top";
				break;
			case "rc":
				pfondo = "right center";
				break;
			case "rb":
				pfondo = "right bottom";
				break;
			case "":
				pfondo = "";
				break;
			
		}
		var rfondo = "";
		switch(repeticion) {
			case "x":
				rfondo = "repeat-x";
				break;
			case "y":
				rfondo = "repeat-y";
				break;
			case "xy":
				rfondo = "repeat";
				break;
			case "no":
				rfondo = "no-repeat";
				break;
		}
		var destino = document.getElementById("elem_codigo").value;
		//alert("fondo de " + destino + " es:");
		//alert("ifondo: " + ifondo);
		//alert("pfondo: " + pfondo);
		//alert("rfondo: " + rfondo);
		$DDP("#" + destino).css("background-image","url(" + ifondo + ")");
		$DDP("#" + destino).css("background-position",pfondo);
		$DDP("#" + destino).css("background-repeat",rfondo);
		//alert("resultado: " + resultado);
		//alert("encuentro a " + encuentro);
	}
}

// cambio de estado
function chgEstado(id) {
	var origen = document.getElementById("estado-listado-" + id).value;
	document.getElementById("estado-listado").value = origen;
	document.getElementById("docId").value = id;
	document.getElementById("accion").value = "chg-estado";
	document.forms["formDOP"].submit();
}

// pasar a tab
jQuery.fn.validateTab = function (toTab) {
	if (!toTab) toTab = 0;
	$DDP("#tabs").tabs('select', toTab);
	return false;
}

// Actualiza un elemento:
function actualizaElemento(nombre) {
	var idElemento = document.getElementById("idElemento").value;
	if(idElemento != "") {
		//var idPagina = document.getElementById("idPagina").value;
		var codigo = document.getElementById("elem_codigo").value;
		var miName = nombre;
		var valor = document.getElementById(miName).value;
		//alert("checkeamos " + codigo + " con name " + miName);
		/******************************************/
		/* Tenemos dos formas de asociar los estilos, por su capa de estilos y por su propio style...
		/* por CAPA:
		/*	-	top
		/*	-	left
		/*	-	background-image
		/*	-	background-repat
		/*	-	background-position
		/* por STYLE:
		/*	- el resto
		/******************************************/
		if(miName == "elem_dtop" || miName == "elem_dleft" || miName == "elem_pfondo" || miName == "elem_rfondo") {
			switch(miName) {
				case "elem_dtop":
					//$DDP("#" + codigo).css("top",valor + "mm");
					break;
				case "elem_dleft":
					//$DDP("#" + codigo).css("left",valor + "mm");
					break;
				case "elem_pfondo":
					switch(valor) {
						case "":
							$DDP("#" + codigo).css("background-position","");
							break;
						case "no":
							$DDP("#" + codigo).css("background-position","");
							$DDP("#" + codigo).css("background-image","");
							break;
						case "lt":
							$DDP("#" + codigo).css("background-position","left top");
							break;
						case "lc":
							$DDP("#" + codigo).css("background-position","left center");
							break;
						case "lb":
							$DDP("#" + codigo).css("background-position","left bottom");
							break;
						case "ct":
							$DDP("#" + codigo).css("background-position","center top");
							break;
						case "cc":
							$DDP("#" + codigo).css("background-position","center center");
							break;
						case "cb":
							$DDP("#" + codigo).css("background-position","center bottom");
							break;
						case "rt":
							$DDP("#" + codigo).css("background-position","right top");
							break;
						case "rc":
							$DDP("#" + codigo).css("background-position","right center");
							break;
						case "rb":
							$DDP("#" + codigo).css("background-position","right bottom");
							break;
					}
					break;
				case "elem_rfondo":
					switch(valor) {
						case "no":
							$DDP("#" + codigo).css("background-repeat","");
							break;
						case "x":
							$DDP("#" + codigo).css("background-repeat","repeat-x");
							break;
						case "y":
							$DDP("#" + codigo).css("background-repeat","repeat-y");
							break;
						case "xy":
							$DDP("#" + codigo).css("background-repeat","repeat");
							break;
					}
					break;	
			}
		} else {
			var styleId = "estilos-" + codigo;
			var styleHTML = document.getElementById(styleId).innerHTML;
			var temp = styleHTML.split("{");
			if(temp[1] != undefined && temp[1] != "undefined") temp = temp[1].split("}");
			var tEstilos = temp[0].split(";");
			var cEstilos = new Array;
			var vEstilos = new Array;
			var i = 0;
			var chkBTop = "N";
			var chkBRight = "N";
			var chkBBottom = "N";
			var chkBLeft = "N";
			var chkCFondo = "N";
			for(iEstilo in tEstilos) {
				estilo = tEstilos[iEstilo].split(":");
				if(estilo[0] != "" && estilo[1] != undefined) {
					temp = estilo[0].replace(/^(\s)*|(\s)*$/g,"");
					cEstilos[i] = temp;
					vEstilos[i] = estilo[1];
					if(temp == "border-top") chkBTop = "S";
					if(temp == "border-right") chkBRight = "S";
					if(temp == "border-bottom") chkBBottom = "S";
					if(temp == "border-left") chkBLeft = "S";
					if(temp == "background-color") chkCFondo = "S";
					i++;
				}
			}
			if(chkBTop == "N") {
				cEstilos[i] = "border-top";
				vEstilos[i] = "0mm";
				i++;
			}
			if(chkBRight == "N") {
				cEstilos[i] = "border-right";
				vEstilos[i] = "0mm";
				i++;
			}
			if(chkBBottom == "N") {
				cEstilos[i] = "border-bottom";
				vEstilos[i] = "0mm";
				i++;
			}
			if(chkBLeft == "N") {
				cEstilos[i] = "border-left";
				vEstilos[i] = "0mm";
				i++;
			}
			if(chkCFondo == "N") {
				cEstilos[i] = "background-color";
				vEstilos[i] = "#FFFFFF";
				i++;
			}
			var indice = "";
			switch(miName) {
				case "elem_alto":
					indice = getIndice(cEstilos,"height");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_ancho":
					indice = getIndice(cEstilos,"width");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_zindex":
					indice = getIndice(cEstilos,"z-index");
					if(indice != "") vEstilos[indice] = valor;
					break;
				case "elem_mtop":
					indice = getIndice(cEstilos,"margin-top");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_mright":
					indice = getIndice(cEstilos,"margin-right");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_mbottom":
					indice = getIndice(cEstilos,"margin-bottom");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_mleft":
					indice = getIndice(cEstilos,"margin-left");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_ptop":
					indice = getIndice(cEstilos,"padding-top");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_pright":
					indice = getIndice(cEstilos,"padding-right");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_pbottom":
					indice = getIndice(cEstilos,"padding-bottom");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_pleft":
					indice = getIndice(cEstilos,"padding-left");
					if(indice != "") vEstilos[indice] = valor + "mm";
					break;
				case "elem_borde":
				case "elem_cborde":
				case "elem_flg_cborde":
					var gBorde = document.getElementById("elem_borde").value;
					var cBorde = document.getElementById("elem_cborde").value;
					var fBorde = document.getElementById("elem_flg_cborde").checked;
					var dBorde = (fBorde) ? gBorde + "mm solid " + cBorde : "0mm";
					indice = getIndice(cEstilos,"border-top");
					if(indice != "") vEstilos[indice] = dBorde;
					vEstilos[indice] = dBorde;
					indice = getIndice(cEstilos,"border-right");
					if(indice != "") vEstilos[indice] = dBorde;
					indice = getIndice(cEstilos,"border-bottom");
					if(indice != "") vEstilos[indice] = dBorde;
					indice = getIndice(cEstilos,"border-left");
					if(indice != "") vEstilos[indice] = dBorde;
					break;
				case "elem_cfondo":
				case "elem_flg_cfondo":
					var cFondo = document.getElementById("elem_cfondo").value;
					var fFondo = document.getElementById("elem_flg_cfondo").checked;
					valor = (fFondo) ? cFondo : "";
					indice = getIndice(cEstilos,"background-color");
					vEstilos[indice] = valor;
					break;
			}
			// preparamos la cadena HTML
			var newStyle = "<style>#" + codigo + " { ";
			for(cEstilo in cEstilos) if(vEstilos[cEstilo] != "" && vEstilos[cEstilo] != undefined) newStyle += cEstilos[cEstilo] + ": " + vEstilos[cEstilo].replace(/^(\s)*|(\s)*$/g,"") + "; ";
			newStyle += " } </style>";
			estilos = null;
			document.getElementById(styleId).innerHTML = newStyle;
			//alert("nuevo: " + newStyle);
		}
	}
}

// borrar un documento
function borrar(idDocumento) {
	if(idDocumento == "") {
		alert("Error de documento, no hay documento seleccionado.");
		return;
	}
	if(confirm("Está a punto de eliminar el documento, desea continuar?")) {
		document.getElementById("docId").value = idDocumento;
		document.getElementById("accion").value = "borrar-documento";
		document.forms["formDOP"].submit();
	}
}
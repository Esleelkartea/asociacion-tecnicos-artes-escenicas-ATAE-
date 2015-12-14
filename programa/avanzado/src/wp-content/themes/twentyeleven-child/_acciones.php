<?php
/****************************************************************************************************/
/* Pantalla: _acciones.php
/* Theme: doconline
/* Descripción: página de ejecución de acciones
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.		07/03/2012	Creación               
/*
/****************************************************************************************************/

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : NULL;

switch($accion) {
	case 'imprimir-doc':
		$html = (isset($_POST['contenidoDoc'])) ? $_POST['contenidoDoc'] : NULL;
		$html = str_replace('\\"','"',$html);
		//echo '<p>HTML:</p>'.$html.'<br/>';
		include("mpdf/mpdf.php");
		$medidas = array(210,297);
		$mpdf = new mPDF('s',$medidas,0,'',0,0,0,0);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);   // Separate Paragraphs  defined by font
		/*
		// Ejemplo de página nueva
$mpdf->AddPage();
$html = '<style>';
$html .= '.pagina {position:relative;height:296mm;width:210mm;}';
$html .= 'p {margin:0;padding:0;}';
$html .= '</style>';
$html .= '<div id="pagina-1-plantilla-2" class="pagina"></div>';
$html .= '<div id="elemento-libre-3" class="elemento-pagina elemento-libre elemento-draggable ui-draggable" style="background-color: rgb(255, 0, 0); height: 50mm; width: 50mm; position: absolute; border-top: 2px solid #999999; top: 0mm; left: 14mm; "><p>VIVA MEJICO</p></div>';
$html .= '<div id="elemento-libre-4" class="elemento-pagina elemento-libre elemento-draggable ui-draggable" style="background-color: rgb(179, 250, 255); height: 90mm; width: 50mm; position: absolute; border-top-width: 0.5mm; border-top-style: solid; border-top-color: rgb(252, 5, 5); border-right-width: 0.5mm; border-right-style: solid; border-right-color: rgb(252, 5, 5); border-bottom-width: 0.5mm; border-bottom-style: solid; border-bottom-color: rgb(252, 5, 5); border-left-width: 0.5mm; border-left-style: solid; border-left-color: rgb(252, 5, 5); top: 8mm; left: 20mm; "><p>VIVA MEJICO</p></div>';
$mpdf->WriteHTML($html);
*/
		$mpdf->Output();
		break;
	case 'guardar-doc':
		if(!defined('WMARKTEXT')) define('WMARKTEXT','BORRADOR');
		$myPath = dirname(__FILE__);
		$myUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$myPath = substr($myPath,0,strpos($myPath,'wp-content')+11);
		$myUrl = substr($myUrl,0,strpos($myUrl,'wp-content')+11);

		if(!defined('CONTENTPATH')) define('CONTENTPATH', $myPath);
		if(!defined('CONTENTURL')) define('CONTENTURL', $myUrl);
		$accion = (isset($_POST['accion'])) ? $_POST['accion'] : NULL;
		$idDocumento = (isset($_POST['docId'])) ? $_POST['docId'] : NULL;
		include_once(WP_CONTENT_DIR."/themes/twentyeleven-child/mpdf/mpdf.php");
		$documento = Datos::getDocumentoData($idDocumento);
		if($documento === false) echo 'ERROR AL OBTENER DATOS DEL DOCUMENTO!!!<br/>';
		// Hallamos las páginas
		$tPaginas = Datos::getPaginas($idDocumento); // Lo metemos en un temporal para ordenar después
		if($paginas === false) echo '<div class="panel-error">Error al obtener las paacute;ginas del documento '.$idDocumento.'</div>';
		if(!is_array($tPaginas)) echo '<div class="panel-alert">No hay p&aacute;ginas para el documento '.$idDocumento.'</div>';	
		else {
			$portada = NULL;
			$contraportada = NULL;
			$paginas = NULL;
			foreach($tPaginas as $pagina) {
				switch($pagina['tipo']) {
					case 'portada':
						$portada = $pagina;
						break;
					case 'contraportada':
						$contraportada = $pagina;
						break;
					case 'pagina':
						if($paginas == NULL) $paginas = array();
						$paginas[$pagina['numero']] = $pagina;
						break;
				}
			}
			$medidas = array($documento['ancho'],$documento['alto']);
			$mpdf = new mPDF('s',$medidas,0,'',0,0,0,0);
			$mpdf->SetDisplayMode('fullpage');
			if($documento['estado'] != 'pagado') {
				$mpdf->SetWatermarkText(WMARKTEXT);
				$mpdf->showWatermarkText = true;
			}
			$aHtml = NULL;
			$patronSrc = 'img src="../wp-content/';
			$cambioSrc = 'img src="'.CONTENTURL;
			// portada
			if($portada != NULL) {
				$mpdf->AddPage();
				$aHtml = array();
				$aHtml[] = $documento['contenido'];
				$aHtml[] = str_replace($patronSrc,$cambioSrc,utf8_encode($portada['contenido']));
				$html = implode("\n",$aHtml);
				$mpdf->WriteHTML($html);
			}
			// páginas
			if(is_array($paginas)) {
				foreach($paginas as $pagina) {
					$mpdf->AddPage();
					$aHtml = array();
					$aHtml[] = $documento['contenido'];
					$aHtml[] = str_replace($patronSrc,$cambioSrc,$pagina['contenido']);
					if($documento['numerada'] == 'S') $aHtml[] = '<div style="position:absolute; bottom:3mm; right:3mm;">'.$pagina['numero'].' / '.count($paginas).'</div>';
					// si hubiese numeración estaría aquí...
					$html = implode("\n",$aHtml);
					$mpdf->WriteHTML($html);
				}
			}
			// contraportada
			if($contraportada != NULL) {
				$mpdf->AddPage();
				$aHtml = array();
				$aHtml[] = $documento['contenido'];
				$aHtml[] = str_replace($patronSrc,$cambioSrc,$contraportada['contenido']);
				$html = utf8_encode(implode("\n",$aHtml));
				$mpdf->WriteHTML($html);
			}
			$filetitle = ($documento['referencia'] != NULL) ? $documento['referencia'] : $documento['codigo'];
			$filename = $filetitle.'.pdf';
			$upload_dir = wp_upload_dir();
			// comprobamos el nombre final
			$i = 0;
			while (file_exists( $upload_dir['path'] .'/' . $filename)) {
				$filename = $filetitle . '_' . $i . '.pdf';
				$i++;
			}
			$filedest = $upload_dir['path'].'/'.$filename;
			// guardamos
			$mpdf->Output($filedest,'F');
			// comprobamos si existe...
			if(!file_exists($filedest)) echo '<div class="panel-alert">Error al crear '.$filedest.'</div>';	
			else {
				// guardamos los datos de media
				$filetype = wp_check_filetype($filedest,null);
				$attachment = array(
					'post_mime_type' => $filetype['type'],
					'post_title' => $filetitle,
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment($attachment,$filedest);
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$attach_data = wp_generate_attachment_metadata($attach_id,$filedest);
				wp_update_attachment_metadata($attach_id,$attach_data);
				$mensajes[] = 'El documento ha sido correctamente guardado, revise la librería multimedia.';
			}
		}
		break;
	case 'alta':
		// campos
		$version = (isset($_POST['new_version'])) ? $_POST['new_version'] : NULL;
		$referencia = (isset($_POST['new_referencia'])) ? $_POST['new_referencia'] : NULL;
		$tipo = (isset($_POST['new_tipo'])) ? $_POST['new_tipo'] : NULL;
		$nombre = (isset($_POST['new_nombre'])) ? $_POST['new_nombre'] : NULL;
		$descripcion = (isset($_POST['new_descripcion'])) ? $_POST['new_descripcion'] : NULL;
		$numerada = (isset($_POST['new_numerada'])) ? $_POST['new_numerada'] : NULL;
		$alto = (isset($_POST['new_alto'])) ? $_POST['new_alto'] : NULL;
		$ancho = (isset($_POST['new_ancho'])) ? $_POST['new_ancho'] : NULL;
		$idReferencia = (isset($_POST['new_idReferencia'])) ? $_POST['new_idReferencia'] : NULL;
		$args = array (
			'idUsuario' => $userData['id'],
			'version' => $version,
			'referencia' => $referencia,
			'tipo' => $tipo,
			'nombre' => $nombre,
			'descripcion' => $descripcion,
			'numerada' => $numerada,
			'alto' => $alto,
			'ancho' => $ancho,
			'idReferencia' => $idReferencia,
		);
		$r = Datos::altaDocumento($args);
		if($r === false) echo 'ERROR AL DAR DE ALTA EL DOCUMENTO!!!<br/>';
		//echo 'Como si diesemos de alta con referencia '.$idReferencia.'<br/>';
		
		break;
	case 'chg-estado':
		$docId = (isset($_POST['docId'])) ? $_POST['docId'] : NULL;
		$estado = (isset($_POST['estado-listado'])) ? $_POST['estado-listado'] : NULL;
		if($docId == NULL) echo 'ERROR al no obtener docId!!!<br/>';
		if($estado == NULL) echo 'ERROR al no obtener estado!!!<br/>';
		else {
			$args = array (
				'idDocumento' => $docId,
				'estado' => $estado,
			);
			$r = Datos::updEstadoDocumento($args);
			if($r === false) echo 'ERROR AL DAR MODIFICAR EL ESTADO DEL DOCUMENTO!!!<br/>';
			
		}
		break;
	case 'borrar-documento':
		$docId = (isset($_POST['docId'])) ? $_POST['docId'] : NULL;
		if($docId == NULL) {
			echo 'ERROR de parámetro, idDocumento no encontrado<br/>';
			break;
		}
		Datos::delDocumento($docId);
		break;
}
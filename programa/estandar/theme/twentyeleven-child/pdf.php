<?php
/****************************************************************************************************/
/* Include: pdf.php
/* Plugin: doconline
/* Descripción: pantalla que genera un pdf
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor					Fecha				Acción                                                                          
/*
/* Digital5 S.L.	27/03/2012	Creación               
/*
/****************************************************************************************************/

if(!defined('WMARKTEXT')) define('WMARKTEXT','BORRADOR');

$myPath = dirname(__FILE__);
$myUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$myPath = substr($myPath,0,strpos($myPath,'wp-content')+11);
$myUrl = substr($myUrl,0,strpos($myUrl,'wp-content')+11);

if(!defined('CONTENTPATH')) define('CONTENTPATH', $myPath);
if(!defined('CONTENTURL')) define('CONTENTURL', $myUrl);

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : NULL;
$idDocumento = (isset($_POST['docId'])) ? $_POST['docId'] : NULL;

include_once(CONTENTPATH."plugins/doconline/class/datos.class.php");
include_once(CONTENTPATH."themes/twentyeleven-child/mpdf/mpdf.php");

//echo 'idDocumento es '.$idDocumento.'<br/>';

// Hallamos los datos del documento.
if($idDocumento == "pruebas") {

$cHTML = '
<style>
.pagina {position:relative;height:210mm;width:99mm;} 
p {margin: 0; padding: 0;}
div {overflow: hidden;}
</style>
<div id="pagina-1-portada-1" class="pagina">
	<div></div>
	<div id="estilos-elemento-fijo-1">
	<style>
		#elemento-fijo-1 { 
			background-color:#FF8D63; 
			margin-top:3mm; 
			margin-right:0mm; 
			margin-bottom:0mm; 
			margin-left:2mm; 
			padding-top:0mm; 
			padding-right:0mm; 
			padding-bottom:0mm; 
			padding-left:0mm; 
			height:150mm;
			width:95mm;
			z-index:1000;
		}
	</style>
	</div>
	<div id="elemento-fijo-1" rel="1" style="background-image: url(http://localhost/clientes/atae/wp-content/plugins/doconline/images/elementos/reunion.jpg); background-position: left top; background-repeat: no-repeat no-repeat; ">
	</div>
	';
$documento = array (
	'estado' => 'nuevo',
	'alto' => 210,
	'ancho' => 99,
	'contenido' => $cHTML,
	'numerada' => 'N',
);

$medidas = array($documento['ancho'],$documento['alto']);
$mpdf = new mPDF('s',$medidas,0,'',0,0,3,0);
$mpdf->SetDisplayMode('fullpage');
if($documento['estado'] != 'pagado') {
	$mpdf->SetWatermarkText(WMARKTEXT);
	$mpdf->showWatermarkText = true;
}

$aHtml = NULL;
$patronSrc = 'img src="../wp-content/';
$cambioSrc = 'img src="'.CONTENTURL;

//$mpdf->AddPage();
$html = str_replace($patronSrc,$cambioSrc,utf8_encode($documento['contenido']));
$mpdf->WriteHTML($html);

$mpdf->Output();
	
} else {

$documento = Datos::getDocumentoData($idDocumento);
if($documento === false) echo '<div class="panel-error">Error al obtener los datos del documento '.$idDocumento.'</div>';

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
	// paginación
	//if($documento['numerada'] == 'S') $mpdf->setFooter('{PAGENO}');

	//$mpdf->allow_charset_conversion = true;
	//$mpdf->charset_in = 'UTF-8';	
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
	switch($accion) {
		case 'imprimir':
			$mpdf->Output($filename,'D');
			break;
		
	}
	// guardamos una descarga más
	$r = Datos::registraDescarga($idDocumento);
	if($r === false) echo '<div class="panel-error">Error al registrar la descarga del documento '.$idDocumento.'</div>';
	
}

} // pruebas
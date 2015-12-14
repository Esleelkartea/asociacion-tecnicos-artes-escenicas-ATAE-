<?php
/*
if(!defined('THEMEPATH')) define('THEMEPATH', dirname(__FILE__));
if(!defined('PLUGINPATH')) define('PLUGINPATH', dirname(__FILE__).'/../../plugins/doconline/');

$codPagina = (isset($_POST['pag_codigo'])) ? $_POST['pag_codigo'] : NULL;
$codElemento = (isset($_POST['elem_codigo'])) ? $_POST['elem_codigo'] : NULL;

$res = array();

if($codPagina == NULL || $codElemento == NULL) {
	$res[] = '<script language="javascript">';
	$res[] = 'alert("Error al obtener los par&aacute;metros de c&oacute;digos");';
	$res[] = 'self.close();';
	$res[] = '</script>';
} else if($_FILES['elem_ifondo']['size'] == 0) {
	$res[] = '<script language="javascript">';
	$res[] = 'alert("Error al obtener el fichero");';
	$res[] = 'self.close();';
	$res[] = '</script>';
} else {
	$uploaddir = PLUGINPATH.'images/elementos/';
	// Hallamos la extensión
	$extension = strtolower(substr($_FILES['elem_ifondo']['name'],-3));
	$extensiones = array('jpg','gif','png');
	if(!in_array($extension,$extensiones)) {
		$res[] = '<script language="javascript">';
		$res[] = 'alert("Atenci&oacute;n, el fichero ha de tener una extensi&oacute;n v&aacute;lida ('.implode(", ",$extensiones).')");';
		$res[] = 'self.close();';
		$res[] = '</script>';
	} else if($_FILES['elem_ifondo']['size'] > 1048576) {
		$res[] = '<script language="javascript">';
		$res[] = 'alert("Atenci&oacute;n, el fichero ha de pesar menos de 1 Mb (1048576 bytes)");';
		$res[] = 'self.close();';
		$res[] = '</script>';
	} else {
		$uploadfile = $uploaddir.$codPagina.'-'.$codElemento.'.'.$extension;
		if(!move_uploaded_file($_FILES['elem_ifondo']['tmp_name'],$uploadfile)) {
			$res[] = '<script language="javascript">';
			$res[] = 'alert("Error, no se ha podido subir '.$uploadfile.', compruebe permisos y htaccess.");';
			$res[] = 'self.close();';
			$res[] = '</script>';
		} else {
			$res[] = '<script language="javascript">';
			$res[] = 'alert("Imagen subida correctamente. Ahora puede actualizar el fondo.");';
			$res[] = 'self.close();';
			$res[] = '</script>';
		}
	}
}
echo implode("\n",$res);
?>
*/
$pr1 = (isset($_POST['pr1'])) ? $_POST['pr1'] : 'kkk';
echo $pr1.'<br/>';
$urlContent = $_POST['urlContent'];
if($_FILES['elem_ifondo']['size'] > 0) {
	echo 'Tamaño es '.$_FILES['elem_ifondo']['size'].'<br/>';
	?>
	<script language="javascript">
	alert("Tamaño es <?php echo $_FILES['elem_ifondo']['size']; ?>, con urlcontent <?php echo $urlContent; ?>");
	self.close();
	</script>
	<?php
} else {
	echo 'que fustaña<br/>';
	?>
	<script language="javascript">
	alert("ha fallado");
	self.close();
	</script>
	<?php
}

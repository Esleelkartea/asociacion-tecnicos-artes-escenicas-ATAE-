<?php
		
	include 'lib/config.php';
	include 'lib/funcions.php';
	
	// si se ha seleccionado algun checkbox para eliminar la imagen
	if(!empty($_POST['nom'])){
		foreach($_POST['nom'] as $img){
			echo "<div align='center'>[Imagen eliminada: " .$img . "]</div><br>";			
			deleteFile($img);
		}
	}
	
	
	// leo las imagenes del directorio de imagenes
	$imgs = llegirDir();
	
	// cuento el numero de imagenes
	$num_elem = count($imgs);
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body, td{
	font-family: verdana;
	font-size: 9px;
}

input{
	font-family: verdana;
	font-size: 9px;
	border: solid 1px gray;
	background-color: silver;
	padding: 2px;
}

img{
	border-color:gray;
}
</style>


<script type="text/javascript">
function resaltar(elem){
	elem.style.borderColor = 'red';
}

function no_resaltar(elem){
	elem.style.borderColor = 'gray';
}
</script>
</head>

<body>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
	<tr>
		<td>Haga click sobre una imagen para insertarla en el texto.<br>[<?= $num_elem; ?> im�genes]</td>
		<td align="right" valign="top"><input type="button" value="Eliminar im�genes seleccionadas" onClick="document.f.submit()"></td>
	</tr>
</table>
<br><br>
<form name="f" method="post" action="" style="display:inline">

<table width="100%" align="center" border="0">
	<tr>
<?php
	
	$i = 0;
	
	if (is_array($imgs)){
		foreach($imgs as $img){
		
			if(!($i % 3) && ($i != 0)) echo '<tr>';					
			
			echo '<td align="center" valign="middle"><table cellpadding="0" cellspacing="0" border="0" height="180"><tr><td><a href="javascript:parent.insertUrl(\''.BASE_RUTA_HTTP.$img.'\')" title="'.$img.'"><img src="lib/phpthumb/phpThumb.php?src=' . BASE_RUTA.$img . '&w=150&h=150" border="1" onmouseover="resaltar(this)" onmouseout="no_resaltar(this)"></a></td></tr><tr><td align="center" valign="bottom"><input name="nom[]" type="checkbox" value="'.$img.'"></td></tr></table></td>';
			
			$i++;
			if(!($i % 3) && ($i != 0)) echo '</tr>';
					
		}
	}
					

?>
</table>
</form>
</body>
</html>
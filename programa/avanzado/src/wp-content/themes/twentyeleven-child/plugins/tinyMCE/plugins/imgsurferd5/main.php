<?php

    include 'lib/config.php';
	include 'lib/funcions.php';
	
	if(isset($_POST['submit'])){
		/*
		$pagecode = (isset($_POST['pag_codigo'])) ? $_POST['pag_codigo'] : 'NOPCODE';
		$elemcode = (isset($_POST['elem_codigo'])) ? $_POST['elem_codigo'] : 'NOECODE';
		$extension = strtolower(substr($_FILES['file']['name'],-3));
		$nfile = BASE_RUTA.$pagecode.'-'.$elemcode.'.'.$extension;
		*/
		move_uploaded_file($_FILES['file']['tmp_name'], BASE_RUTA.$_FILES['file']['name']);
	}
	
?>
<html>
	<title>ImageSurfer</title>
	<head>
		<style type="text/css">
			#visor{border:solid 1px black;}
		</style>
		<script type="text/javascript" src="../../tiny_mce_popup.js?v=307"></script>
		<script type="text/javascript">
		// funcion para pasar la ruta de la imagen seleccionada al textarea
		function insertUrl(url){
			
			var ed = tinyMCEPopup.editor, dom = ed.dom;

			tinyMCEPopup.execCommand('mceInsertContent', false, dom.createHTML('img', {
				src : url,			
				border : 0
			}));

			tinyMCEPopup.close();
		}
		</script>
	</head>
<body>
<table width="95%" height="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="100%"><iframe name="visor" id="visor" width="100%" height="100%" src="imglist.php"></iframe>
</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="30">
			<form name="f" method="post" enctype="multipart/form-data" action="">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>					
					<td>Nueva imagen:</td>
					<td><input name="file" type="file" size="30"></td>										
	            <td align="right"><input type="submit" name="submit" value="Transferir"></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>	
</body> 
</html> 

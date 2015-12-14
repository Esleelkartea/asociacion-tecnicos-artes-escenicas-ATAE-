<?php
$pr1 = (isset($_POST['pr1'])) ? $_POST['pr1'] : 'kkk';
echo $pr1.'<br/>';
$urlContent = $_POST['urlContent'];
if($_FILES['fprueba']['size'] > 0) {
	echo 'Tamaño es '.$_FILES['fprueba']['size'].'<br/>';
	?>
	<script language="javascript">
	alert("Tamaño es <?php echo $_FILES['fprueba']['size']; ?>, con urlcontent <?php echo $urlContent; ?>");
	parent.subirFondo();
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

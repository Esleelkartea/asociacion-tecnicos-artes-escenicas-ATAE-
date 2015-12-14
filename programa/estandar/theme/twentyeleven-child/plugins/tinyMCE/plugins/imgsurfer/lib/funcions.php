<?php
    
	// retorna un array con los nombres de todos los
	// ficheros del directorio de imagenes
	function llegirDir(){
		$files = glob(BASE_RUTA.'*.*');
		 $ret=null;
		foreach($files as $f){
			$tmp = explode('/',$f);
			$ret[] = $tmp[count($tmp)-1];
			
		}
		//if ($ret=0)
		//{
		//$ret=null;
		//}
		return $ret;
	}
	
	// elimina un fichero
	function deleteFile($file){
		unlink(BASE_RUTA.$file);
	}
?>

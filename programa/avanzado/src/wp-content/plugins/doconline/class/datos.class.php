<?php
/****************************************************************************************************/
/* Fichero: datos.class.php
/* SGBD: mysql
/* Descripción: Clase que gestiona datos generales de la capa de datos
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor				Fecha				Acción                                                                          
/*
/* Digital5 S.L.		09/03/2012	Creación          
/*
/****************************************************************************************************/

class Datos {

	const HOST = "localhost";
	const BBDD = "ataedb";
	const USER = "ataeAdmin";
	const PASS = "adminAtae";
	
	/* FUNCIONES GENÉRICAS */
	
	// lanza una sentencia sql en caso de que no se pueda usar wpdb...
	public static function lanzar($sql,$tipo='select',$var=NULL) {
		$con = mysql_connect(Datos::HOST,Datos::USER,Datos::PASS);
		if(!$con) return false;
		mysql_select_db(Datos::BBDD,$con);
		$qry = mysql_query($sql,$con);
		if(!$qry) return false;
		switch($tipo) {
			case 'select':
				$res = array();
				while($row = mysql_fetch_array($qry)) $res[] = $row;
				break;
			case 'var' :
				if($var == NULL) return NULL;
				$row = mysql_fetch_array($qry);
				$res = $row[$var];
				break;
			default:
				$res = $qry;
				break;
		}
		//mysql_close($con);//IMPORTANTE: Lo elimino porque da un error de Wordpress - ALBERTO - 18/11/2011
		return $res;
	}
	
	// Obtiene los totales de una tabla
	public static function getTotalesTabla($parametros) {
		if($parametros['tabla'] == NULL) return false;
		if($parametros['modal'] != 'S') global $wpdb;
		$tabla = $parametros['tabla'];
		$restriccion = $parametros['restriccion'];
		$filtro = $parametros['filtro'];
		$fk = $parametros['fk'];
		$key = $parametros['key'];
		$fKey = $parametros['fKey'];
		$referencia = $parametros['referencia'];
		$valor = $parametros['valor'];
		$sql = "select count(0) as num FROM ".$tabla." where ";
		if($restriccion != NULL) $sql .= $restriccion." != '".$valor."'";
		else if($filtro != NULL) $sql .= $filtro." like ('".$valor."')";
		else if($fk != NULL) $sql .= $fk." = ".$valor;
		else if($key != NULL) $sql .= "meta_key='".$key."' and ".$fKey." = ".$valor;
		else if($referencia != NULL) $sql .= $referencia." = '".$valor."'";
		else $sql = "select count(0) as num FROM ".$tabla;
		$res = ($parametros['modal'] != 'S') ? $wpdb->get_var($sql) : Datos::lanzar($sql,'var','num');
		return $res;
	}
	
	// Obtiene los valores de una tabla
	public static function getValoresTabla($parametros) {
		if($parametros['tabla'] == NULL) return false;
		if($parametros['modal'] != 'S') global $wpdb;
		$tabla = $parametros['tabla'];
		$restriccion = $parametros['restriccion'];
		$filtro = $parametros['filtro'];
		$fk = $parametros['fk'];
		$key = $parametros['key'];
		$fKey = $parametros['fKey'];
		$referencia = $parametros['referencia'];
		$valor = $parametros['valor'];
		$sql = "select * FROM ".$tabla." where ";
		if($restriccion != NULL) $sql .= $restriccion." != '".$valor."'";
		else if($filtro != NULL) $sql .= $filtro." like ('".$valor."')";
		else if($fk != NULL) $sql .= $fk." = ".$valor;
		else if($key != NULL) $sql .= "meta_key='".$key."' and ".$fKey." = ".$valor;
		else if($referencia != NULL) $sql .= $referencia." = '".$valor."'";
		else $sql = "select * FROM ".$tabla;
		// orden
		if($parametros['order_by']) $sql .= ' order by '.$parametros['order_by'];
		// paginación
		if($parametros['count'] != NULL) {
			$offset = ($parametros['pagina'] - 1) * $parametros['count'];
			$sql .= ' limit '.$parametros['count'].' offset '.$offset;
		}
		$res = ($parametros['modal'] != 'S') ? $wpdb->get_results($sql,ARRAY_A) : Datos::lanzar($sql,'select');
		return $res;
	}
	
	// Obtiene el valor de un campo
	public static function getCampo($parametros) {
		if($parametros['tabla'] == NULL) return false;
		if($parametros['campo'] == NULL) return false;
		
		if($parametros['modal'] != 'S') global $wpdb;
		$tabla = $parametros['tabla'];
		$campo = $parametros['campo'];
		$restriccion = $parametros['restriccion'];
		$filtro = $parametros['filtro'];
		$fk = $parametros['fk'];
		$key = $parametros['key'];
		$fKey = $parametros['fKey'];
		$referencia = $parametros['referencia'];
		$valor = $parametros['valor'];
		$sql = "select ".$campo." FROM ".$tabla;
		if($restriccion != NULL) $sql .= " where $restriccion != '".$valor."'";
		else if($filtro != NULL) $sql .= " where $filtro LIKE ('".$valor."')";
		else if($fk != NULL) $sql .= " where $fk = ".$valor;
		else if($key != NULL) $sql .= "  where meta_key='".$key."' and ".$fKey." = ".$valor;
		else if($referencia != NULL) $sql .= " where $referencia = '".$valor."'";
		else return false;
		//echo 'SQL: '.$sql.'<br/>';
		$res = ($parametros['modal'] != 'S') ? $wpdb->get_var($sql) : Datos::lanzar($sql,'var',$campo);
	}
	
	/* FUNCIONES PARA EL THEME */
	
	// Obtiene los documentos de un usuario...
	public static function getDocumentos($filtros,$count=NULL,$pagina=NULL) {
		global $wpdb;
		$sql = "select * from dop_documentos";
		if($filtros != NULL) $sql .= " ".$filtros;
		// paginación
		if($count != NULL && strlen(trim($count)) > 0) {
			$offset = ($pagina - 1) * $count;
			$sql .= ' limit '.$count.' offset '.$offset;
		}
		//echo 'sql: '.$sql.'<br/>';
		$res = $wpdb->get_results($sql,ARRAY_A);
		return $res;
	}
	
	// Obtiene los datos completos de un documento
	public static function getDocumentoData($idDocumento) {
		if($idDocumento == NULL) return false;
		$sql = "select * from dop_documentos where id_documento = ".$idDocumento;
		//echo 'SQL1: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'select');
		if($r === false || !is_array($r)) return false;
		$res = $r[0];
		/*
		$sql = "select * from dop_meta_documentos where id_documento = ".$idDocumento;
		//echo 'SQL2: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'select');
		if($r === false) return false;
		if(is_array($r)) {
			$res['meta'] = array();
			foreach($r as $registro) $res['meta'][$registro['meta_key']] = $registro['meta_value'];
		}
		*/
		return $res;
	}
	
	// Obtiene el TOTAL para paginación de documentos de un usuario...
	public static function getTotalDocumentos($idUser=NULL) {
		global $wpdb;
		$sql = "select count(0) as num from dop_documentos";
		if($idUser != NULL) $sql .= " where id_usuario=".$idUser;
		$res = $wpdb->get_var($sql);
		return $res;
	}
	
	// Modifica un documento
	public static function updDocumento($parametros) {
		if($parametros['idDocumento'] == NULL) return false;
		if($parametros['nombre'] == NULL) return false;
		if($parametros['version'] == NULL) return false;
		if($parametros['alto'] == NULL) return false;
		if($parametros['ancho'] == NULL) return false;
		$ahora = date("Y-m-d H:i:s");
		// Obtenemos alto y ancho antiguos:
		//$sql = "select alto, ancho from  dop_documentos where id_documento=".$parametros['idDocumento'];
		//$r = Datos::lanzar($sql,'select');
		//if($r === false) return false;
		//$patron = '<style>.pagina {position:relative;height:'.$r[0]['alto'].'mm;width:'.$r[0]['ancho'].'mm;}</style>';
		$nuevo = '<style>.pagina {position:relative;height:'.$parametros['alto'].'mm;width:'.$parametros['ancho'].'mm;}</style>';
		//$sql = "update dop_paginas set contenido = replace(contenido,'".$patron."','".$nuevo."') where id_documento=".$parametros['idDocumento'];
		//$r = Datos::lanzar($sql,'update');
		//if($r === false) return false;
		$sql = "update dop_documentos set ";
		$sql .= "nombre='".$parametros['nombre']."'";
		$sql .= ", version='".$parametros['version']."'";
		$sql .= ", alto=".$parametros['alto'];
		$sql .= ", ancho=".$parametros['ancho'];
		$sql .= ", contenido='".$nuevo."'";
		$sql .= ($parametros['referencia'] == NULL) ? ", referencia = NULL" : ", referencia='".$parametros['referencia']."'";
		$sql .= ($parametros['descripcion'] == NULL) ? ", descripcion = NULL" : ", descripcion='".$parametros['descripcion']."'";
		$sql .= ($parametros['numerada'] == NULL) ? ", numerada = 'N'" : ", numerada='".$parametros['numerada']."'";
		// Si deseo modificar más campos los pondría aquí...
		$sql .= ", fec_mod='".$ahora."'";
		$sql .= " where id_documento=".$parametros['idDocumento'];
		//echo 'SQL: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'update');
		return $r;
	}
	
	// Modifica el estado de un documento
	public static function updEstadoDocumento($parametros) {
		if($parametros['idDocumento'] == NULL) return false;
		if($parametros['estado'] == NULL) return false;
		$ahora = date("Y-m-d H:i:s");
		$sql = "update dop_documentos set ";
		$sql .= "estado='".$parametros['estado']."'";
		$sql .= ", fec_mod='".$ahora."'";
		$sql .= " where id_documento=".$parametros['idDocumento'];
		//echo 'SQL: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'update');
		return $r;
	}
	
	// Da de alta una página
	public static function creaPagina($idDocumento,$tipo='pagina') {
		if($idDocumento == NULL) return false;
		$sql = "select count(0) as num from dop_paginas where tipo='".$tipo."' and id_documento=".$idDocumento;
		$num = Datos::lanzar($sql,'var','num');
		if($num === false) return false;
		// comprobamos si existe plantilla, portada o contraportada
		if($tipo != 'pagina' && $num >= 1) return 0;
		$ahora = date('Y-m-d H:i:s');
		// Hallamos el código y el nombre y las medidas
		$num++;
		$nombre = ($tipo != 'pagina') ? $tipo : 'pagina '.$num;
		switch($tipo) {
			case 'plantilla':
				$codigo = 'L';
				break;
			case 'portada':
				$codigo = 'I';
				break;
			case 'pagina':
				$codigo = 'P';
				break;
			case 'contraportada':
				$codigo = 'F';
				break;
			default:
				$codigo = 'O';
				break;
		}
		$codigo .= str_pad($idDocumento,8,'0',STRPAD_LEFT).str_pad($num,4,'0',STRPAD_LEFT);
		$sql = "select alto,ancho from dop_documentos where id_documento=".$idDocumento;
		$r = Datos::lanzar($sql,'select');
		if($r === false) return false;
		$medidas = $r[0];
		//insert
		$sql = "insert into dop_paginas (";
		$sql .= "id_documento";
		$sql .= ", codigo";
		$sql .= ", referencia";
		$sql .= ", tipo";
		if($tipo == 'pagina') $sql .= ", numero";
		$sql .= ", contenido";
		$sql .= ", fec_alta";
		$sql .= ") values (";
		$sql .= $idDocumento;
		$sql .= ",'".$codigo."'";
		$sql .= ",'".$nombre."'";
		$sql .= ",'".$tipo."'";
		if($tipo == 'pagina') $sql .= ",".$num;
		$contenidoPag = '<style>'."\n";
		$contenidoPag .= '.pagina {position:relative;height:'.$medidas['alto'].'mm;width:'.$medidas['ancho'].'mm;} '."\n";
		$contenidoPag .= 'p {margin: 0; padding: 0;}'."\n";
		$contenidoPag .= 'div {overflow: hidden;}</style>'."\n";
		$contenidoPag .= '</style>';
		$contenidoPag .= '<div id="pagina-'.$idDocumento.'-'.$tipo.'-'.$num.'" class="pagina"><div></div></div>';
		$sql .= ",'".$contenidoPag."'";
		$sql .= ",'".$ahora."'";
		$sql .= ")";
		$r = Datos::lanzar($sql,'insert');
		if($r === false) return false;
		// Hallamos su id
		$sql = "select id_pagina from dop_paginas where id_documento=".$idDocumento." and codigo='".$codigo."'";
		$r = Datos::lanzar($sql,'var','id_pagina');
		return $r;
	}
	
	// Obtiene las páginas de un documento
	public static function getPaginas($idDocumento) {
		if($idDocumento == NULL) return false;
		$sql = "select * from dop_paginas where id_documento=".$idDocumento;
		$r = Datos::lanzar($sql,'select');
		return $r;
	}
	
	// Obtioene los datos de una página
	public static function getPaginaData($idPagina) {
		if($idPagina == NULL) return false;
		$sql = "select * from dop_paginas where id_pagina = ".$idPagina;
		//echo 'SQL1: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'select');
		if($r === false || !is_array($r)) return false;
		$res = $r[0];
		return $res;
	}
	
	// Modifica una página
	public static function updPagina($parametros) {
		if($parametros['idPagina'] == NULL) return false;
		$ahora = date("Y-m-d H:i:s");
		$sql = "update dop_paginas set ";
		$sql .= ($parametros['referencia'] == NULL) ? "referencia = NULL" : "referencia='".$parametros['referencia']."'";
		if($parametros['contenido'] != NULL) $sql .= ", contenido='".str_replace("'",'[["]]',$parametros['contenido'])."'";
		// Si deseo modificar más campos los pondría aquí...
		$sql .= ", fec_mod='".$ahora."'";
		$sql .= " where id_pagina=".$parametros['idPagina'];
		//echo 'SQL: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'update');
		return $r;
	}
	
	// Borra una página
	public static function delPagina($idPagina) {
		if($idPagina == NULL) return false;
		$sql = "delete from dop_paginas where id_pagina=".$idPagina;
		//echo 'SQL: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'delete');
		return $r;
	}
	
	// Crea un elemento
	public static function creaElemento($parametros) {
		if($parametros['idElemento'] == NULL) return false;
		if($parametros['idPagina'] == NULL) return false;
		if($parametros['tipo'] == NULL) return false;
		if($parametros['codigo'] == NULL) return false;
		if($parametros['alto'] == NULL) return false;
		if($parametros['ancho'] == NULL) return false;
		$ahora = date("Y-m-d H:i:s");
		$sql = "insert into dop_elementos (";
		$sql .= "id_elemento";
		$sql .= ",id_pagina";
		$sql .= ",codigo";
		$sql .= ",tipo";
		if($parametros['referencia'] != NULL) $sql .= ",referencia";
		$sql .= ",alto";
		$sql .= ",ancho";
		if($parametros['dtop'] != NULL) $sql .= ",dtop";
		if($parametros['dleft'] != NULL) $sql .= ",dleft";
		if($parametros['zindex'] != NULL) $sql .= ",zindex";
		if($parametros['mtop'] != NULL) $sql .= ",mtop";
		if($parametros['mright'] != NULL) $sql .= ",mright";
		if($parametros['mbottom'] != NULL) $sql .= ",mbottom";
		if($parametros['mleft'] != NULL) $sql .= ",mleft";
		if($parametros['ptop'] != NULL) $sql .= ",ptop";
		if($parametros['pright'] != NULL) $sql .= ",pright";
		if($parametros['pbottom'] != NULL) $sql .= ",pbottom";
		if($parametros['pleft'] != NULL) $sql .= ",pleft";
		if($parametros['cfondo'] != NULL) $sql .= ",cfondo";
		if($parametros['borde'] != NULL) $sql .= ",borde";
		if($parametros['cborde'] != NULL) $sql .= ",cborde";
		$sql .= ",fec_alta";
		$sql .= ") values (";
		$sql .= $parametros['idElemento'];
		$sql .= ",".$parametros['idPagina'];
		$sql .= ",'".$parametros['codigo']."'";
		$sql .= ",'".$parametros['tipo']."'";
		if($parametros['referencia'] != NULL) $sql .= ",'".$parametros['referencia']."'";
		$sql .= ",".$parametros['alto'];
		$sql .= ",".$parametros['ancho'];
		if($parametros['dtop'] != NULL) $sql .= ",".$parametros['dtop'];
		if($parametros['dleft'] != NULL) $sql .= ",".$parametros['dleft'];
		if($parametros['zindex'] != NULL) $sql .= ",".$parametros['zindex'];
		if($parametros['mtop'] != NULL) $sql .= ",".$parametros['mtop'];
		if($parametros['mright'] != NULL) $sql .= ",".$parametros['mright'];
		if($parametros['mbottom'] != NULL) $sql .= ",".$parametros['mbottom'];
		if($parametros['mleft'] != NULL) $sql .= ",".$parametros['mleft'];
		if($parametros['ptop'] != NULL) $sql .= ",".$parametros['ptop'];
		if($parametros['pright'] != NULL) $sql .= ",".$parametros['pright'];
		if($parametros['pbottom'] != NULL) $sql .= ",".$parametros['pbottom'];
		if($parametros['pleft'] != NULL) $sql .= ",".$parametros['pleft'];
		if($parametros['cfondo'] != NULL) $sql .= ",'".$parametros['cfondo']."'";
		if($parametros['borde'] != NULL) $sql .= ",".$parametros['borde'];
		if($parametros['cborde'] != NULL) $sql .= ",'".$parametros['cborde']."'";
		$sql .= ",'".$ahora."'";
		$sql .= ")";
		//echo 'SQL1: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'insert');
		if($r === false) return false;
		// Hallamos su id
		$sql = "select id_elemento from dop_elementos where id_pagina=".$parametros['idPagina']." and codigo='".$parametros['codigo']."'";
		//echo 'SQL2: '.$sql.'<br/>';
		$r = Datos::lanzar($sql,'var','id_elemento');
		return $r;
	}
	
	// Obtiene lso tipos de documentos así como sus medidas...
	public static function getTipoDocumentos() {
		return array (
			'A4' => array (
				'nombre' => 'DIN A4',
				'alto' => 297,
				'ancho' => 210,
			),
			'A3' => array (
				'nombre' => 'DIN A3',
				'alto' => 594,
				'ancho' => 420,
			),
			'CARPETA A' => array (
				'nombre' => 'Carpeta modelo A',
				'alto' => 310,
				'ancho' => 220,
			),
			'FOLLETO A' => array (
				'nombre' => 'Folleto modelo A',
				'alto' => 210,
				'ancho' => 99,
			),
			'SOBRE A' => array (
				'nombre' => 'Sobre modelo A',
				'alto' => 260,
				'ancho' => 182,
			),
			'personalizado' => array (
				'nombre' => 'Formato personalizado',
				'alto' => 100,
				'ancho' => 100,
			),
		);
	}
	
	// Da de alta un documento
	public static function altaDocumento($parametros) {
		if($parametros['idUsuario'] == NULL) return false;
		if($parametros['tipo'] == NULL) return false;
		if($parametros['nombre'] == NULL) return false;
		if($parametros['alto'] == NULL) return false;
		if($parametros['ancho'] == NULL) return false;
		if($parametros['version'] == NULL) $parametros['version'] = '1.0';
		global $wpdb;
		$ahora = date('Y-m-d H:i:s');
		// hallamos el código automático
		$ymd = date('Ymd');
		$hoy = date('Y-m-d');
		$sql = "select count(0) as num from dop_documentos where id_usuario=".$parametros['idUsuario']." and fec_alta >= '".$hoy." 00:00:00' and fec_alta <= '".$hoy." 23:59:59'";
		$cuantos = $wpdb->get_var($sql);
		if($cuantos === false) return false;
		$cuantos++;
		$codigo = 'D'.$ymd.str_pad($parametros['idUsuario'],4,'0',STRPAD_LEFT).str_pad($cuantos,4,'0',STRPAD_LEFT);
		// hallamos el contenido
		$contenido = '<style>';
		$contenido .= '.pagina {position:relative;height:'.$parametros['alto'].'mm;width:'.$parametros['ancho'].'mm;}';
		$contenido .= 'p {margin:0; padding:0;}</style>';
		$contenido .= '</style>';
		// insert
		$sql = "insert into dop_documentos (";
		$sql .= "id_usuario";
		$sql .= ",codigo";
		$sql .= ",version";
		$sql .= ",referencia";
		$sql .= ",tipo";
		$sql .= ",nombre";
		$sql .= ",descripcion";
		$sql .= ",numerada";
		$sql .= ",alto";
		$sql .= ",ancho";
		$sql .= ",contenido";
		$sql .= ",fec_alta";
		$sql .= ") values (";
		$sql .= $parametros['idUsuario'];
		$sql .= ",'".$codigo."'";
		$sql .= ",'".$parametros['version']."'";
		$sql .= ",'".$parametros['referencia']."'";
		$sql .= ",'".$parametros['tipo']."'";
		$sql .= ",'".$parametros['nombre']."'";
		$sql .= ",'".$parametros['descripcion']."'";
		$sql .= ",'".$parametros['numerada']."'";
		$sql .= ",".$parametros['alto'];
		$sql .= ",".$parametros['ancho'];
		$sql .= ",'".$contenido."'";
		$sql .= ",'".$ahora."'";
		$sql .= ")";
		$r = $wpdb->query($sql);
		//echo 'idReferencia es '.$idReferencia.'<br/>';
		if($parametros['idReferencia'] == NULL) return $r;
		if($r === false) return false;
		$sql = "select id_documento from dop_documentos where codigo='".$codigo."'";
		$idDoc = $wpdb->get_var($sql);
		//echo 'idDoc es '.$idDoc.'<br/>';
		if($r === false) return false;
		$sql = "select * from dop_paginas where id_documento=".$parametros['idReferencia'];
		//echo 'sql paginas: '.$sql.'<br/>';
		$paginas = $wpdb->get_results($sql,ARRAY_A);
		if($paginas === false) return false;
		if(is_array($paginas)) {
			$codPag = NULL;
			foreach($paginas as $pagina) {
				$sql = "select count(0) as num from dop_paginas where tipo='".$pagina['tipo']."' and id_documento=".$idDoc;
				$num = Datos::lanzar($sql,'var','num');
				if($num === false) return false;
				// Hallamos el código y el nombre y las medidas
				$num++;
				$nombre = ($pagina['tipo'] != 'pagina') ? $pagina['tipo'] : 'pagina '.$num;
				switch($pagina['tipo']) {
					case 'portada':
						$codPag = 'I';
						break;
					case 'pagina':
						$codPag = 'P';
						break;
					case 'contraportada':
						$codPag = 'F';
						break;
					default:
						$codPag = 'O';
						break;
				}
				$codPag .= str_pad($idDoc,8,'0',STRPAD_LEFT).str_pad($num,4,'0',STRPAD_LEFT);
				//insert
				$sql = "insert into dop_paginas (";
				$sql .= "id_documento";
				$sql .= ", codigo";
				$sql .= ", referencia";
				$sql .= ", tipo";
				if($pagina['tipo'] == 'pagina') $sql .= ", numero";
				$sql .= ", contenido";
				$sql .= ", fec_alta";
				$sql .= ") values (";
				$sql .= $idDoc;
				$sql .= ",'".$codPag."'";
				$sql .= ",'".$pagina['referencia']."'";
				$sql .= ",'".$pagina['tipo']."'";
				if($pagina['tipo'] == 'pagina') $sql .= ",".$num;
				$contenido = (trim($pagina['contenido']) != NULL) ? trim($pagina['contenido']) : NULL;
				if($contenido != NULL) $contenido = str_replace('pagina-'.$parametros['idReferencia'].'-','pagina-'.$idDoc.'-',$contenido);
				$sql .= ",'".$contenido."'";
				$sql .= ",'".$ahora."'";
				$sql .= ")";
				//echo 'sql insert: '.$sql.'<br/>';
				$r = Datos::lanzar($sql,'insert');
				if($r === false) return false;
			}
		}
		
		return $r;
	}
	
	// Obtiene el nombre de un usuario
	public static function getUserName($user) {
		if($user == NULL) return false;
		$user_info = get_userdata($user);
		return $user_info->display_name;
	}
	
	// registra una descarga o vista
	public static function registraDescarga($idDocumento,$campo='descargas') {
		if($parametros['idDocumento'] == NULL) return false;
		$sql = "update dop_documentos set ".$campo." = coalesce(".$campo.",0) + 1 where id_documento=" + $idDocumento;
		$r = Datos::lanzar($sql,'update');
		return $r;
	}
	
	// Elimina un documento
	public static function delDocumento($idDocumento) {
		if($idDocumento == NULL) return false;
		$sql = "delete from dop_paginas where id_documento=".$idDocumento;
		$r = Datos::lanzar($sql,'delete');
		if($r === false) return false;
		$sql = "delete from dop_documentos where id_documento=".$idDocumento;
		return Datos::lanzar($sql,'delete');
		
	}

}
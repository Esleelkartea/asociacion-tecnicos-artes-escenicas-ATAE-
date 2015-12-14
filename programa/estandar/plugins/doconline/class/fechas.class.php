<?php
/****************************************************************************************************/
/* Pantalla: fechas.usuario.php
/* Descripción: Clase que lleva la gestión de las fechas
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor				Fecha				Acción                                                                          
/*
/* Digital5 S.L.		07/06/2011	Creación          
/*
/****************************************************************************************************/

class Fechas {

private $dias = array();

// Constructor:
function __construct() {
	$this->dias[1] = 31;
	$this->dias[2] = 28;
	$this->dias[3] = 31;
	$this->dias[4] = 30;
	$this->dias[5] = 31;
	$this->dias[6] = 30;
	$this->dias[7] = 31;
	$this->dias[8] = 31;
	$this->dias[9] = 30;
	$this->dias[10] = 31;
	$this->dias[11] = 30;
	$this->dias[12] = 31;
}

// Código propio...
public static function formatoFechaPgSQL($parametro){
	$fecha = $parametro;
	$hora = NULL;
	if(strlen($parametro) > 10) {
		$valores = explode(" ",$parametro);
		$fecha = $valores[0];
		$hora = $valores[1];
	}
	if(preg_match("/\//i",$fecha)) {
		list($dd,$mm,$yyyy)=explode("/",$fecha);
		$fecha = $yyyy.'-'.$mm.'-'.$dd;
	}
	$res = ($hora == NULL) ? $fecha : $fecha.' '.$hora;
	return $res;
}

// Devuelve una fecha con un formato:
public static function format($p_fecha,$p_formato="date") {
  $v_res = $p_fecha;
  $v_y = substr($p_fecha,0,4);
  $v_y2 = substr($p_fecha,2,2);
  $v_m = substr($p_fecha,5,2);
  $v_d = substr($p_fecha,8,2);
  if(strlen($p_fecha) > 10) {
    $v_hor = substr($p_fecha,11,2);
    $v_min = substr($p_fecha,14,2);
    $v_seg = substr($p_fecha,17,2);
  } else {
    $v_hor = "00";
    $v_min = "00";
    $v_seg = "00";
  }
  if($p_formato == "date") {
    $v_res = $v_d."/".$v_m."/".$v_y;
  } else if($p_formato == "timestamp") {
    $v_res = $v_d."/".$v_m."/".$v_y." ".$v_hor.":".$v_min.":".$v_seg;
  } else if($p_formato == "time") {
    $v_res = $v_hor.":".$v_min.":".$v_seg;
  } else if($p_formato == "hora") {
    $v_res = $v_hor.":".$v_min;
  } else if($p_formato == "y") {
    $v_res = $v_y;
  } else if($p_formato == "y2") {
    $v_res = (String)$v_y2;
  } else if($p_formato == "m") {
    $v_res = $v_m;
  } else if($p_formato == "d") {
    $v_res = $v_d;
  } else if($p_formato == "hor") {
    $v_res = $v_hor;
  } else if($p_formato == "min") {
    $v_res = $v_min;
  } else if($p_formato == "seg") {
    $v_res = $v_seg;
  }
  return $v_res;
}

// Actualiza a una fecha en n meses:
function addMeses($p_fecha,$p_meses,$p_operacion='sumar') {
  $v_res = NULL;
  $v_y = $this->format($p_fecha,'y');
  $v_m = $this->format($p_fecha,'m');
  $v_d = $this->format($p_fecha,'d');
  $v_hor = $this->format($p_fecha,'hor');
  $v_min = $this->format($p_fecha,'min');
  $v_seg = $this->format($p_fecha,'seg');
  if($p_operacion == 'sumar') {
    $v_m += $p_meses;
    if($v_m > 12) {
      $v_m -= 12;
      $v_y++;
    }
  } else if($p_operacion == 'restar') {
    $v_m -= $p_meses;
    if($v_m < 1) {
      $v_m += 12;
      $v_y--;
    }
  }
  if($v_y%4 == 0 && ($v_y%100 != 0 || $v_y%400 == 0)) $this->dias[2] = 29;
  else $this->dias[2] = 28;
  if($v_d > $this->dias[$v_m]) $v_d = $this->dias[$v_m];
  if(strlen($v_m) == 1) $v_m = "0".$v_m;
  if(strlen($v_d) ==1) $v_d = "0".$v_d;
  if(strlen($v_hor) ==1) $v_hor = "0".$v_hor;
  if(strlen($v_min) ==1) $v_min = "0".$v_min;
  if(strlen($v_seg) ==1) $v_seg = "0".$v_seg;
  $v_res = $v_y."-".$v_m."-".$v_d." ".$v_hor.":".$v_min.":".$v_seg;
  return $v_res;
}

// Sumamos segundos a una fecha:
function addSegundos($p_fecha,$p_segundos) {
  $v_res = NULL;
  $v_y = substr($p_fecha,0,4);
  $v_m = substr($p_fecha,5,2);
  $v_d = substr($p_fecha,8,2);
  if($v_y%4 == 0 && ($v_y%100 != 0 || $v_y%400 == 0)) $this->dias[2] = 29;
  else $this->dias[2] = 28;
  if(strlen($p_fecha) > 10) {
    $v_hor = substr($p_fecha,11,2);
    $v_min = substr($p_fecha,14,2);
    $v_seg = substr($p_fecha,17,2);
  } else {
    $v_hor = 0;
    $v_min = 0;
    $v_seg = 0;
  }
  $v_resto = $p_segundos;
  $v_dias = floor($v_resto/86400);
  $v_resto = $v_resto%86400;
  $v_horas = floor($v_resto/3600);
  $v_resto = $v_resto%3600;
  $v_minutos = floor($v_resto/60);
  $v_resto = $v_resto%60;
  $v_segundos = floor($v_resto);
  $v_seg += $v_segundos;
  if($v_seg >= 60) {
    $v_seg -= 60;
    $v_min++;
  }
  $v_min += $v_minutos;
  if($v_min >= 60) {
    $v_min -= 60;
    $v_hor++;
  }
  $v_hor += $v_horas;
  if($v_hor >= 24) {
    $v_hor -= 24;
    $v_d++;
  }
  $v_d += $v_dias;
  if($v_d > $this->dias[$v_m]) {
    $v_d -= $this->dias[$v_m];
    $v_m++;
  }
  if($v_m > 12) {
    $v_m -= 12;
    $v_y++;
  }
  $v_res = $v_y."-".str_pad($v_m,2,"0",STR_PAD_LEFT)."-".str_pad($v_d,2,"0",STR_PAD_LEFT)." ".str_pad($v_hor,2,"0",STR_PAD_LEFT).":".str_pad($v_min,2,"0",STR_PAD_LEFT).":".str_pad($v_seg,2,"0",STR_PAD_LEFT);
  return $v_res;
}

// Devuelve los segundos entre dos fechas:
public static function getSegundos($fIni,$fFin) {
	$res = 0;
	$iniY = substr($fIni,0,4);
  $iniM = substr($fIni,5,2);
  $iniD = substr($fIni,8,2);
	$iniH = (strlen($fIni) > 10) ? substr($fIni,11,2) : 0;
	$iniI = (strlen($fIni) > 10) ? substr($fIni,14,2) : 0;
	$iniS = (strlen($fIni) > 10) ? substr($fIni,17,2) : 0;
  $finY = substr($fFin,0,4);
  $finM = substr($fFin,5,2);
  $finD = substr($fFin,8,2);
	$finH = (strlen($fFin) > 10) ? substr($fFin,11,2) : 23;
	$finI = (strlen($fFin) > 10) ? substr($fFin,14,2) : 59;
	$finS = (strlen($fFin) > 10) ? substr($fFin,17,2) : 59;
  $timeIni = mktime($iniH,$iniI,$iniS,$iniM,$iniD,$iniY); 
  $timeFin = mktime($finH,$finI,$finS,$finM,$finD,$finY); 
  $segundos = $timeFin - $timeIni;
	return $segundos;
}

// Devuelve el número de días entre dos fechas:
public static function getDias($fIni,$fFin) {
  $segundos = Fechas::getSegundos($fIni,$fFin);
  $res = $segundos / (60 * 60 * 24); 
  return round($res);
}

// Devuelve el número de horas ente dos fechas uan vez descontados los días
public static function getHorasSueltas($fIni, $fFin) {
	$segundos = Fechas::getSegundos($fIni,$fFin);
	$dias = Fechas::getDias($fIni,$fFin);
	$segundos = $segundos - ($dias * 24 * 60 * 60);
	$res = $segundos / (60 * 60);
	return round($res);
}

// Función para restar o sumar días a una fecha sin guiones:
public static function modDateStr($fecha,$dias=1,$operacion='sumar') {
  if($fecha == NULL || strlen($fecha) < 8) return null;
	$aDias = array (
		1 => 31,
		2 => 28,
		3 => 31,
		4 => 30,
		5 => 31,
		6 => 30,
		7 => 31,
		8 => 31,
		9 => 30,
		10 => 31,
		11 => 30,
		12 => 31,
	);
	$res = NULL;
  $y = substr($fecha,0,4);
  $m = substr($fecha,4,2);
  $d = substr($fecha,6,2);
	if($y%4 == 0 && ($y%100 != 0 || $y%400 == 0)) $aDias[2] = 29;
  if($operacion == 'sumar') {
    $d += $dias;
		if($d > $aDias[$m]) {
			$d -= $aDias[$m];
			$m++;
		}
    if($m > 12) {
      $m -= 12;
      $y++;
    }
  } else if($operacion == 'restar') {
		$d -= $dias;
		if($d < 1) {
			$d += $aDias[$m];
			$m--;
		}
    if($m < 1) {
      $m += 12;
      $y--;
    }
  }
  $res = $y.str_pad($m,2,'0',STR_PAD_LEFT).str_pad($d,2,'0',STR_PAD_LEFT);
	return $res;
}

// saca el primer o último día de un mes...
public static function extremoMes($fecha,$tipo='primero') {
	if($fecha == NULL || strlen($fecha) < 8) return null;
	$aDias = array (
		1 => 31,
		2 => 28,
		3 => 31,
		4 => 30,
		5 => 31,
		6 => 30,
		7 => 31,
		8 => 31,
		9 => 30,
		10 => 31,
		11 => 30,
		12 => 31,
	);
	$y = substr($fecha,0,4);
  $m = substr($fecha,5,2);
	if($y%4 == 0 && ($y%100 != 0 || $y%400 == 0)) $aDias[2] = 29;
	$res = $y.'-'.$m.'-';
  $res .= ($tipo == 'primero') ? '01':$aDias[$m];
	return $res;
}

}
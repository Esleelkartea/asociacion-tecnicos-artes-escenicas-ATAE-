<?php
/****************************************************************************************************/
/* Pantalla: campos.class.php
/* Descripción: Clase que lleva la gestión de los campos
/*
/* Control de versiones:
/* --------------------------------------------------------------------
/* Autor				Fecha				Acción                                                                          
/*
/* Digital5 S.L.		12/03/2012	Creación          
/*
/****************************************************************************************************/

class Campos {
// Constantes
const TAB = "\t";
const NTHEME = 'twentyeleven-child';

// Constructor:
function __construct() {
}

// muestra los campos por pantalla
public static function makeCampos($campos,$modo='new_') {
	if($campos == NULL || !is_array($campos)) return -1;
	
	global $wpdb;
	define('TAB',Campos::TAB);
	
	$res = array();
	foreach($campos as $fieldset) {
		$res[] = '<fieldset>';
		$res[] = '<legend>'.$fieldset['nombre'].'</legend>';
		if(!is_array($fieldset['campos'])) return -4;
		foreach($fieldset['campos'] as $campo => $atributos) {
			if(!($atributos['tipo'] == 'pk')) {
				$cid = $modo.$campo;
				$res[] = TAB.'<div class="bloque-campo">';
				$res[] = TAB.TAB.'<div class="campo-titulo">'.$atributos['nombre'].'</div>';
				$res[] = TAB.TAB.'<div class="campo-valor">';
				$c = NULL;
				switch($atributos['tipo']) {
					case 'hidden':
					case 'pk':
						$c = '<input type="hidden" name="'.$cid.'" id="'.$cid.'" value="'.$atributos['valor'].'" />';
						$c .= '<p>'.$atributos['valor'].'&nbsp;</p>';
						break;
					case 'integer':
					case 'float':
					case 'vchar':
					case 'autoref':
					case 'char':
						$c = '<input type="text" name="'.$cid.'" id="'.$cid.'" ';
						$clase = 'campo-'.$atributos['tipo'].' ';
						$clase .= ($atributos['notnull'] == 'S') ? 'obligatorio' : 'texto';
						$c .= 'class="'.$clase.'" ';
						$c .= ($atributos['size'] == NULL) ? 'size="3" ' : 'size="'.$atributos['size'].'" ';
						$c .= ($atributos['max'] == NULL) ? 'maxlength="3" ' : 'maxlength="'.$atributos['max'].'" ';
						if($atributos['min'] != NULL) $c .= 'min="'.$atributos['min'].'" ';
						if($atributos['valor'] != NULL) {
							$flgROnly = ($atributos['readonly'] == 'S') ? 'S' : 'N';
							if($atributos['readonly'] == 'E' && $modo == 'edit_') $flgROnly = 'S';
							$c .= 'value="'.$atributos['valor'].'" ';
							if($flgROnly == 'S') $c .= 'readonly="readonly" ';
						} else if($atributos['tipo'] == 'autoref') $c .= 'readonly="readonly" '; // Si es autoreferencial no se puede meter datos, es automático
						if($atributos['title'] != NULL) $c .= 'title="'.$atributos['title'].'" ';
						$c .= '/>';
						break;
					case 'text':
						$c = '<textarea name="'.$cid.'" id="'.$cid.'" ';
						$clase = 'campo-'.$atributos['tipo'];
						if($atributos['notnull'] == 'S') $clase .= ' obligatorio';
						$c .= 'class="'.$clase.'" ';
						$c .= ($atributos['cols'] == NULL) ? 'cols="60" ' : 'cols="'.$atributos['cols'].'" ';
						$c .= ($atributos['rows'] == NULL) ? 'rows="3" ' : 'rows="'.$atributos['rows'].'" ';
						if($atributos['min'] != NULL) $c .= 'min="'.$atributos['min'].'" ';
						if($atributos['min'] != NULL) $c .= 'max="'.$atributos['max'].'" ';
						$c .= '>';
						if($atributos['valor'] != NULL) $c .= $atributos['valor'];
						$c .= '</textarea>';
						break;
					case 'date':
					case 'datetime':
						$c = '<input type="text" name="'.$cid.'" id="'.$cid.'" ';
						$clase = 'campo-'.$atributos['tipo'].' ';
						$clase .= ($atributos['notnull'] == 'S') ? 'obligatorio' : 'texto';
						$max = ($atributos['tipo'] == 'date') ? '10' : '20';
						$mascara = ($atributos['tipo'] == 'date') ? '%d/%m/%Y' : '%d/%m/%Y %H:%M:%S';
						if($atributos['valor'] != NULL) $c .= 'value="'.$atributos['valor'].'" ';
						$c .= 'class="'.$clase.'" size="16" maxlength="'.$max.'" />';
						$c .= "\n".TAB.TAB.TAB;
						$c .= '<img style="cursor:pointer;" border="0" align="absmiddle" id="img_'.$cid.'" src="'.WP_CONTENT_URL.'/themes/'.Campos::NTHEME.'/images/iconos/calendar.gif" />';
						$c .= "\n".TAB.TAB.TAB;
						$c .= '<script type="text/javascript">';
						$c .= "\n".TAB.TAB.TAB;
						$c .= '//<![CDATA[';
						$c .= "\n".TAB.TAB.TAB;
						$c .= 'var cal = Calendar.setup({';
						$c .= "\n".TAB.TAB.TAB;
						$c .= 'onSelect: function(cal) { cal.hide() }';
						$c .= "\n".TAB.TAB.TAB;
						$c .= '});';
						$c .= "\n".TAB.TAB.TAB;
						$c .= 'cal.manageFields("img_'.$cid.'", "'.$cid.'", "'.$mascara.'");';
						$c .= "\n".TAB.TAB.TAB;
						$c .= '//]]>';
						$c .= "\n".TAB.TAB.TAB;
						$c .= '</script>';
						break;
					case 'color':
						$c = '<input type="text" name="'.$cid.'" id="'.$cid.'" ';
						$clase = 'color {hash:true} ';
						$clase .= ($atributos['notnull'] == 'S') ? 'obligatorio' : 'texto';
						$c .= 'class="'.$clase.'" size="6" maxlength="6" readonly="readonly" ';
						if($atributos['valor'] != NULL) $c .= 'value="'.$atributos['valor'].'" ';
						$c .= '/>';
						break;
					case 'select':
						$c = '<select name="'.$cid.'" id="'.$cid.'" class="campo-'.$atributos['tipo'].' elige" ';
						switch($atributos['especial']) {
							case 'chgMedidas':
								$c .= 'onchange="chgMedidas();"';
								break;
						}
						$c .= '>';
						$c .= "\n".TAB.TAB.TAB;
						if(!is_array($atributos['opciones']))	$c .= '<option value="">sin opciones&nbsp;</option>';
						else {
							foreach($atributos['opciones'] as $opcion => $valor) {
								if($modo == 'edit_' && $atributos['readonly'] == 'S') {
									if($opcion == $atributos['valor']) $c .= '<option value="'.$opcion.'" selected="selected">'.$valor.'&nbsp;</option>';
								} else {
									$selected = ($opcion == $atributos['valor']) ? 'selected="selected" ' : '';
									$c .= '<option value="'.$opcion.'" '.$selected.'>'.$valor.'&nbsp;</option>';
								}
							}
						}
						$c .= '</select>';
						break;
					default:
						$c = $atributos['contenido'];
						break;
				}
				if($c != NULL) $res[] = TAB.TAB.TAB.$c;
				$res[] = TAB.TAB.'</div>';
				$res[] = TAB.'</div>';
			}
		}
		$res[] = '</fieldset>';
	}
	return implode("\n",$res);
}

// muestra los filtros por pantalla
public static function makeFiltros($filtros) {
	if($filtros == NULL || !is_array($filtros)) return false;
	
	define('TAB',Campos::TAB);
	$res = array();

	foreach($filtros as $campo => $atributos) {
		$cid = 'filtro_'.$campo;
		$res[] = TAB.'<div class="bloque-campo">';
		$res[] = TAB.TAB.'<div class="campo-titulo">'.$atributos['nombre'].'</div>';
		$res[] = TAB.TAB.'<div class="campo-valor">';
		$c = NULL;
		switch($atributos['tipo']) {
			case 'hidden':
			case 'pk':
				$c = '<input type="hidden" name="'.$cid.'" id="'.$cid.'" value="'.$atributos['valor'].'" />';
				$c .= '<p>'.$atributos['valor'].'&nbsp;</p>';
				break;
			case 'integer':
			case 'float':
			case 'vchar':
			case 'char':
			case 'like':
			case 'fk-like-usuario':
				$c = '<input type="text" name="'.$cid.'" id="'.$cid.'" ';
				$clase = 'campo-'.$atributos['tipo'].' ';
				$clase .= ($atributos['notnull'] == 'S') ? 'obligatorio' : 'texto';
				$c .= 'class="'.$clase.'" ';
				$c .= ($atributos['size'] == NULL) ? 'size="3" ' : 'size="'.$atributos['size'].'" ';
				$c .= ($atributos['max'] == NULL) ? 'maxlength="3" ' : 'maxlength="'.$atributos['max'].'" ';
				if($atributos['min'] != NULL) $c .= 'min="'.$atributos['min'].'" ';
				if($atributos['valor'] != NULL) {
					$c .= 'value="'.$atributos['valor'].'" ';
					if($atributos['readonly'] == 'S') $c .= 'readonly="readonly" ';
				}
				$c .= '/>';
				break;
			case 'text':
				$c = '<textarea name="'.$cid.'" id="'.$cid.'" ';
				$clase = 'campo-'.$atributos['tipo'];
				$c .= 'class="'.$clase.'" ';
				$c .= ($atributos['cols'] == NULL) ? 'cols="60" ' : 'cols="'.$atributos['cols'].'" ';
				$c .= ($atributos['rows'] == NULL) ? 'rows="3" ' : 'rows="'.$atributos['rows'].'" ';
				if($atributos['min'] != NULL) $c .= 'min="'.$atributos['min'].'" ';
				if($atributos['min'] != NULL) $c .= 'max="'.$atributos['max'].'" ';
				$c .= '>';
				if($atributos['valor'] != NULL) $c .= $atributos['valor'];
				$c .= '</textarea>';
				break;
			case 'date':
			case 'datetime':
			case 'date-mayor-igual':
			case 'date-menor-igual':
				$c = '<input type="text" name="'.$cid.'" id="'.$cid.'" ';
				$clase = 'campo-'.$atributos['tipo'].' ';
				$max = (in_array($atributos['tipo'],array('date','date-mayor-igual','date-menor-igual'))) ? '10' : '20';
				$mascara = (in_array($atributos['tipo'],array('date','date-mayor-igual','date-menor-igual'))) ? '%d/%m/%Y' : '%d/%m/%Y %H:%M:%S';
				if($atributos['valor'] != NULL) $c .= 'value="'.$atributos['valor'].'" ';
				$c .= 'class="'.$clase.'" size="16" maxlength="'.$max.'" />';
				$c .= "\n".TAB.TAB.TAB;
				$c .= '<img style="cursor:pointer;" border="0" align="absmiddle" id="img_'.$cid.'" src="'.WP_CONTENT_URL.'/themes/'.Campos::NTHEME.'/images/iconos/calendar.gif" />';
				$c .= "\n".TAB.TAB.TAB;
				$c .= '<script type="text/javascript">';
				$c .= "\n".TAB.TAB.TAB;
				$c .= '//<![CDATA[';
				$c .= "\n".TAB.TAB.TAB;
				$c .= 'var cal = Calendar.setup({';
				$c .= "\n".TAB.TAB.TAB;
				$c .= 'onSelect: function(cal) { cal.hide() }';
				$c .= "\n".TAB.TAB.TAB;
				$c .= '});';
				$c .= "\n".TAB.TAB.TAB;
				$c .= 'cal.manageFields("img_'.$cid.'", "'.$cid.'", "'.$mascara.'");';
				$c .= "\n".TAB.TAB.TAB;
				$c .= '//]]>';
				$c .= "\n".TAB.TAB.TAB;
				$c .= '</script>';
				break;
			case 'select':
			case 'orderBy':
			case 'ascDesc':
				$c = '';
				if($atributos['tipo'] == 'orderBy') $c .= '<input type="hidden" name="orderByListado" id="orderByListado" value="" />';
				$c .= '<select name="'.$cid.'" id="'.$cid.'" class="campo-'.$atributos['tipo'].' elige" >';
				$c .= "\n".TAB.TAB.TAB;
				if(!is_array($atributos['opciones']))	$c .= '<option value="">sin filtro&nbsp;</option>';
				else {
					foreach($atributos['opciones'] as $opcion => $valor) {
						$selected = ($opcion == $atributos['valor']) ? 'selected="selected" ' : '';
						$c .= '<option value="'.$opcion.'" '.$selected.'>'.$valor.'&nbsp;</option>';
					}
				}
				$c .= '</select>';
				break;
			default:
				$c = $atributos['contenido'];
				break;
		}
		if($c != NULL) $res[] = TAB.TAB.TAB.$c;
		$res[] = TAB.TAB.'</div>';
		$res[] = TAB.'</div>';
	}

	return implode("\n",$res);
}

// genera una where para los filtros
public static function makeWhere($filtros) {
	if($filtros == NULL || !is_array($filtros)) return false;
	include_once(WP_PLUGIN_DIR.'/doconline/class/fechas.class.php');
	global $wpdb;
	
	$res = NULL;

	foreach($filtros as $campo => $atributos) {
		if($atributos['valor'] != NULL) {
			$txt = ($res == NULL) ? ' where ' : ' and ';
			switch($atributos['tipo']) {
				case 'like':
					$res .= $txt.$campo." like '%".$atributos['valor']."%'";
					break;
				case 'menor':
					$res .= $txt.$campo." < ";
					if($atributos['comillas'] == 'S') $res .= "'";
					$res .= $atributos['valor'];
					if($atributos['comillas'] == 'S') $res .= "'";
					break;
				case 'menor-igual':
				case 'date-menor-igual':
					$patron = '/\_hasta/';
					if(preg_match($patron,$campo)) $campo = preg_replace($patron,'',$campo);
					if($atributos['tipo'] == 'date-menor-igual') $atributos['valor'] = Fechas::formatoFechaPgSQL($atributos['valor'])." 23:59:59";
					$res .= $txt.$campo." <= ";
					if($atributos['comillas'] == 'S') $res .= "'";
					$res .= $atributos['valor'];
					if($atributos['comillas'] == 'S') $res .= "'";
					break;
				case 'mayor':
					$res .= $txt.$campo." > ";
					if($atributos['comillas'] == 'S') $res .= "'";
					$res .= $atributos['valor'];
					if($atributos['comillas'] == 'S') $res .= "'";
					break;
				case 'mayor-igual':
				case 'date-mayor-igual':
					$patron = '/\_desde/';
					if(preg_match($patron,$campo)) $campo = preg_replace($patron,'',$campo);
					if($atributos['tipo'] == 'date-mayor-igual') $atributos['valor'] = Fechas::formatoFechaPgSQL($atributos['valor'])." 00:00:00";
					$res .= $txt.$campo." >= ";
					if($atributos['comillas'] == 'S') $res .= "'";
					$res .= $atributos['valor'];
					if($atributos['comillas'] == 'S') $res .= "'";
					break;
				case 'diferente':
					$res .= $txt.$campo." < ";
					if($atributos['comillas'] == 'S') $res .= "'";
					$res .= $atributos['valor'];
					if($atributos['comillas'] == 'S') $res .= "'";
					break;
				case 'meta-si':
					$res .= $txt.$atributos['pk']." in (";
					$res .= "select ".$atributos['fk']." from ".$atributos['tabla']." where meta_key='".$campo."' and meta_value='".$atributos['valor']."'";
					$res .= ")";
					break;
				case 'meta-no':
					$res .= $txt.$atributos['pk']." not in (";
					$res .= "select ".$atributos['fk']." from ".$atributos['tabla']." where meta_key='".$campo."' and meta_value='".$atributos['valor']."'";
					$res .= ")";
					break;
				case 'fk-like-usuario':
					$res .= $txt." id_usuario in (select ID from ".$wpdb->prefix."users where display_name like '%".$atributos['valor']."%' and meta_value like '%".$atributos['valor']."%')";
					break;
				case 'orderBy':
				case 'ascDesc':
					// no se tienen en cuenta...
					break;
				default:
					$res .= $txt.$campo." = ";
					if($atributos['comillas'] == 'S') $res .= "'";
					$res .= $atributos['valor'];
					if($atributos['comillas'] == 'S') $res .= "'";
					break;
				
			}
		}
	}
	return $res;
}


}
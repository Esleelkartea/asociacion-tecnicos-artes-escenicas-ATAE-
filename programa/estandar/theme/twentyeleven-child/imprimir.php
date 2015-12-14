<?php
$html = (isset($_POST['contenidoDoc'])) ? $_POST['contenidoDoc'] : NULL;
$html = str_replace('\\"','"',$html);
// PRUEBAS
$html = '<style>';
$html .= '.pagina {position:relative;height:296mm;width:210mm;}';
$html .= 'p {margin:0;padding:0;}';
$html .= '</style>';
$html .= '<div id="pagina-1-plantilla-1" class="pagina"></div>';
$html .= '<div id="elemento-libre-1" class="elemento-pagina elemento-libre elemento-draggable ui-draggable" style="background-color: rgb(255, 0, 0); height: 50mm; width: 50mm; position: absolute; border-top: 2px solid #999999; top: 22mm; left: 14mm; "><p>VIVA MEJICO</p></div>';
$html .= '<div id="elemento-libre-2" class="elemento-pagina elemento-libre elemento-draggable ui-draggable" style="background-color: rgb(179, 250, 255); height: 70mm; width: 50mm; position: absolute; border-top-width: 0.5mm; border-top-style: solid; border-top-color: rgb(252, 5, 5); border-right-width: 0.5mm; border-right-style: solid; border-right-color: rgb(252, 5, 5); border-bottom-width: 0.5mm; border-bottom-style: solid; border-bottom-color: rgb(252, 5, 5); border-left-width: 0.5mm; border-left-style: solid; border-left-color: rgb(252, 5, 5); top: 48mm; left: 39mm; "><p>VIVA MEJICO</p></div>';

echo $html;
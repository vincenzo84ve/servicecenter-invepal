<?php
require_once("xajax_core/xajaxAIO.inc.php");

$xajax = new xajax("personal_mdl.php");

$xajax->register(XAJAX_FUNCTION,"guardar");
$xajax->register(XAJAX_FUNCTION, "limpiar");
$xajax->register(XAJAX_FUNCTION, "buscar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "init_personal");
?>
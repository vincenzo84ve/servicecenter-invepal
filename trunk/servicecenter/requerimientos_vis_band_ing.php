<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*seccion includes*/
require("requerimientos_ctrl.php");

//Limito la busqueda
$TAMANO_PAGINA = 10;

$id = $_GET["id"];

$pagina = $_GET["pagina"];

//examino la página a mostrar y el inicio del registro a mostrar
if (!$pagina) {
    $inicio = 0;
    $pagina=1;
}
else {
    $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter - Servicios</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_initBandejaIngeniero(<?php echo $pagina;?>,<?php echo $inicio;?>,<?php echo $id; ?>);">
        <div id="datosPaginacion"></div>
        <div align="right">Filtrar: <select name="cmbEstado" id="cmbEstado" onchange="xajax_filtrarBandIng(<?php echo $pagina;?>,<?php echo $inicio;?>,document.getElementById('cmbEstado').value, <?php echo $id; ?>);">
                <option value="todos">Requerimientos...</option>
                <option value="asignado">Requerimientos Asignados</option>
                <option value="en proceso">Requerimientos En Proceso</option>
            </select>
        </div>
        <div align="right">Buscar: <input type="text" name="txtIduscar" id="txtIdBuscar" /><input type="button" value="..." name="btnBuscar" id="btnBuscar" onclick="xajax_buscarID(document.getElementById('txtIdBuscar').value);"/></div>
        <div id="listadoRequerimientos">
            <table class="tabla">
                <tr>
                    <td><b>&nbsp;ID&nbsp;</b></td>
                    <td><b>&nbsp;Fecha&nbsp;</b></td>
                    <td><b>&nbsp;Servicio&nbsp;</b></td>
                    <td><b>&nbsp;Personal&nbsp;</b></td>
                    <td><b>&nbsp;Area&nbsp;</b></td>
                    <td><b>&nbsp;Coordinaci&oacute;n&nbsp;</b></td>
                    <td><b>&nbsp;Estado&nbsp;</b></td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div id="paginacion"></div>
                </td>
            </tr>
        </table>
    </body>
</html>
<!--
Vista para controlar los niveles que se pueden crear dentro de la bd para el personal
@author vincenzo
-->
<?php
/*seccion includes*/
require("requerimientos_ctrl.php");

$id = $_GET['id'];
$idP = $_GET['idP'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_initIng(<?php echo $id; ?>);">
        <form id="formulario">
            <div id="idcoor"></div>
            <table class="tabla">
                <tr>
                    <td>ID:</td>
                    <td><div id="id" title="Número de requerimiento generado"><input type="text" name="txtId" id="txtId"  size="6" class="text"></div></td>
                    <td>Fecha:</td>
                    <td><div id="lblFecha" title="Fecha de solicitud del requerimiento"></div></td>
                </tr>
                <tr>
                    <td>ID Personal:</td>
                    <td><div id="lblID" title="Cedula del usuario solicitante del requerimiento"></div></td>
                    <td>Nombre:</td>
                    <td><div id="lblNombre" title="Nombre del usuario solicitante del requerimiento"></div></td>
                </tr>
                <tr>
                    <td>&Aacute;rea:</td>
                    <td><div id="lblArea" title="Área a la cual se le realizará el requerimiento"></div></td>
                    <td>Coordinaci&oacute;n:</td>
                    <td><div id="lblCoordinacion" title="Coordinación a la cual se le realizará el requerimiento"></div></td>
                </tr>
                <tr>
                    <td>Servicio:</td>
                    <td><div id="lblServicios" title="Servicio que requiere"></div></td>
                    <td>Equipo:</td>
                    <td><div id="lblEquipos" title="Equipo al cual solicita requerimiento"></div></td>
                </tr>
                <tr>
                    <td>Descripci&oacute;n:</td>
                    <td colspan="3"><div id="lblDescripcion"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Iniciar" onclick="xajax_iniciar(document.getElementById('txtId').value, <?php echo $idP; ?>);return false;" />
                        <input type="button" value="Cancelar" name="btnCancelar" onclick="xajax_cancelar('requerimientos_vis_band_ing.php?id=<?php echo $idP; ?>');" />
                    </td>
                </tr>
            </table>
        </form>
        <h3><u>Anexos:</u></h3>
        <div id="lblAnexos"></div>
    </body>
</html>
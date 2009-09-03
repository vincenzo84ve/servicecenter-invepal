<!--

@author vincenzo
-->
<?php
/*seccion includes*/
require("requerimientos_ctrl.php");

$id = $_GET['id'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter - Area->A&ntilde;adir</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_initVer(<?php echo $id; ?>);">
        <div id="mensaje"></div>
        <form id="formulario">
            <table class="tabla">
                <tr>
                    <td>ID:</td>
                    <td><div id="id"><input type="text" name="txtId" id="txtId"  size="6" class="text"></div></td>
                    <td>Fecha:</td>
                    <td><div id="lblFecha"></div></td>
                </tr>
                <tr>
                    <td>ID Personal:</td>
                    <td><div id="lblID"></div></td>
                    <td>Nombre:</td>
                    <td><div id="lblNombre"></div></td>
                </tr>
                <tr>
                    <td>&Aacute;rea:</td>
                    <td><div id="lblArea"></div></td>
                    <td>Coordinaci&oacute;n:</td>
                    <td><div id="lblCoordinacion"></div></td>
                </tr>
                <tr>
                    <td>Servicio:</td>
                    <td><div id="lblServicios"></div></td>
                    <td>Equipo:</td>
                    <td><div id="lblEquipos"></div></td>
                </tr>
                <tr>
                    <td>Descripci&oacute;n:</td>
                    <td colspan="3"><div id="lblDescripcion"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Aprobar" onclick="xajax_aprobar(xajax.getFormValues('formulario'));return false;" />
                        <input type="button" value="Anular" onclick="xajax_anular(xajax.getFormValues('formulario'));return false;" />
                        <input type="button" value="Cancelar" name="btnCancelar" onclick="xajax_cancelar('requerimientos_vis_band_coor.php?id=16074351');" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
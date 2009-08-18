<!--
Vista para controlar los niveles que se pueden crear dentro de la bd para el personal
@author vincenzo
-->
<?php
/*seccion includes*/
require("area_ctrl.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter - Nivel->A&ntilde;adir</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_initAdd();">
        <div id="mensaje"></div>
        <form id="formulario">
            <table class="tabla">
                <tr>
                    <td>Id:</td>
                    <td><div id="id"><input type="text" name="txtId" id="txtId"  size="6" class="text"></div></td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="txtNombre" id="txtNombre" size="30" class="text" /></td>
                </tr>
                <tr>
                    <td>Ubicaci&oacute;n:</td>
                    <td><input type="text" name="txtUbicacion" id="txtUbicacion" size="30" class="text" /></td>
                </tr>
                <tr>
                    <td>Coordinaci&oacute;n:</td>
                    <td><div id="cmbCoordinacion"></div><!--<input type="text" name="txtCoordinacion" id="txtCoordinacion" size="30" class="text" />--></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Guardar" onclick="xajax_guardar(xajax.getFormValues('formulario'));return false;" />
                        <input type="reset" value="Limpiar" class="boton" />
        </form>
                        <form id="formCancel" action="coordinacion_vis.php">
                            <input type="submit" value="Cancelar" name="btnCancelar" />
                        </form>
                    </td>
                </tr>
            </table>
    </body>
</html>

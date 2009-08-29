<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*seccion includes*/
require("servicios_ctrl.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_initAdd();">
        <div id="mensaje"></div>
        <form id="formulario">
            <table class="tabla">
                <tr>
                    <td>ID:</td>
                    <td><div id="id"><input type="text" name="txtId" id="txtId" size="6" class="text"></div></td>
                </tr>
                <tr>
                    <td>Descripci&oacute;n:</td>
                    <td><input type="text" name="txtDescripcion" id="txtDescripcion" class="text"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Guardar" onclick="xajax_gurdar(xajax.getFormValues('formulario'));return false;" />
                        <input type="button" value="Cancelar" onclick="xajax_cancelar()" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

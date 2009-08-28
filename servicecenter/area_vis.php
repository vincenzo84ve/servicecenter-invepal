<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*seccion includes*/
require("area_ctrl.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter - Coordinaciones</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_init();">
        <div id="mensaje"></div>
        <div id="listadoAreas">
            <table class="tabla">
                <tr>
                    <td><b>ID</b></td>
                    <td><b>Nombre</b></td>
                    <td><b>Ubicaci&oacute;n</b></td>
                    <td><b>Coordinaci&oacute;n</b></td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="button" value="A&ntilde;adir" name="btnAdd" onclick="xajax_anhiadir();" />
                </td>
            </tr>
        </table>
    </body>
</html>
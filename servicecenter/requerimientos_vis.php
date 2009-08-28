<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*seccion includes*/
require("requerimientos_ctrl.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter - Servicios</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_init();">
        <div id="mensaje"></div>
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
                    <form id="form1" action="requerimientos_vis_add.php">
                        <input type="submit" value="A&ntilde;adir" name="btnAdd" />
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
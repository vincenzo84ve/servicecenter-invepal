<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*seccion includes*/
require("equipos_ctrl.php");
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
        <div id="listadoEquipos">
            <table class="tabla">
                <tr>
                    <td><b>ID</b></td>
                    <td><b>Descripci&oacute;n</b></td>
                    <td><b>Marca</b></td>
                    <td><b>Modelo</b></td>
                    <td><b>N° Bien</b></td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <form id="form1" action="equipos_vis_add.php">
                        <input type="submit" value="A&ntilde;adir" name="btnAdd" />
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
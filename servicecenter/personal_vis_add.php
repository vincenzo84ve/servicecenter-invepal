<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
/*seccion includes*/
require("personal_ctrl.php");
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
                    <td>Cedula:</td>
                    <td><div id="ci"><input type="text" name="txtCedula" id="txtCedula" class="text"></div></td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="txtNombre" id="txtNombre" class="text"></td>
                </tr>
                <tr>
                    <td>Apellido:</td>
                    <td><input type="text" name="txtApellido" id="txtApellido" class="text"></td>
                </tr>
                <tr>
                    <td>e-mail:</td>
                    <td><input type="text" name="txtMail" id="txtMail" class="text"></td>
                </tr>
                <tr>
                    <td>Tel&eacute;fono:</td>
                    <td><input type="text" name="txtTelf" id="txtTelf" class="text"></td>
                </tr>
                <tr>
                    <td>Nivel:</td>
                    <td><div id="cmbNivel"></div></td>
                </tr>
                <tr>
                    <td>Coordinaci&oacute;n:</td>
                    <td><div id="cmbCoordinacion"></div></td>
                </tr>
                <tr>
                    <td>&Aacute;rea:</td>
                    <td><div id="cmbArea"></div></td>
                </tr>
                <tr>
                    <td>Clave:</td>
                    <td><input type="password" name="txtClave1" id="txtClave1" class="text"></td>
                </tr>
                <tr>
                    <td>Confirmar:</td>
                        <td><input type="password" name="txtClave2" id="txtClave2" class="text"></td>
                </tr>
                <tr>
                    <td><div id="lblEstado"></div></td>
                    <td><div id="estado"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Guardar" onclick="xajax_guardar(xajax.getFormValues('formulario'));return false;" />
                        <input type="button" value="Buscar" onclick="xajax_buscar(document.getElementById('txtCedula').value);" />
                        <input type="reset" value="Limpiar" class="boton" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

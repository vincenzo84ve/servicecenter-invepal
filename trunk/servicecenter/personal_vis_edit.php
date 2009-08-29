<!--
Vista para controlar los niveles que se pueden crear dentro de la bd para el personal
@author vincenzo
-->
<?php
/*seccion includes*/
require("personal_ctrl.php");

$id = $_GET['id'];
$idn = $_GET['idN'];
$ida = $_GET['idA'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <?php $xajax->printJavascript();?>
    </head>
    <body onload="xajax_initEdit(<?php echo $id;?>,<?php echo $idn;?>,<?php echo $ida;?>);">
        <div id="mensaje"></div>
        <form id="formulario">
            <table class="tabla">
                <tr>
                    <td>Cedula:</td>
                    <td><div id="id"><input type="text" name="txtId" id="txtId" class="text"></div></td>
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
                    <td><div id="lblNivel"></div></td>
                </tr>
                <tr>
                    <td>Coordinaci&oacute;n:</td>
                    <td><div id="lblCoordinacion"></div></td>
                </tr>
                <tr>
                    <td>&Aacute;rea:</td>
                    <td><div id="lblArea"></div></td>
                </tr>
                <!--<tr>
                    <td>Clave:</td>
                    <td><input type="password" name="txtClave1" id="txtClave1" class="text"></td>
                </tr>
                <tr>
                    <td>Confirmar:</td>
                        <td><input type="password" name="txtClave2" id="txtClave2" class="text"></td>
                </tr>-->
                <tr>
                    <td>Estado:</td>
                    <td><div id="estado"></div>
                        <select name="cmbEstado" id="cmbEstado">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Actualizar" onclick="xajax_validar_modificar(xajax.getFormValues('formulario'));return false;" />
                        <input type="button" value="Cancelar" onclick="xajax_cancelar();" />
                    </td>
                </tr>
            </table>
    </body>
</html>
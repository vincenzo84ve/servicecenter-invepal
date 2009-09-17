<!--
Vista para controlar los niveles que se pueden crear dentro de la bd para el personal
@author vincenzo
-->
<?php
/*seccion includes*/
require("requerimientos_ctrl.php");

$id = $_GET['id'];

# Verificamos que el formulario no ha sido enviado aun
$postback = (isset($_POST["enviar"])) ? true : false;
# Concexión a la base de datos
$link = pg_connect("host=190.109.100.36 user=postgres password=invepal1nv3p4l dbname=scdat") or die(pg_last_error($link));
if($postback){
    //Compruebo que existe la ruta del archivo
    if (empty($_FILES["archivo"]["name"])){
        ?>
        <script>
            alert("No a elegido un archivo aún o este no es valido!");
        </script>
        <?php 
    }else{
        # Variables del archivo
        $type = $_FILES["archivo"]["type"];
        $tmp_name = $_FILES["archivo"]["tmp_name"];
        $size = $_FILES["archivo"]["size"];
        $nombre = basename($_FILES["archivo"]["name"]);
        # Contenido del archivo
        $fp = fopen($tmp_name, "rb");
        $buffer = fread($fp, filesize($tmp_name));
        fclose($fp);
        #datos del requerimiento
        $req = $_POST["txtIdReq"];

        # Inicia una transacción
        pg_query($link, "begin");
        # Crea un objeto blob y retorna el oid
        $oid=pg_lo_create($link);
        $sql = "INSERT INTO anexo_requerimientos (id_requerimiento, archivo_oid, nombre, mime, size) VALUES ('$req', '$oid', '$nombre',  '$type', '$size')";

        # Ejecuta la sentencia SQL
        pg_query($link, $sql) or die(pg_last_error($link));

        # Abre el objeto blob
        $blob=pg_lo_open($link,$oid,"w");
        # Escribe el contenido del archivo
        pg_lo_write($blob,$buffer);
        # Cierra el objeto
        pg_lo_close($blob);
        # Compromete la transacción
        pg_query($link, "commit");

        #Cerrar la conexión
        pg_close($link);
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter</title>
        <?php $xajax->printJavascript(); ?>
    </head>
    <body onload="xajax_initAdd(<?php echo $id; ?>);">
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
                    <td colspan="3"><textarea name="txtDescripcion" id="txtDescripcion" title="Descripcion del requerimiento" rows="4" cols="80"></textarea></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" value="Emitir" onclick="xajax_emitir(xajax.getFormValues('formulario'));return false;" />
                        <input type="button" value="Cancelar" name="btnCancelar" onclick="xajax_cancelar('requerimientos_vis.php');" />
                    </td>
                </tr>
            </table>
        </form>
        <form name="frmblob" id="frmblob" method="post" enctype="multipart/form-data" action="">
            <table>
                <tr>
                    <td>Archivo:</td><td><div id="idRequerimiento"></div></td>
                    <td colspan="3"><input type="file" id="archivo" name="archivo" title="Archivo a subir" size="40" /></td><td><input type="submit" name="enviar" id="enviar" value="Adjuntar" /></td>
                </tr>
            </table>
        </form>
        <h3><u>Anexos:</u></h3>
        <div id="lblAnexos"></div>
    </body>
</html>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
    // put your code here
    # Verificamos que el formulario no ha sido enviado aun
    $postback = (isset($_POST["btnLogin"])) ? true : false;

    if($postback){
        $usuario = $_POST["txtLogin"];
        $password = md5($_POST["txtPassword"]);

        $sql = "SELECT * FROM personal WHERE id='".$usuario."' AND password='".$password."'";

        $link = pg_connect("host=190.109.100.36 port=5432 user=postgres password=invepal1nv3p4l dbname=scdat") or die(pg_last_error($link));

        $r = pg_query($link, $sql) or die(pg_last_error($link));

        if (pg_num_rows($r)<1){
            ?>
            <script>
                window.location = "index.php";
            </script>
            <?php
        }else{
            //usuario y contraseña válidos
            //defino una sesion y guardo datos
            session_start();
            $_SESSION["autentificado"]= "SI";
            include ("su.php");
        }
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ServiceCenter - Invepal</title>
        <link rel="stylesheet" type="text/css" href="css/login.css" />
        <link rel="shortcut icon" href="imagenes/invepal.png" />
    </head>
    <body>
        <table width="100%">
            <tr>
                <td valign="middle" align="center">
                    <form id="formulario" name="fomulario" action="#" method="post"><br /><br />
                        <div id="loginInvepal"><br /><br /><br /><br />
                        <table id="login_form" class="letra">
                            <tr>
                                <td height="37" colspan="2" align="center"></td>
                            </tr>
                            <tr>
                                <td width="183" class="alineacionder">&nbsp;</td>
                                <td width="324" class="alineacionizq"><span class="tupla_acceso">Usuario:</span></td>
                            </tr>
                            <tr>
                                <td class="alineacionder">&nbsp;</td>
                                <td class="alineacionizq">
                                    <input type="text" size="12" name="txtLogin" id="txtLogin" title="Indique cedula de identidad del usuario">
                                </td>
                            </tr>
                            <tr>
                                <td class="alineacionder">&nbsp;</td>
                                <td class="alineacionizq"><span class="tupla_acceso">Contrase&#241;a:&#160;</span></td>
                            </tr>
                            <tr>
                                <td class="alineacionder"></td>
                                <td class="alineacionizq">
                                    <input type="password" size="12" name="txtPassword" id="txtPassword" title="Indique password del usuario">
                                </td>
                            </tr>
                            <tr>
                                <td class="alineacioncenter espaciovert_sep" colspan="2" align="center">
                                    <p>
                                        <input type="submit" name="btnLogin" id="btnLogin" value="Iniciar Sesi&oacute;n" />
                                        <input type="reset" name="brnLogin" value="Limpiar" />
                                    </p>
                                    <p><br /><br /><?php include("atm.php"); ?> </p>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>ServiceCenter - Invepal</title>
    </head>
    <body>
<!-- Cuerpo -->
        <center>
            <table class="pagina" align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2">
                        <?php include("banner.php");?>
                    </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td>
                        <!-- menu lateral -->
                        <?php include("menu.php");?>
                        <!-- fin menu lateral -->
                    </td>
                    <td>
                        <!-- area central -->
                        <?php
                            extract($HTTP_GET_VARS);
                            if(empty($sec)){
                                include("home.php");
                            }else{
                                if(file_exists($sec.".php")){
                                    include($sec.".php");
                                }elseif(file_exists($sec.".html")){
                                    include($sec.".html");
                                }else{
                                    echo 'Disculpe, la página solicitada no existe';
                                }
                            }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php include("footer.php"); ?>
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>

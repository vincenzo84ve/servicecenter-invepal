<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>ServiceCenter - Invepal</title>
        <style type="text/css">
            body {font-family: Arial, Helvetica, sans-serif;margin: 0;font-size: 70%;font-weight: bold;background: #202B31;}
            ul {list-style: none;margin: 0;padding: 0;}
            img {border: none;}
            #titulo {font-size:xx-large; text-align:center; color:highlighttext;}
            #imagen{position:inherit;}
            #container {width:200px;background-color: #333A46;margin-left: 15px;margin-top: 36px;}
            #top {background-image: url('nav_top.gif');background-repeat:no-repeat;background-position:top left;height: 16px;}
            #bottom {background-image: url('nav_bottom.gif');background-repeat:no-repeat;background-position:bottom left;height: 16px;border-top:1px solid #000;}
            #roScripts_m2 {width: 200px;}
            #roScripts_m2 li a {height: 32px;voice-family: "\"}\"";voice-family: inherit;height: 24px;text-decoration: none;}
            #roScripts_m2 li a:link, #roScripts_m2 li a:visited {color: #ccc;display: block;background:  url(roScripts_m2.gif);padding: 8px 0 0 25px;}
            #roScripts_m2 li a:hover, #roScripts_m2 li #current {color: #fff;background:  url(roScripts_m2.gif) 0 -32px;border-bottom:1px solid #000;padding: 8px 0 0 27px;}
        </style>
    </head>
    <body>
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="3"><div id="titulo" align="right">Service Center - Invepal</div></td>
                </tr>
                <tr>
                    
                    <td width="20%"><p>Menu principal</p>
                        <div id="container">
                        <div id="top"></div>
                        <div id="roScripts_m2">
                            <ul>
                                <!--<li><a id="current" href="?sec=home">Inicio</a></li>-->
                                <li><a href="?sec=home">Inicio</a></li>
                                <li><a href="?sec=personal_vis">Personal</a></li>
                                <li><a href="?sec=area_vis">&Aacute;reas</a></li>
                                <li><a href="Services.html">Services</a></li>
                                <li><a href="Support.html">Support</a></li>
                                <li><a href="Order.html">Order</a></li>
                                <li><a href="News.html">News</a></li>
                                <li><a href="About.html">About</a></li>
                            </ul>
                            <div id="bottom"></div>
                        </div>
                        </div>
                    </td>
                    <td colspan="2" valign="middle">
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
                    <td colspan="3">Pie de p&aacute;gina </td>
                </tr>
            </table>
    </body>
</html>

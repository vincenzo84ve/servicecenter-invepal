<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>ServiceCenter - Invepal</title>

        <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    </head>
    <body>
        <div style="width:184px">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div class="menu_lateral">
                        <ul>
                            <li>
                                <div class="menu_inactivo" id="menu_inicio" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="index.php" style="text-decoration:none">Inicio</a>
                                </div>
                            </li>

                            <li>
                                <div class="menu_inactivo" id="menu_requerimientos" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="?sec=requerimientos_vis" style="text-decoration:none">Requerimientos</a>
                                </div>
                            </li>

                            <li>
                                <div class="menu_inactivo" id="menu_servicios" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="?sec=servicios_vis" style="text-decoration:none">Servicios</a>
                                </div>
                            </li>

                            <li>
                                    <div class="menu_inactivo" id="menu_equipos" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                        <a href="?sec=equipos_vis" style="text-decoration:none">Equipos</a>
                                    </div>
                            </li>

                            <li>
                                <div class="menu_inactivo" id="menu_personal" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="?sec=personal_vis">Personal</a>
                                </div>
                            </li>

                            <!--<li>
                                <div class="menu_inactivo" id="menu_contratos" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="">Contrataciones</a>
                                </div>
                            </li>-->

                            <li>
                                <div class="menu_inactivo" id="menu_coordinaciones" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="#" style="text-decoration:none">Coordinaciones -></a>
                                </div>
                                <!--Submenu-->
                                <ul>
                                    <li class="activa_border">
                                        <a href="?sec=area_vis" style="text-decoration:none">&Aacute;reas</a>
                                    </li>
                                    <li class="activa_border">
                                        <a href="?sec=coordinacion_vis" style="text-decoration:none">Coordinaciones Generales</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <div class="menu_inactivo" id="menu_reportes" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="#" style="text-decoration:none">Reportes -></a>
                                </div>
                                <!--Submenu-->
                                <ul>
                                    <li class="activa_border">
                                        <a href="#" style="text-decoration:none">Reporte 1</a>
                                    </li>
                                    <li class="activa_border">
                                        <a href="#" style="text-decoration:none">Reporte 2</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <div class="menu_inactivo" id="menu_password" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="">Cambiar Password</a>
                                </div>
                            </li>

                            <li>
                                <div class="menu_inactivo" id="menu_salir" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="" title="Salir del Sistema">Salir del Sistema</a>
                                </div>
                            </li>

                            <!--<li>
                                <div class="menu_inactivo" id="menu_empleos" onMouseOver="prendido(this.id)" onmouseout="apagado(this.id)" style="cursor:pointer">
                                    <a href="javascript:abrirReporte('validar.php');" alt="Validar Constancia de Trabajo o Documentos" title="Validar Constancia de Trabajo o Documentos">Validar Documentos</a>
                                </div>
                            </li>-->
                        </ul>
                    </div>

                    <div class="seccionExtras">
                        <div>
                            <!--a href="https://www.invepal.com.ve" target="_blank" -->
                            <!--<img class="imgcorreo" src="images/w_mail_invepal.png" alt="INVEPAL - WebMail"/></a>-->
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        </div>
    </body>
</html>
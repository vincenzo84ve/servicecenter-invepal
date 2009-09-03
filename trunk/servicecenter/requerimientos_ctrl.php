<?php

require_once("xajax_core/xajaxAIO.inc.php");

$xajax = new xajax("requerimientos_mdl.php");

$xajax->register(XAJAX_FUNCTION, "emitir");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "cancelar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");
$xajax->registerFunction(XAJAX_FUNCTION, "cancelar");
$xajax->registerFunction(XAJAX_FUNCTION, "anhiadir");
$xajax->register(XAJAX_FUNCTION, "buscarID");
$xajax->register(XAJAX_FUNCTION, "initVer");
$xajax->register(XAJAX_FUNCTION, "initBandejaCoordinador");
$xajax->register(XAJAX_FUNCTION, "filtrar");
$xajax->register(XAJAX_FUNCTION, "aprobar");
$xajax->register(XAJAX_FUNCTION, "anular");
$xajax->register(XAJAX_FUNCTION, "initAsig");
$xajax->register(XAJAX_FUNCTION, "asignar");

// Inicializar vista
function init($pagina, $inicio){
    $objResp = new xajaxResponse();

    $req = new Requerimiento();

    $r = $req->listar($pagina, $inicio);

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los requerimientos.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los requerimientos.");
    }else{
        $lst = $req->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>&nbsp;ID&nbsp;</b></td><td><b>&nbsp;Fecha&nbsp;</b></td><td><b>&nbsp;Servicio&nbsp;</b></td><td><b>&nbsp;Personal&nbsp;</b></td><td><b>&nbsp;Area&nbsp;</b></td><td><b>&nbsp;Coordinaci&oacute;n&nbsp;</b></td><td><b>&nbsp;Estado&nbsp;</b></td></tr></table><p>";
            $lst .= "No existen requerimientos registrados a&uacute;n!";
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
            $objResp->assign("datosPaginacion", "innerHTML", $req->getDatosPag());
            $objResp->assign("paginacion", "innerHTML", $req->getPaginacion());
        }
    }

    return $objResp;
}

// Funcion para guardar los datos
function emitir($datos){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($datos["txtId"], $datos["txtFecha"], $datos["cmbServicios"], $datos["txtDescripcion"], "", "", "", "", $datos["cmbEquipos"], "", "", "", $datos["txtIdP"], "pendiente", "", "", "", $datos["txtIdCoordinacion"]);

    $r = $req->guardar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        //Envio el correo al coordinador general
        $r = $req->correoCordinador();
        
        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            if (($req->getCorreoCoordinador()==null )|| ($req->getNomCoordinador()==null)){
                $objResp->alert("Error area sin coordinador o coordinador si mail registrado!");
            }else{
                $objResp->alert($req->getCorreoCoordinador());

                $req->Datos($req->getId_personal());

                $cabeceras = "Content-type: text/html\r\n";

                $asunto = "Solicitud de Requerimientos - Soporte Tecnico";

                $mensaje = "<h1>Informe para aprobac&oacute;n de solicitud de requerimiento</h1><p><br />";
                $mensaje .= "<u>Solicitud de requerimiento No.</u>".$req->getId()."<br />";
                $mensaje .= "<u>Solicitado por:</u>".$req->getNomP()."<br />";
                $mensaje .= "<u>Descripci&oacute;n del requerimiento:</u>".$req->getDescripcion()."<br />";
                $mensaje .= "Estamiado, ".$req->getNomCoordinador()." coordinador del &aacute;rea de ".$req->getCoordinacion()." agredecemos su pronta atención con el referido caso,<br />";
                $mensaje .= "para hacer seguimiento del mismo puede acceder al sistema de soporte haciendo click aqu&iacute;: <a href=\"http://".$_SERVER['HTTP_HOST']."/servicecenter/\">servicecenter</a>";

                $r = mail($req->getCorreoCoordinador(),$asunto,$mensaje, $cabeceras);

                if ($r){
                    $objResp->alert("Requerimiento emitido con éxito!");
                }else{
                    $objResp->alert("Incorrecto!");
                }
            }
        }
        $objResp->alert("Guardado con éxito!");
        $objResp->redirect("requerimientos_vis.php");
    }
    return $objResp;
}

function initEdit($id){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($id);

    $r = $req->buscar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $eq->getId());
        $objResp->assign("txtDescripcion", "value", $eq->getDescripcion());
        $objResp->assign("txtMarca", "value", $eq->getMarca());
        $objResp->assign("txtModelo", "value", $eq->getModelo());
        $objResp->assign("txtBien", "value", $eq->getNBien());
    }

    return $objResp;
}

function validar_modificar($datos){
    $objResp = new xajaxResponse();

    if ($datos['txtDescripcion']==""){
        $objResp->alert("Equipo sin descripción!\nPor favor revise e intente de nuevo.");
    }else{
        $objResp->confirmCommands(1, "Esta Seguro?");
        $objResp->call("xajax_modificar", $datos);
    }

    return $objResp;
}

function modificar($datos){
    $objResp = new xajaxResponse();

    $eq = new Equipo($datos["txtId"], $datos["txtDescripcion"], $datos["txtMarca"], $datos["txtModelo"], $datos["txtBien"]);

    $r = $eq->modificar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $objResp->alert("Actulizado con éxito!");
        $objResp->redirect("equipos_vis.php");
    }

    return $objResp;
}

function initAdd($arg){
    $objResp = new xajaxResponse();

    $req = new Requerimiento();

    $r = $req->idRequerimiento();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible generar id de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar id de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista para añadir nuevas areas
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $req->getId());
    }

    $r = $req->Datos($arg);

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $text ="<input type=\"text\" name=\"txtIdP\" id=\"txtIdP\"  size=\"6\" readonly=\"readonly\" />";
        $objResp->assign("lblID", "innerHTML", $text);
        $objResp->assign("txtIdP", "value", $req->getId_personal());
        $text ="<input type=\"text\" name=\"txtNomP\" id=\"txtNomP\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblNombre", "innerHTML", $text);
        $objResp->assign("txtNomP", "value", $req->getNomP());
        $text ="<input type=\"text\" name=\"txtArea\" id=\"txtArea\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblArea", "innerHTML", $text);
        $objResp->assign("txtArea", "value", $req->getArea());
        $textID ="<input type=\"text\" name=\"txtCoordinacion\" id=\"txtCoordinacion\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblCoordinacion", "innerHTML", $textID);
        $objResp->assign("txtCoordinacion", "value", $req->getCoordinacion());
        $textIC ="<input type=\"hidden\" name=\"txtIdCoordinacion\" id=\"txtIdCoordinacion\"  size=\"22\" />";
        $objResp->assign("idcoor", "innerHTML", $textIC);
        $objResp->assign("txtIdCoordinacion", "value", $req->getIdCoordinacion());
    }

    $text = "<input type=\"text\" name=\"txtFecha\" id=\"txtFecha\"  size=\"16\" readonly=\"readonly\" />";
    $objResp->assign("lblFecha", "innerHTML", $text);
    $ahora = getdate();
    $fecha = $ahora["mday"] . "/" . $ahora["mon"] . "/" . $ahora["year"]." ".$ahora["hours"] . ":" . $ahora["minutes"] . ":" . $ahora["seconds"];
    $objResp->assign("txtFecha", "value", $fecha);

    $r = $req->servicios();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblServicios", "innerHTML", $req->getServicios());
    }

    $r = $req->equipos();
    
    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblEquipos", "innerHTML", $req->getEquipos());
    }

    return $objResp;
}

function lsAreas($arg){
    $objResp = new xajaxResponse();

    $pers = new Personal();

    $r = $pers->cmbAreas($arg);

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible generar lista de áreas.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible generar lista de áreas.");
    }else{
        $objResp->assign("cmbArea", "innerHTML", $pers->getesquemaAreas());
    }

    return $objResp;
}

function cancelar($url){
    $objResp = new xajaxResponse();

    $objResp->redirect($url);

    return $objResp;
}

function anhiadir(){
    $objResp = new xajaxResponse();

    $objResp->redirect("index.php?sec=requerimientos_vis_add");

    return $objResp;
}

function buscarID($arg){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($arg);

    $r = $req->buscar();
    
    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible mostrar el registro especificado.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible mostrar el registro especificado.");
    }else{
        $objResp->assign("listadoRequerimientos", "innerHTML", $req->getLista());
        $objResp->assign("datosPaginacion", "innerHTML", $req->getDatosPag());
    }

    return $objResp;
}

function initVer($arg){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($arg);

    $r = $req->detalles($arg);

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible generar detalles de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar detalles de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista para añadir nuevas areas
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $req->getId());
    }

    $r = $req->Datos($req->getId_personal());

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $text ="<input type=\"text\" name=\"txtIdP\" id=\"txtIdP\"  size=\"6\" readonly=\"readonly\" />";
        $objResp->assign("lblID", "innerHTML", $text);
        $objResp->assign("txtIdP", "value", $req->getId_personal());
        $text ="<input type=\"text\" name=\"txtNomP\" id=\"txtNomP\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblNombre", "innerHTML", $text);
        $objResp->assign("txtNomP", "value", $req->getNomP());
        $text ="<input type=\"text\" name=\"txtArea\" id=\"txtArea\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblArea", "innerHTML", $text);
        $objResp->assign("txtArea", "value", $req->getArea());
        $textID ="<input type=\"text\" name=\"txtCoordinacion\" id=\"txtCoordinacion\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblCoordinacion", "innerHTML", $textID);
        $objResp->assign("txtCoordinacion", "value", $req->getCoordinacion());
    }

    $text = "<input type=\"text\" name=\"txtFecha\" id=\"txtFecha\"  size=\"16\" readonly=\"readonly\" />";
    $objResp->assign("lblFecha", "innerHTML", $text);
    $ahora = getdate();
    $fecha = $ahora["mday"] . "/" . $ahora["mon"] . "/" . $ahora["year"]." ".$ahora["hours"] . ":" . $ahora["minutes"] . ":" . $ahora["seconds"];
    $objResp->assign("txtFecha", "value", $fecha);

    $r = $req->servicios();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblServicios", "innerHTML", $req->getServicios());
    }

    $r = $req->equipos();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblEquipos", "innerHTML", $req->getEquipos());
    }

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblDescripcion", "innerHTML", $req->getDescripcion());
    }

    return $objResp;
}

function initBandejaCoordinador($pag, $ini, $id){
    $objResp = new xajaxResponse();

    $req = new Requerimiento();

    $r = $req->listarBandejaCoordinador($pag, $ini, $id);

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los requerimientos.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los requerimientos.");
    }else{
        $lst = $req->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>&nbsp;ID&nbsp;</b></td><td><b>&nbsp;Fecha&nbsp;</b></td><td><b>&nbsp;Servicio&nbsp;</b></td><td><b>&nbsp;Personal&nbsp;</b></td><td><b>&nbsp;Area&nbsp;</b></td><td><b>&nbsp;Coordinaci&oacute;n&nbsp;</b></td><td><b>&nbsp;Estado&nbsp;</b></td></tr></table><p>";
            $lst .= "No existen requerimientos registrados a&uacute;n!";
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
            $objResp->assign("datosPaginacion", "innerHTML", $req->getDatosPag());
            $objResp->assign("paginacion", "innerHTML", $req->getPaginacion());
        }
    }

    return $objResp;
}

function filtrar($pag, $ini, $arg){
    $objResp = new xajaxResponse();

    $objResp->alert($arg);

    $req = new Requerimiento();

    $r = $req->filtrar($pag, $ini, $arg);

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los requerimientos.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los requerimientos.");
    }else{
        $lst = $req->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>&nbsp;ID&nbsp;</b></td><td><b>&nbsp;Fecha&nbsp;</b></td><td><b>&nbsp;Servicio&nbsp;</b></td><td><b>&nbsp;Personal&nbsp;</b></td><td><b>&nbsp;Area&nbsp;</b></td><td><b>&nbsp;Coordinaci&oacute;n&nbsp;</b></td><td><b>&nbsp;Estado&nbsp;</b></td></tr></table><p>";
            $lst .= "No existen requerimientos registrados a&uacute;n!";
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
            $objResp->assign("datosPaginacion", "innerHTML", $req->getDatosPag());
            $objResp->assign("paginacion", "innerHTML", $req->getPaginacion());
        }
    }
    return $objResp;
}

function aprobar($datos){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($datos["txtId"]);

    $r = $req->aprobar();

    if ($r == -1){
        $objResp->alert("Error en la conexión\nImposible aprobar requerimiento.");
    }else if($r == 0){
        $objResp->alert("Error en la consulta\nImposible aprobar requerimiento.");
    }else{
        //Envio el correo al superusuario del sistema
        $r = $req->correoSuperUsuario();

        

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert($req->getCorreoSU());
            $cabeceras = "Content-type: text/html\r\n";

            $asunto = "Solicitud de Requerimientos - Soporte Tecnico";

            $mensaje = "<h1>Informe para asignaci&oacute;n de solicitud de requerimiento</h1><p><br />";
            $mensaje .= "<u>Solicitud de requerimiento No.</u>".$req->getId()."<br />";
            $mensaje .= "<u>Solicitado por:</u>".$req->getNomP()."<br />";
            $mensaje .= "Para hacer seguimiento del mismo puede acceder al sistema de soporte haciendo click aqu&iacute;: <a href=\"http://".$_SERVER['HTTP_HOST']."/servicecenter/\">servicecenter</a>";

            $r = mail($req->getCorreoSU(),$asunto,$mensaje,$cabeceras);

            if ($r){
                $objResp->alert("Requerimiento aprobado con éxito!");
            }else{
                $objResp->alert("Incorrecto!");
            }
        }
    }
    return $objResp;
}

function anular($datos){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($datos["txtId"]);

    $r = $req->anular();

    if ($r == -1){
        $objResp->alert("Error en la conexión\nImposible anular requerimiento.");
    }else if($r == 0){
        $objResp->alert("Error en la consulta\nImposible anular requerimiento.");
    }else{
            $objResp->alert("Requerimiento anulado con éxito!");
    }
    return $objResp;
}

function initAsig($arg){
    $objResp = new xajaxResponse();

    $req = new Requerimiento($arg);

    $r = $req->detalles($arg);

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible generar detalles de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar detalles de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista para añadir nuevas areas
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $req->getId());
    }

    $r = $req->Datos($req->getId_personal());

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $text ="<input type=\"text\" name=\"txtIdP\" id=\"txtIdP\"  size=\"6\" readonly=\"readonly\" />";
        $objResp->assign("lblID", "innerHTML", $text);
        $objResp->assign("txtIdP", "value", $req->getId_personal());
        $text ="<input type=\"text\" name=\"txtNomP\" id=\"txtNomP\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblNombre", "innerHTML", $text);
        $objResp->assign("txtNomP", "value", $req->getNomP());
        $text ="<input type=\"text\" name=\"txtArea\" id=\"txtArea\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblArea", "innerHTML", $text);
        $objResp->assign("txtArea", "value", $req->getArea());
        $textID ="<input type=\"text\" name=\"txtCoordinacion\" id=\"txtCoordinacion\"  size=\"22\" readonly=\"readonly\" />";
        $objResp->assign("lblCoordinacion", "innerHTML", $textID);
        $objResp->assign("txtCoordinacion", "value", $req->getCoordinacion());
    }

    $text = "<input type=\"text\" name=\"txtFecha\" id=\"txtFecha\"  size=\"16\" readonly=\"readonly\" />";
    $objResp->assign("lblFecha", "innerHTML", $text);
    $ahora = getdate();
    $fecha = $ahora["mday"] . "/" . $ahora["mon"] . "/" . $ahora["year"]." ".$ahora["hours"] . ":" . $ahora["minutes"] . ":" . $ahora["seconds"];
    $objResp->assign("txtFecha", "value", $fecha);

    $r = $req->servicios();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblServicios", "innerHTML", $req->getServicios());
        $objResp->append("cmbServicios", "enable", false);
    }

    $r = $req->equipos();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblEquipos", "innerHTML", $req->getEquipos());
    }

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblDescripcion", "innerHTML", $req->getDescripcion());
    }

    $req->ingenieros();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("lblIngenieros", "innerHTML", $req->getIngenieros());
    }

    return $objResp;
}

function asignar($datos){
    $objResp = new xajaxResponse();

    $objResp->alert($datos["cmbIngenieros"]);

    $req = new Requerimiento($datos["txtId"]);

    $r = $req->asignar();

    if ($r == -1){
        $objResp->alert("Error en la conexión\nImposible aprobar requerimiento.");
    }else if($r == 0){
        $objResp->alert("Error en la consulta\nImposible aprobar requerimiento.");
    }else{
        //Envio el correo al superusuario del sistema
        $r = $req->correoAnalista($datos["cmbIngenieros"]);

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert($req->getCorreoAN());
            $cabeceras = "Content-type: text/html\r\n";

            $asunto = "Solicitud de Requerimientos - Soporte Tecnico";

            $mensaje = "<h1>Informe para asignaci&oacute;n de solicitud de requerimiento</h1><p><br />";
            $mensaje .= "<u>Solicitud de requerimiento No.</u>".$req->getId()."<br />";
            $mensaje .= "<u>Solicitado por:</u>".$req->getNomP()."<br />";
            $mensaje .= "Para hacer seguimiento del mismo puede acceder al sistema de soporte haciendo click aqu&iacute;: <a href=\"http://".$_SERVER['HTTP_HOST']."/servicecenter/\">servicecenter</a>";

            $r = mail("vincenzo84ve@gmail.com",$asunto,$mensaje,$cabeceras);

            if ($r){
                $objResp->alert("Requerimiento asignado con éxito!");
            }else{
                $objResp->alert("Incorrecto!");
            }
        }
    }
    return $objResp;
}

$xajax->processRequest();

?>
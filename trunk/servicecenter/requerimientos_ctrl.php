<?php

require_once("xajax_core/xajaxAIO.inc.php");

$xajax = new xajax("requerimientos_mdl.php");

$xajax->register(XAJAX_FUNCTION, "guardar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "cancelar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");
$xajax->registerFunction(XAJAX_FUNCTION, "cancelar");
$xajax->registerFunction(XAJAX_FUNCTION, "anhiadir");

// Inicializar vista
function init(){
    $objResp = new xajaxResponse();

    $eq = new Requerimiento();

    $r = $eq->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los requerimientos.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los requerimientos.");
    }else{
        $lst = $eq->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>&nbsp;ID&nbsp;</b></td><td><b>&nbsp;Fecha&nbsp;</b></td><td><b>&nbsp;Servicio&nbsp;</b></td><td><b>&nbsp;Personal&nbsp;</b></td><td><b>&nbsp;Area&nbsp;</b></td><td><b>&nbsp;Coordinaci&oacute;n&nbsp;</b></td><td><b>&nbsp;Estado&nbsp;</b></td></tr></table><p>";
            $lst .= "No existen requerimientos registrados a&uacute;n!";
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoRequerimientos", "innerHTML", $lst);
        }
    }

    return $objResp;
}

// Funcion para guardar los datos
function guardar($datos){
    $objResp = new xajaxResponse();

    if (($datos["txtId"]=="")||($datos["txtDescripcion"]=="")){
        $objResp->alert("Existen campos vacios!\nPor favor revise e intente de nuevo.");
        return $objResp;
    }else{
        $eq = new Equipo($datos["txtId"], $datos["txtDescripcion"], $datos["txtMarca"], $datos["txtModelo"], $datos["txtBien"]);

        $r = $eq->guardar();

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert("Guardado con éxito!");
            $objResp->redirect("equipos_vis.php");
        }
    }
    return $objResp;
}

function initEdit($id){
    $objResp = new xajaxResponse();

    $eq = new Equipo($id);

    $r = $eq->buscar();

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
        $objResp->assign("cmbServicios", "innerHTML", $req->getServicios());
    }

    $r = $req->equipos();
    
    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible obtener datos de requerimiento.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible obtener datos de requerimiento.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista
        $objResp->assign("cmbEquipos", "innerHTML", $req->getEquipos());
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

function cancelar(){
    $objResp = new xajaxResponse();

    $objResp->redirect("requerimientos_vis.php");

    return $objResp;
}

function anhiadir(){
    $objResp = new xajaxResponse();

    $objResp->redirect("index.php?sec=requerimientos_vis_add");

    return $objResp;
}

$xajax->processRequest();

?>
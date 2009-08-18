<?php

require_once("xajax_core/xajaxAIO.inc.php");


$xajax = new xajax("coordinacion_mdl.php");

$xajax->register(XAJAX_FUNCTION, "guardar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");

// Inicializar vista
function init(){
    $objResp = new xajaxResponse();

    $coord = new Coordinacion();

    $r = $coord->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar las coordinaciones.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar las coordinaciones.");
    }else{
        $lst = $coord->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>Id</b></td><td><b>Nombre</b></td><td><b>Ubicaci&oacute;n</b></td></tr></table><p>";
            $lst .= "No hay coordinaciones registradas a&uacute;n!";
            $objResp->assign("listadoCoordinacion", "innerHTML", $lst);
        }else{
             $objResp->assign("listadoCoordinacion", "innerHTML", $lst);
        }
    }

    return $objResp;
}

//Funcion para guardar los datos del ingeniero
function guardar($datos){
    $objResp = new xajaxResponse();

    if ($datos["txtNombre"]==""){
        $objResp->alert("Coordinación sin nombre!\nPor favor revise e intente de nuevo.");
        return $objResp;
    }else{
        $coord = new Coordinacion($datos["txtId"], $datos["txtNombre"], $datos["txtUbicacion"]);

        $r = $coord->guardar();

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert("Guardado con éxito!");
        }

        $objResp->redirect("coordinacion_vis.php");

        return $objResp;
    }
}

function initEdit($arg){
    $objResp = new xajaxResponse();

    $coord = new Coordinacion($arg);

    $r = $coord->buscar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
       $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $coord->getId());
        $objResp->assign("txtNombre", "value", $coord->getNombre());
        $objResp->assign("txtUbicacion", "value", $coord->getUbicacion());
    }

    return $objResp;
}

function validar_modificar($datos){
    $objResp = new xajaxResponse();

    if ($datos['txtNombre']==""){
        $objResp->alert("Coordinación sin nombre!\nPor favor revise e intente de nuevo.");
    }else{
        $objResp->confirmCommands(1, "Esta Seguro?");
        $objResp->call("xajax_modificar", $datos);
    }

    return $objResp;
}

function modificar($datos){
    $objResp = new xajaxResponse();

    $coord = new Coordinacion($datos["txtId"], $datos["txtNombre"], $datos["txtUbicacion"]);

    $r = $coord->modificar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $objResp->alert("Actulizado con éxito!");
        $objResp->redirect("coordinacion_vis.php");
    }

    return $objResp;
}

function initAdd(){
    $objResp = new xajaxResponse();

    $coord = new Coordinacion();

    $r = $coord->idCoord();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar id de nivel.");
    }else{// si realizo la consulta con éxito
        //Deshabilitar el campo id para que no pueda ser modificado
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $coord->getId());
        $objResp->clear("txtNombre", "value");
        $objResp->clear("txtUbicacion", "value");
    }

    return $objResp;
}

$xajax->processRequest();

?>
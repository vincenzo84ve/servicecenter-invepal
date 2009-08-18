<?php

require_once("xajax_core/xajaxAIO.inc.php");


$xajax = new xajax("nivel_mdl.php");

$xajax->register(XAJAX_FUNCTION, "guardar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");

//Inicializar vista
function init(){
    $objResp = new xajaxResponse();

    $nivel = new Nivel();

    $r = $nivel->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los niveles.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los niveles.");
    }else{
        $lst = $nivel->getLista();
        if ($lst == null){
            $objResp->assign("listadoNivel", "innerHTML", "No hay niveles registrados aún!");
        }else{
             $objResp->assign("listadoNivel", "innerHTML", $lst);
        }
    }

    return $objResp;
}

function guardar($datos){
    $objResp = new xajaxResponse();

    if ($datos["txtDescripcion"]==""){
        $objResp->alert("Nivel sin descripción!\nPor favor revise e intente de nuevo.");
        return $objResp;
    }else{
        $nivel = new Nivel($datos["txtId"], $datos["txtDescripcion"]);

        $r = $nivel->guardar();

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert("Guardado con éxito!");
        }

        $objResp->redirect("nivel_vis.php");

        return $objResp;
    }
}

function initEdit($arg){
    $objResp = new xajaxResponse();

    $nivel = new Nivel($arg);

    $r = $nivel->buscar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
       $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";
    
        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $nivel->getId());
        $objResp->assign("txtDescripcion", "value", $nivel->getDescripcion());
    }

    return $objResp;
}

function validar_modificar($datos){
    $objResp = new xajaxResponse();

    if ($datos['txtDescripcion']==""){
        $objResp->alert("Id sin descripción!\nPor favor revise e intente de nuevo.");
    }else{
        $objResp->confirmCommands(1, "Esta Seguro?");
        $objResp->call("xajax_modificar", $datos);
    }

    return $objResp;
}

function modificar($datos){
    $objResp = new xajaxResponse();

    $nivel = new Nivel($datos["txtId"], $datos["txtDescripcion"]);

    $r = $nivel->modificar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $objResp->alert("Actulizado con éxito!");
        $objResp->redirect("nivel_vis.php");
    }

    return $objResp;
}

function initAdd(){
    $objResp = new xajaxResponse();

    $nivel = new Nivel();

    $r = $nivel->idNivel();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar id de nivel.");
    }else{// si realizo la consulta con éxito
        //Deshabilitar el campo id para que no pueda ser modificado
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $nivel->getId());
        $objResp->clear("txtDescripcion", "value");
    }

    return $objResp;
}

$xajax->processRequest();

?>

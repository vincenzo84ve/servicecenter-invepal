<?php

require_once("xajax_core/xajaxAIO.inc.php");


$xajax = new xajax("area_mdl.php");

$xajax->register(XAJAX_FUNCTION, "guardar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");

// Inicializar vista
function init(){
    $objResp = new xajaxResponse();

    $area = new Area();

    $r = $area->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar las Areas.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar las Areas.");
    }else{
        $lst = $area->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>Id</b></td><td><b>Nombre</b></td><td><b>Ubicaci&oacute;n</b></td><td><b>Coordinaci&oacute;n</b></td></tr></table><p>";
            $lst .= "No hay Areaes registradas a&uacute;n!";
            $objResp->assign("listadoAreas", "innerHTML", $lst);
        }else{
             $objResp->assign("listadoAreas", "innerHTML", $lst);
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
        $coord = new Area($datos["txtId"], $datos["txtNombre"], $datos["txtUbicacion"]);

        $r = $coord->guardar();

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert("Guardado con éxito!");
        }

        $objResp->redirect("Area_vis.php");

        return $objResp;
    }
}

function initEdit($arg){
    $objResp = new xajaxResponse();

    $coord = new Area($arg);

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

    $coord = new Area($datos["txtId"], $datos["txtNombre"], $datos["txtUbicacion"]);

    $r = $coord->modificar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $objResp->alert("Actulizado con éxito!");
        $objResp->redirect("Area_vis.php");
    }

    return $objResp;
}

function initAdd(){
    $objResp = new xajaxResponse();

    $area = new Area();

    $coord = new Coordinacion();

    $r = $area->idArea();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar id de nivel.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista para añadir nuevas areas
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $coord->listar();
        $esquema = "<select name=\"cmbCooordinacion\" id=\"cmbCoordinacion\">";
        while ($row=mysql_fetch_array($result)){
            $esquema .= "<option value=".$row['cod_carrera'].">".$row['nombre']."</option>";
        }

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $coord->getId());
        $objResp->clear("txtNombre", "value");
        $objResp->clear("txtUbicacion", "value");
    }

    return $objResp;
}

$xajax->processRequest();

?>
<?php

require_once("xajax_core/xajaxAIO.inc.php");

$xajax = new xajax("equipos_mdl.php");

$xajax->register(XAJAX_FUNCTION, "guardar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "cancelar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");
$xajax->register(XAJAX_FUNCTION, "lsAreas");

// Inicializar vista
function init(){
    $objResp = new xajaxResponse();

    $eq = new Equipo();

    $r = $eq->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los equipos.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los equipos.");
    }else{
        $lst = $eq->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>ID</b></td><td><b>Descripci&oacute;n</b></td><td><b>Marca</b></td><td><b>Modelo</b></td><td><b>N° Bien:</b></td></tr></table><p>";
            $lst .= "No hay equipos registrados a&uacute;n!";
            $objResp->assign("listadoEquipos", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoEquipos", "innerHTML", $lst);
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

function initAdd(){
    $objResp = new xajaxResponse();

    $eq = new Equipo();

    $r = $eq->idEquipo();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible generar id de equipo.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar id de equipo.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista para añadir nuevas areas
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $eq->getId());
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

    $objResp->redirect("equipos_vis.php");

    return $objResp;
}

$xajax->processRequest();

?>
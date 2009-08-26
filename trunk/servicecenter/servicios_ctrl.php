<?php

require_once("xajax_core/xajaxAIO.inc.php");

$xajax = new xajax("servicios_mdl.php");

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

    $serv = new Servicio();

    $r = $serv->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar los servicios.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar los servicios.");
    }else{
        $lst = $serv->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>ID</b></td><td><b>Descripci&oacute;n</b></td></tr></table><p>";
            $lst .= "No hay servicios registrados a&uacute;n!";
            $objResp->assign("listadoServicios", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoServicios", "innerHTML", $lst);
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
        $serv = new Servicio($datos["txtId"], $datos["txtDescripcion"]);

        $r = $serv->guardar();

        if ($r == -1){
            $objResp->alert("Error en la conexión!");
        }else if($r == 0){
            $objResp->alert("Error en la consulta!");
        }else{
            $objResp->alert("Guardado con éxito!");
            $objResp->redirect("servicios_vis.php");
        }
    }
    return $objResp;
}

function initEdit($id){
    $objResp = new xajaxResponse();

    $serv = new Servicio($id);

    $r = $serv->buscar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $serv->getId());
        $objResp->assign("txtDescripcion", "value", $serv->getDescripcion());
    }

    return $objResp;
}

function validar_modificar($datos){
    $objResp = new xajaxResponse();

    if ($datos['txtDescripcion']==""){
        $objResp->alert("Servicio sin descripción!\nPor favor revise e intente de nuevo.");
    }else{
        $objResp->confirmCommands(1, "Esta Seguro?");
        $objResp->call("xajax_modificar", $datos);
    }

    return $objResp;
}

function modificar($datos){
    $objResp = new xajaxResponse();

    $serv = new Servicio($datos["txtId"], $datos["txtDescripcion"]);

    $r = $serv->modificar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $objResp->alert("Actulizado con éxito!");
        $objResp->redirect("servicios_vis.php");
    }

    return $objResp;
}

function initAdd(){
    $objResp = new xajaxResponse();

    $serv = new Servicio();

    $r = $serv->idServicio();

    if ($r == -1){// Error en la conexión
        $objResp->alert("Error en la conexion!\nImposible generar id de servicio.");
    }else if ($r == 0){// Error en la consulta
        $objResp->alert("Error en la consulta!\nImposible generar id de servicio.");
    }else{// si realizo la consulta con éxito
        // inicializo la vista para añadir nuevas areas
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $serv->getId());
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

    $objResp->redirect("servicios_vis.php");

    return $objResp;
}

$xajax->processRequest();

?>
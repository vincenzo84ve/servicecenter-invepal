<?php

require_once("xajax_core/xajaxAIO.inc.php");

$xajax = new xajax("personal_mdl.php");

$xajax->register(XAJAX_FUNCTION, "guardar");
$xajax->register(XAJAX_FUNCTION, "validar_modificar");
$xajax->register(XAJAX_FUNCTION, "modificar");
$xajax->register(XAJAX_FUNCTION, "init");
$xajax->register(XAJAX_FUNCTION, "initAdd");
$xajax->register(XAJAX_FUNCTION, "initEdit");
$xajax->register(XAJAX_FUNCTION, "lsAreas");

// Inicializar vista
function init(){
    $objResp = new xajaxResponse();

    $pers = new Personal();

    $r = $pers->listar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible listar el personal.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible listar el personal.");
    }else{
        $lst = $pers->getLista();
        if ($lst == null){
            $lst = "<tr><td><b>ID</b></td><td><b>Nombre</b></td><td><b>Apellido</b></td><td><b>Nivel</b></td><td><b>&Aacute;rea</b></td><td><b>Coordinaci&oacute;n</b></td></tr></table><p>";
            $lst .= "No hay personal registrado a&uacute;n!";
            $objResp->assign("listadoPersonal", "innerHTML", $lst);
        }else{
            $objResp->assign("listadoPersonal", "innerHTML", $lst);
        }
    }

    return $objResp;
}

// Funcion para guardar los datos
function guardar($datos){
    $objResp = new xajaxResponse();
    
    if (($datos["txtCedula"]=="")||($datos["txtNombre"]=="")||($datos["txtApellido"]=="")||($datos["txtMail"]=="")||($datos["txtTelf"]=="")||($datos["txtClave1"]=="")){
        $objResp->alert("Existen campos vacios!\nPor favor revise e intente de nuevo.");
        return $objResp;
    }else{
        if ($datos["txtClave1"]==$datos["txtClave2"]){
            $pers = new Personal($datos["txtCedula"], $datos["txtNombre"], $datos["txtApellido"], $datos["txtMail"],  $datos["txtTelf"], $datos["cmbNivel"], $datos["cmbAreas"], $datos["txtClave1"]);

            $r = $pers->guardar();

            if ($r == -1){
                $objResp->alert("Error en la conexión!");
            }else if($r == 0){
                $objResp->alert("Error en la consulta!");
            }else{
                $objResp->alert("Guardado con éxito!");
                $objResp->redirect("personal_vis.php");
            }
        }else{
            $objResp->alert("Password no coincide!\nPor favor verifique e intente de nuevo.");
        }
    }
    return $objResp;
}

function initEdit($id, $ida){
    $objResp = new xajaxResponse();

    $pers = new Personal($id);

    $r = $pers->buscar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $textBox = "<input type=\"text\" name=\"txtId\" id=\"txtId\"  size=\"6\" readonly=\"readonly\" />";

        $objResp->assign("id", "innerHTML", $textBox);
        $objResp->assign("txtId", "value", $pers->getId());
        $objResp->assign("txtNombre", "value", $pers->getNombre());
        $objResp->assign("txtUbicacion", "value", $pers->getUbicacion());

        $pers->cmbAreas();

        if ($r == -1){
            $objResp->alert("Error en la conexión\nImposible generar lista de coordinaciones");
            $objResp->assign("cmbCoordinacion", "innerHTML", "Imposible generar lista de coordinaciones");
        }else if ($r == 0){
            $objResp->alert("Error en la consulta\nImposible generar lista de coordinaciones");
            $objResp->assign("cmbCoordinacion", "innerHTML", "Imposible generar lista de coordinaciones");
        }else{
            $objResp->assign("cmbCoordinacion", "innerHTML", $pers->getEsquemaCoordinaciones());
            $objResp->assign("cmbCoordinaciones", "value", $idc);
        }
    }

    return $objResp;
}

function validar_modificar($datos){
    $objResp = new xajaxResponse();

    if (($datos['txtNombre']=="")||($datos['txtUbicacion'])==""){
        $objResp->alert("Coordinación sin nombre o ubicación!\nPor favor revise e intente de nuevo.");
    }else{
        $objResp->confirmCommands(1, "Esta Seguro?");
        $objResp->call("xajax_modificar", $datos);
    }

    return $objResp;
}

function modificar($datos){
    $objResp = new xajaxResponse();

    $area = new Area($datos["txtId"], $datos["txtNombre"], $datos["txtUbicacion"], $datos["cmbCoordinaciones"]);

    $r = $area->modificar();

    if ($r == -1){
        $objResp->alert("Error en la conexión!");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!");
    }else{
        $objResp->alert("Actulizado con éxito!");
        $objResp->redirect("area_vis.php");
    }

    return $objResp;
}

function initAdd(){
    $objResp = new xajaxResponse();

    $pers = new Personal();

    $r = $pers->cmbNiveles();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible generar lista de niveles.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible generar lista de niveles.");
    }else{
        $objResp->assign("cmbNivel", "innerHTML", $pers->getesquemaNiveles());
    }

    $r = $pers->cmbCoordinaciones();

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible generar lista de coordinaciones.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible generar lista de coordinaciones.");
    }else{
        $objResp->assign("cmbCoordinacion", "innerHTML", $pers->getesquemaCoordinaciones());
    }

    $r = $pers->cmbAreas(1);

    if ($r == -1){
        $objResp->alert("Error en la conexión!\nImposible generar lista de áreas.");
    }else if ($r == 0){
        $objResp->alert("Error en la consulta!\nImposible generar lista de áreas.");
    }else{
        $objResp->assign("cmbArea", "innerHTML", $pers->getesquemaAreas());
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

$xajax->processRequest();

?>
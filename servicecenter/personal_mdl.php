<?php
require("personal_class.php");

//Funcion para guardar los datos del ingeniero
function guardar($datos){
    $objResp = new xajaxResponse();

    if ($datos["txtClave1"]<>$datos["txtClave2"]){
        $objResp->alert("Claves no coinciden!\nPor favor revise e intente de nuevo.");
        return $objResp;
    }else{
        $personal = new Personal($datos["txtCedula"], $datos["txtNombre"], $datos["txtApellido"], $datos["txtMail"], $datos["txtTelf"], $datos["txtLogin"], $datos["txtClave1"]);

        $r = $ing->guardar();

        $objResp->alert($r);

        $objResp->call("xajax_limpiar");

        return $objResp;
    }
}

//funcion para limpiar los campos del formulario
function limpiar(){
    $objResp = new xajaxResponse();

    // Limpiar cada uno de los campos del formulario
    $objResp->assign("txtCedula", "value", "");
    $objResp->assign("txtNombre", "value", "");
    $objResp->assign("txtApellido", "value", "");
    $objResp->assign("txtLogin", "value", "");
    $objResp->assign("txtClave1", "value", "");
    $objResp->assign("txtClave2", "value", "");
    $objResp->assign("txtMail", "value", "");
    $objResp->assign("txtTelf", "value", "");
    $objResp->assign("lblEstado", "innerHTML", "");
    $objResp->assign("estado", "innerHTML", "");

    // Restablecer el panel de opciones si es necesario
    $panel = "<input type=\"button\" value=\"Guardar\" onclick=\"xajax_guardar(xajax.getFormValues('formulario'));return false;\" class=\"boton\" />";
    $panel .= " <input type=\"button\" value=\"Buscar\" onclick=\"xajax_buscar(document.getElementById('txtCedula').value);\" class=\"boton\" />";
    $panel .= " <input type=\"reset\" value=\"Limpiar\" class=\"boton\" />";

    $objResp->assign("panel", "innerHTML", $panel);

    return $objResp;

}

//funcion para realizar busquedas en la bd de scdat sobre los datos del ingeniero
function buscar($arg){
    $objResp = new xajaxResponse();

    if ($arg==""){
        $objResp->alert("Debe especificar el número de cedula!");
        return $objResp;
    }

    $personal = new Personal($arg);

    $r = $personal->buscar();

    if ($r==null){
        //Deshabilitar el campo cedula para que no pueda ser modificado
        $textBox = "<input type=\"text\" name=\"txtCedula\" id=\"txtCedula\" readonly=\"readonly\" />";

        // Mostrar el registro
        $objResp->assign("txtNombre", "value", $personal->getNombre());
        $objResp->assign("txtApellido", "value", $personal->getApaellido());
        $objResp->assign("txtArea", "value", $personal->getArea());
        $objResp->assign("txtMail", "value", $personal->getEmail());
        $objResp->assign("txtTelf", "value", $personal->getTelefono());
        $objResp->assign("ci", "innerHTML", $textBox);
        $objResp->assign("txtCedula", "value", $personal->getCedula());

        // Reconfigurar las opciones de la vista
        $esquema = "<td><select name=\"cmbEstado\" id=\"cmbEstado\">";
        $esquema .= "<option value=\"activo\">Activo</option>";
        $esquema .= "<option value=\"inactivo\">Inactivo</option>";
        $esquema .= "</select>";
        $panel = "<input type=\"button\" value=\"Actualizar\" onclick=\"xajax_validar_modificar(xajax.getFormValues('formulario'));return false;\" class=\"boton\" />";
        $panel .= " <input type=\"button\" value=\"Cancelar\" onclick=\"xajax_limpiar();\" class=\"boton\" />";

        $objResp->assign("lblEstado", "innerHTML", "Estado:");
        $objResp->assign("estado", "innerHTML", $esquema);
        $objResp->assign("panel", "innerHTML", $panel);
    }else{
        $objResp->alert($r);
    }
    return $objResp;
}

function validar_modificar($datos){
    $objResp = new xajaxResponse();
    
    if (($datos['txtNombre']=="") || ($datos['txtApellido']=="")){
        $objResp->alert("Algun(os) campo(s) esta(n) vacio(s).\nDebe llenar todos los campos!");
    }else{
        $objResp->confirmCommands(1, "Esta Seguro?");
        $objResp->call("xajax_modificar", $datos);
    }

    return $objResp;
}

function modificar($datos){
    $objResp = new xajaxResponse();

    $ing = new ingeniero_mdl($datos["txtCedula"], $datos["txtNombre"], $datos["txtApellido"], $datos["txtMail"], $datos["txtTelf"], $datos["txtLogin"], $datos["txtClave1"], $datos["cmbEstado"]);

    $r = $ing->modificar();

    $objResp->alert($r);

    $objResp->call("xajax_limpiar");

    return $objResp;
}

require("personal_ctrl.php");
$xajax->processRequest();

?>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*sección de include*/
require('conexion.php');

/**
 * Description of ingeniero_mdl
 *
 * @author vincenzo
 */
class Personal{
    //atributos del objeto personal
    var $cedula;
    var $nombre;
    var $apellido;
    var $email;
    var $telf;
    var $nivel;
    var $area;
    var $passw;
    var $estado;

    function __construct($ced=null,$nom=null,$ape=null, $mail=null, $tel=null,$niv=4, $are=null, $pas=null, $est="activo"){
        $this->cedula = $ced;
        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->email = $mail;
        $this->telf = $tel;
        $this->nivel = $log;
        $this->area = $are;
        $this->passw = $pas;
        $this->estado = $est;
    }

    function __desctruct(){
        // Se libera el espacio en memoria ocupado por el objeto personal
    }

    function setCedula($arg){
        $this->cedula = $arg;
    }

    function setNombre($arg){
        $this->nombre = $arg;
    }

    function setApellido($arg){
        $this->apellido = $arg;
    }

    function setEmail($arg){
        $this->email = $arg;
    }

    function satTelefono($ar){
        $this->telf = $arg;
    }

    function setNivel($arg){
        $this->nivel = $arg;
    }

    function setArea($arg){
        $this->area = $arg;
    }

    function setPassword($arg){
        $this->passw;
    }

    function setEstado($arg){
        $this->estado = $arg;
    }

    function getCedula(){
        return ($this->cedula);
    }

    function getNombre(){
        return ($this->nombre);
    }

    function getApellido(){
        return ($this->apellido);
    }

    function getEmail(){
        return ($this->email);
    }

    function getTelefono(){
        return ($this->telf);
    }

    function getNivel(){
        return ($this->nivel);
    }

    function getArea(){
        return ($this->area);
    }

    function getPassw(){
        return ($this->passw);
    }

    function getEstado(){
        return ($this->estado);
    }

    function guardar(){
        $password = md5($this->passw);
        
        $consulta = "INSERT INTO personal (cedula, nombre, apellido, correo, telefono, id_nivel, id_area, password, estado) VALUES ('".$this->cedula."','".$this->nombre."','".$this->apellido."','".$this->email."','".$this->telf."','".$this->nivel."','".$this->area."', '".$password."', '".$this->estado."')";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return "<b>Error en la conexión!</b>";
        }

        $resultado = pg_query($consulta);

        if (!$resultado) {
            return "Error en la consulta!";
        }else{
            pg_FreeResult($resultado);
            $conec->cerrarConexion();
            return "Guardado con éxito!";
        }
    }

    function buscar(){
        $consulta = "SELECT * FROM ingenieros WHERE cedula='".$this->cedula."'";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return "Error en la conexion!";
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return "Error en la consulta!";
        }else{
            if (pg_numrows($resultado)>0){
                $arr = pg_fetch_row ($resultado, 0);
                $this->nombre = $arr[1];
                $this->apellido = $arr[2];
                $this->email = $arr[3];
                $this->telf = $arr[4];
                $this->login = $arr[5];
                $this->estado = $arr[8];
                pg_FreeResult($resultado);
                $conec->cerrarConexion();
                return null;
            }else{
                pg_FreeResult($resultado);
                $conec->cerrarConexion();
                return "El número de cedula ".$this->cedula.", no esta registrado.\nVerifique e intente de nuevo.";
            }
        }
    }

    // Actualizar los datos en la tabla ingenieros
    function modificar(){
        $consulta = "UPDATE ingenieros SET nombre='".$this->nombre."', apellido='".$this->apellido."', correo='".$this->email."', telefono='".$this->telf."', estado='".$this->estado."' WHERE cedula='".$this->cedula."'";

        $conec = new Conexion();

        $conec->conectar();
        
        if (!$conec->obtenerConexion()){
            return "<b>Error en la conexión!</b>";
        }

        $resultado = pg_query($consulta);
        
        if (!$resultado){
            pg_FreeResult($resultado);
            //$conec->cerrarConexion();
            return "Error en la consulta!\n".pg_errormessage($conec->obtenerConexion());
        }else{
            pg_FreeResult($resultado);
            $conec->cerrarConexion();
            return "Actualizado con éxito!";
        }
    }
}
?>

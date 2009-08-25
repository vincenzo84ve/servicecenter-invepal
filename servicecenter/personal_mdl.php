<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*sección de include*/
require('conexion.php');
require_once("personal_ctrl.php");

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
    var $id_nivel;
    var $id_area;
    var $passw;
    var $estado;
    var $html_lst;
    var $esquemaC;
    var $esquemaN;
    var $esquemaA;

    public function __construct($ced=null, $nom=null, $ape=null, $mail=null, $tel=null, $niv=4, $are=null, $pas=null, $est="activo", $lst=null, $esqc=null, $esqn=null, $esqa=null){
        $this->cedula = $ced;
        $this->nombre = $nom;
        $this->apellido = $ape;
        $this->email = $mail;
        $this->telf = $tel;
        $this->id_nivel = $niv;
        $this->id_area = $are;
        $this->passw = $pas;
        $this->estado = $est;
        $this->html_lst = $lst;
        $this->esquemaC = $esqc;
        $this->esquemaN = $esqn;
        $this->esquemaA = $esqa;
    }

    public function __desctruct(){
        // Se libera el espacio en memoria ocupado por el objeto personal
    }

    public function setCedula($arg){
        $this->cedula = $arg;
    }

    public function setNombre($arg){
        $this->nombre = $arg;
    }

    public function setApellido($arg){
        $this->apellido = $arg;
    }

    public function setEmail($arg){
        $this->email = $arg;
    }

    public function satTelefono($ar){
        $this->telf = $arg;
    }

    public function setNivel($arg){
        $this->id_nivel = $arg;
    }

    public function setArea($arg){
        $this->id_area = $arg;
    }

    public function setPassword($arg){
        $this->passw;
    }

    public function setEstado($arg){
        $this->estado = $arg;
    }

    public function getCedula(){
        return ($this->cedula);
    }

    public function getNombre(){
        return ($this->nombre);
    }

    public function getApellido(){
        return ($this->apellido);
    }

    public function getEmail(){
        return ($this->email);
    }

    public function getTelefono(){
        return ($this->telf);
    }

    public function getNivel(){
        return ($this->id_nivel);
    }

    public function getArea(){
        return ($this->id_area);
    }

    public function getPassw(){
        return ($this->passw);
    }

    public function getEstado(){
        return ($this->estado);
    }

    public function setLista($arg){
        $this->html_lst = $arg;
    }

    public function getLista(){
        return $this->html_lst;
    }

    public function guardar(){
        $password = md5($this->passw);

        $consulta = "INSERT INTO personal (id, nombre, apellido, correo, telefono, id_nivel, id_area, password, estado) VALUES ('".$this->cedula."', '".$this->nombre."', '".$this->apellido."', '".$this->email."', '".$this->telf."', '".$this->id_nivel."', '".$this->id_area."', '".$password."', '".$this->estado."')";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1; // Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado) {
            return 0; // Falló la consulta
        }else{
            pg_FreeResult($resultado);
            $conec->cerrarConexion();
            return 1; // Ejecutado con éxito
        }
    }

    public function listar(){
        $consulta = "SELECT * FROM personal ORDER BY id ASC";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1; // Fallo la conexion
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Fallo la consulta
        }else{
            $num = pg_numrows($resultado);
            if ($num > 0){
                $i = 0;
                $ls = "<table>";
                $ls .= "<tr><td><b>Cedula</b></td><td><b>Nombre</b></td><td><b>Apellido</b></td><td><b>Nivel</b></td><td><b>&Aacute;rea</b></td><td><b>Coordinaci&oacute;n</b></td></tr>";
                while($i < $num){
                    $arr = pg_fetch_row ($resultado, $i);
                    $consulta = "SELECT descripcion FROM nivel WHERE id='".$arr[5]."'";
                    $resn = pg_query($consulta);
                    $arrn= pg_fetch_row ($resn, 0);
                    $consulta = "SELECT nombre, id_coordinacion FROM areas WHERE id='".$arr[6]."'";
                    $resa = pg_query($consulta);
                    $arra = pg_fetch_row ($resa, 0);
                    $consulta = "SELECT nombre FROM coordinacion WHERE id='".$arra[1]."'";
                    $resc = pg_query($consulta);
                    $arrc = pg_fetch_row ($resc, 0);
                    $ls .= "<tr><td>".$arr[0]."</td><td>".$arr[1]."</td><td>".$arr[2]."</td><td>".$arrn[0]."</td><td>".$arra[0]."</td><td>".$arrc[0]."</td><td><a href=\"personal_vis_edit.php?id=".$arr[0]."&idN=".$arr[5]."&idA=".$arr[6]."\">Editar</a></tr>";
                    $i++;
                }
                $ls .= "</table>";
                $this->html_lst = $ls;
                unset($ls);
                pg_FreeResult($resultado);
                $conec->cerrarConexion();
            }
            return 1;// Se ejecuto satisfactoriamente
        }
    }

    public function buscar(){
        $consulta = "SELECT * FROM personal WHERE id='".$this->cedula."'";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Error en la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0;// Error en la consulta
        }else{
            if (pg_numrows($resultado)>0){
                $arr = pg_fetch_row ($resultado, 0);
                $this->nombre = $arr[1];
                $this->apellido = $arr[2];
                $this->email = $arr[3];
                $this->telf = $arr[4];
                $this->id_nivel = $arr[5];
                $this->id_area = $arr[6];
                $this->passw = $arr[7];
                $this->estado = $arr[8];
                pg_FreeResult($resultado);
                $conec->cerrarConexion();
                return 1;
            }else{
                pg_FreeResult($resultado);
                $conec->cerrarConexion();
                return 1;//"El número de cedula ".$this->cedula.", no esta registrado.\nVerifique e intente de nuevo.";
            }
        }
    }

    // Actualizar los datos en la tabla ingenieros
    public function modificar(){
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

    public function setesquemaCoordinaciones($arg){
        $this->esquemaC = $arg;
    }

    public function getesquemaCoordinaciones(){
        return $this->esquemaC;
    }

    public function setesquemaNiveles($arg){
        $this->esquemaN = $arg;
    }

    public function getesquemaNiveles(){
        return $this->esquemaN;
    }

    public function setesquemaAreas($arg){
        $this->esquemaA = $arg;
    }

    public function getesquemaAreas(){
        return $this->esquemaA;
    }

    public function cmbCoordinaciones(){
        $consulta = "SELECT * FROM coordinacion ORDER BY id ASC";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Falló la consulta
        }

        $this->esquemaC = "<select name=\"cmbCoordinaciones\" id=\"cmbCoordinaciones\" onclick=\"xajax_lsAreas(document.getElementById('cmbCoordinaciones').value);\" >";
        $i = 0;
        while ($i < pg_numrows($resultado)){
            $arr = pg_fetch_row($resultado, $i);
            $this->esquemaC .= "<option value=".$arr[0].">".$arr[1]."</option>";
            $i++;
        }

        $this->esquemaC .= "</select>";
        pg_FreeResult($resultado);
        $conec->cerrarConexion();
        return 1;
    }

    public function cmbNiveles(){
        $consulta = "SELECT * FROM nivel ORDER BY id ASC";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Falló la consulta
        }

        $this->esquemaN = "<select name=\"cmbNivel\" id=\"cmbNivel\">";
        $i = 0;
        while ($i < pg_numrows($resultado)){
            $arr = pg_fetch_row($resultado, $i);
            $this->esquemaN .= "<option value=".$arr[0].">".$arr[1]."</option>";
            $i++;
        }

        $this->esquemaN .= "</select>";
        pg_FreeResult($resultado);
        $conec->cerrarConexion();
        return 1;
    }

    public function cmbAreas($arg){
        $consulta = "SELECT * FROM areas WHERE id_coordinacion='".$arg."' ORDER BY id ASC";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Falló la consulta
        }

        $this->esquemaA = "<select name=\"cmbAreas\" id=\"cmbAreas\">";
        $i = 0;
        while ($i < pg_numrows($resultado)){
            $arr = pg_fetch_row($resultado, $i);
            $this->esquemaA .= "<option value=".$arr[0].">".$arr[1]."</option>";
            $i++;
        }

        $this->esquemaA .= "</select>";
        pg_FreeResult($resultado);
        $conec->cerrarConexion();
        return 1;
    }

    public function ubicarCoordinacion($arg){
        $consulta = "SELECT * FROM areas WHERE id='".$arg."'";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Falló la consulta
        }

        if (pg_numrows($resultado)>0){
            $arr = pg_fetch_row($resultado, 0);
            return $arr[3];
        }else{
            return -2;
        }
    }
}
?>
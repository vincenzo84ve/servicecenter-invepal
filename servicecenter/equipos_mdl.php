<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of equipos_mdl
 *
 * @author vincenzo
 */

/*sección de include*/
require("conexion.php");
require_once("equipos_ctrl.php");

class Equipo {
    //put your code here

    var $id;
    var $marca;
    var $modelo;
    var $descripcion;
    var $nBien;
    var $html_lst;

    function __construct($id=1, $descripcion=null, $marca=null, $modelo=null, $nBien=null, $lst=null) {
        $this->id = $id;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->descripcion = $descripcion;
        $this->nBien = $nBien;
        $this->html_lst = $lst;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getNBien() {
        return $this->nBien;
    }

    public function setNBien($nBien) {
        $this->nBien = $nBien;
    }

    public function setLista($arg){
        $this->html_lst = $arg;
    }

    public function getLista(){
        return $this->html_lst;
    }

    public function listar(){
        $consulta = "SELECT * FROM equipos ORDER BY id ASC";

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
                $ls .= "<tr><td><b>ID</b></td><td><b>Descripci&oacute;n</b></td><td><b>Marca</b></td><td><b>Modelo</b></td><td><b>N° Bien:</b></td></tr>";
                while($i < $num){
                    $arr = pg_fetch_row ($resultado, $i);
                    $ls .= "<tr><td>".$arr[0]."</td><td>".$arr[1]."</td><td>".$arr[2]."</td><td>".$arr[3]."</td><td>".$arr[4]."</td><td><a href=\"equipos_vis_edit.php?id=".$arr[0]."\">Editar</a></td></tr>";
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

    function idEquipo(){// Incrementar el nivel del id generado
        $consulta = "SELECT id FROM equipos ORDER BY id DESC LIMIT 1";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1; // Error en la conexion!
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Error en la consulta
        }else{// Se ejecuto con éxito
            if (pg_numrows($resultado) > 0){
                $arr = pg_fetch_row ($resultado, 0);

                $this->id = $arr[0]+1;

                pg_FreeResult($resultado);
                $conec->cerrarConexion();
            }
            return 1;
        }
    }

    function guardar(){
        $consulta = "INSERT INTO equipos (id, descripcion, marca, modelo, bien) VALUES ('".$this->id."', '".$this->descripcion."', '".$this->marca."', '".$this->modelo."', '".$this->nBien."')";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;//Fallo la conexion
        }

        $resultado = pg_query($consulta);

        if (!$resultado) {
            return 0; //Fallo la consulta
        }else{
            pg_FreeResult($resultado);
            $conec->cerrarConexion();
            return 1; //Se ejecuto con éxito
        }
    }

    function buscar(){
        $consulta = "SELECT * FROM equipos WHERE id='".$this->id."'";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0;// Falló la consulta
        }else{
            $arr = pg_fetch_row ($resultado, 0);
            $this->descripcion = $arr[1];
            $this->marca = $arr[2];
            $this->modelo = $arr[3];
            $this->nBien = $arr[4];
            return 1;// Consulta exitosa
        }
    }

    function modificar(){
        $consulta = "UPDATE equipos SET descripcion='".$this->descripcion."', marca='".$this->marca."', modelo='".$this->modelo."', bien='".$this->nBien."' WHERE id='".$this->id."'";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0;// Falló la consulta
        }else{
            return 1;
        }
    }

}
?>

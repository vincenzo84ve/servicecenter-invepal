<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of area_mdl
 *
 * @author vincenzo
 */

/*sección de include*/
require("conexion.php");
require_once("area_ctrl.php");

class Area {
    var $id;
    var $nombre;
    var $ubicacion;
    var $id_coord;
    var $html_lst;

    function __construct($id=1, $nombre=null, $ubicacion=null, $id_coord=null, $lst=null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ubicacion = $ubicacion;
        $this->id_coord = $id_coord;
        $this->html_lst = $lst;
    }

    function __destruct(){
        // Liberar el objeto de la memoria
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    public function setLista($html_lst) {
        $this->html_lst = $html_lst;
    }

    function getLista(){
        return ($this->html_lst);
    }

    public function getId_coord() {
        return $this->id_coord;
    }

    public function setId_coord($id_coord) {
        $this->id_coord = $id_coord;
    }

    

    function guardar(){
        $consulta = "INSERT INTO area (id, nombre, ubicacion, id_coordinacion) VALUES ('".$this->id."', '".$this->nombre."', '".$this->ubicacion."', '".$this->id_coord."')";

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

    function idArea(){// Incrementar el nivel del id generado
        $consulta = "SELECT id FROM area ORDER BY id DESC LIMIT 1";

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

    function listar(){
        $consulta = "SELECT * FROM areas ORDER BY id ASC";

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
                $ls .= "<tr><td><b>Id</b></td><td><b>Nombre</b></td><td><b>Ubicaci&oacute;n</b></td><td><b>Coordinaci&oacute;n</b></td></tr>";
                while($i < $num){
                    $arr = pg_fetch_row ($resultado, $i);
                    $ls .= "<tr><td>".$arr[0]."</td><td>".$arr[1]."</td><td>".$arr[2]."</td><td>".$arr[3]."</td><td><a href=\"area_vis_edit.php?id=".$arr[0]."\">Editar</a></tr>";
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

    function buscar(){
        $consulta = "SELECT * FROM area WHERE id='".$this->id."'";

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
            $this->nombre = $arr[1];
            $this->ubicacion = $arr[2];
            return 1;// Consulta exitosa
        }
    }

    function modificar(){
        $consulta = "UPDATE area SET nombre='".$this->nombre."', ubicacion='".$this->ubicacion."' WHERE id='".$this->id."'";

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

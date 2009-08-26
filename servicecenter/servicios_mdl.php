<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of servicios_mdl
 *
 * @author vincenzo
 */

 /*sección de include*/
require("conexion.php");
require_once("servicios_ctrl.php");

class Servicio {
    //put your code here
    var $id;
    var $descripcion;
    var $html_lst;

    function __construct($id=1, $descripcion=null, $lst=null) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->html_lst = $lst;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setLista($arg){
        $this->html_lst = $arg;
    }

    public function getLista(){
        return $this->html_lst;
    }

    public function listar(){
        $consulta = "SELECT * FROM servicios ORDER BY id ASC";

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
                $ls .= "<tr><td><b>Id</b></td><td><b>Descripci&oacute;n</b></td><td></td></tr>";
                while($i < $num){
                    $arr = pg_fetch_row ($resultado, $i);
                    $ls .= "<tr><td>".$arr[0]."</td><td>".$arr[1]."</td><td><a href=\"servicios_vis_edit.php?id=".$arr[0]."\">Editar</a></td></tr>";
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

    function idServicio(){// Incrementar el nivel del id generado
        $consulta = "SELECT id FROM servicios ORDER BY id DESC LIMIT 1";

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
        $consulta = "INSERT INTO servicios (id, descripcion) VALUES ('".$this->id."', '".$this->descripcion."')";

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
        $consulta = "SELECT * FROM servicios WHERE id='".$this->id."'";

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
            return 1;// Consulta exitosa
        }
    }

    function modificar(){
        $consulta = "UPDATE servicios SET descripcion='".$this->descripcion."' WHERE id='".$this->id."'";

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

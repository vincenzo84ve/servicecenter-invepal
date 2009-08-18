<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nivel_class
 *
 * @author vincenzo
 */

 /*sección de include*/
require("conexion.php");
require_once("nivel_ctrl.php");

class Nivel {
    var $id;
    var $descripcion;
    var $html_lst;

    function __construct($id=1, $descrip=null, $lst=null){
        $this->id = $id;
        $this->descripcion = $descrip;
        $this->html_lst = $lst;
    }

    function __desctruct(){
        // Liberar el objeto de la memoria
    }

    function setId($arg){
        $this->id = $arg;
    }

    function setDescripcion($arg){
        $this->descripcion = $arg;
    }

    function setLista($arg){
        $this->html_lst = $arg;
    }

    function getId(){
        return ($this->id);
    }

    function getDescripcion(){
        return ($this->descripcion);
    }

    function getLista(){
        return ($this->html_lst);
    }

    function guardar(){
        $consulta = "INSERT INTO nivel (id, descripcion) VALUES ('".$this->id."', '".$this->descripcion."')";

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

    function idNivel(){// Incrementar el nivel del id generado
        $consulta = "SELECT id FROM nivel ORDER BY id DESC LIMIT 1";

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
        $consulta = "SELECT * FROM nivel ORDER BY id ASC";

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
                while($i < $num){
                    $arr = pg_fetch_row ($resultado, $i);
                    $ls .= "<tr><td>".$arr[0]."</td><td>".$arr[1]."</td><td><a href=\"nivel_vis_edit.php?id=".$arr[0]."\">Editar</a></tr>";
                    $i++;
                }
                $ls .= "</table>";
                $this->html_lst = $ls;
                pg_FreeResult($resultado);
                $conec->cerrarConexion();
            }
            return 1;// Se ejecuto satisfactoriamente
        }
    }

    function buscar(){
        $consulta = "SELECT * FROM nivel WHERE id='".$this->id."'";

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
        $consulta = "UPDATE nivel SET descripcion='".$this->descripcion."' WHERE id='".$this->id."'";

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

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of requerimientos_mdl
 *
 * @author vincenzo
 */

 /*sección de include*/
require ("conexion.php");
require ("requerimientos_ctrl.php");

class Requerimiento {
    //put your code here
    var $id;
    var $fecha;
    var $id_servicio;
    var $descripcion;
    var $fecha_ap;
    var $fecha_as;
    var $fecha_in;
    var $fecha_fi;
    var $id_equipo;
    var $diagnostico;
    var $solucion;
    var $documentacion;
    var $id_personal;
    var $html_lst;
    var $nomArea;
    var $nomCoor;
    var $nomPersonal;
    var $servicios;
    var $equipos;
    var $estado;
    var $mailCoordinador;
    var $nomCoordinador;

    function __construct($id=1, $fecha=null, $id_servicio=null, $descripcion=null, $fecha_ap=null, $fecha_as=null, $fecha_in=null, $fecha_fi=null, $id_equipo=null, $diagnostico=null, $solucion=null, $documentacion=null, $id_personal=null, $est=null, $lst=null, $mailC=null, $nomC=null) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->id_servicio = $id_servicio;
        $this->descripcion = $descripcion;
        $this->fecha_ap = $fecha_ap;
        $this->fecha_as = $fecha_as;
        $this->fecha_in = $fecha_in;
        $this->fecha_fi = $fecha_fi;
        $this->id_equipo = $id_equipo;
        $this->diagnostico = $diagnostico;
        $this->solucion = $solucion;
        $this->documentacion = $documentacion;
        $this->id_personal = $id_personal;
        $this->html_lst = $lst;
        $this->estado = $est;
        $this->mailCoordinador = $mailC;
        $this->nomCoordinador = $nomC;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getId_servicio() {
        return $this->id_servicio;
    }

    public function setId_servicio($id_servicio) {
        $this->id_servicio = $id_servicio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getFecha_ap() {
        return $this->fecha_ap;
    }

    public function setFecha_ap($fecha_ap) {
        $this->fecha_ap = $fecha_ap;
    }

    public function getFecha_as() {
        return $this->fecha_as;
    }

    public function setFecha_as($fecha_as) {
        $this->fecha_as = $fecha_as;
    }

    public function getFecha_in() {
        return $this->fecha_in;
    }

    public function setFecha_in($fecha_in) {
        $this->fecha_in = $fecha_in;
    }

    public function getFecha_fi() {
        return $this->fecha_fi;
    }

    public function setFecha_fi($fecha_fi) {
        $this->fecha_fi = $fecha_fi;
    }

    public function getId_equipo() {
        return $this->id_equipo;
    }

    public function setId_equipo($id_equipo) {
        $this->id_equipo = $id_equipo;
    }

    public function getDiagnostico() {
        return $this->diagnostico;
    }

    public function setDiagnostico($diagnostico) {
        $this->diagnostico = $diagnostico;
    }

    public function getSolucion() {
        return $this->solucion;
    }

    public function setSolucion($solucion) {
        $this->solucion = $solucion;
    }

    public function getDocumentacion() {
        return $this->documentacion;
    }

    public function setDocumentacion($documentacion) {
        $this->documentacion = $documentacion;
    }

    public function getId_personal() {
        return $this->id_personal;
    }

    public function setId_personal($id_personal) {
        $this->id_personal = $id_personal;
    }

    public function setLista($arg){
        $this->html_lst = $arg;
    }

    public function getLista(){
        return $this->html_lst;
    }

    public function setNomP($arg){
        $this->nomPersonal = $arg;
    }

    public function getNomP(){
        return $this->nomPersonal;
    }

    public function setArea($arg){
        $this->nomArea = $arg;
    }

    public function getArea(){
        return $this->nomArea;
    }

    public function setCoordinacion($arg){
        $this->nomCoor = $arg;
    }

    public function getCoordinacion(){
        return $this->nomCoor;
    }

    public function setServicios($arg){
        $this->servicios = $arg;
    }

    public function getServicios(){
        return $this->servicios;
    }

    public function setEquipos($arg){
        $this->equipos = $arg;
    }

    public function getEquipos(){
        return $this->equipos;
    }

    public function setEstado($arg){
        $this->estado = $arg;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setCorreoCoordinador($arg){
        $this->mailCoordinador = $arg;
    }

    public function getCorreoCoordinador(){
        return $this->mailCoordinador;
    }

    public function setNomCoordinador($arg){
        $this->nomCoordinador = $arg;
    }

    public function getNomCoordinador(){
        return $this->nomCoordinador;
    }

    public function listar(){
        $consulta = "SELECT * FROM requerimientos ORDER BY id ASC";

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
                $ls .= "<tr><td><b>ID</b></td><td><b>Fecha</b></td><td><b>Servicio</b></td><td><b>Personal</b></td><td><b>Area</b></td><td><b>Coordinaci&oacute;n</b></td><td><b>Estado</b></td></tr>";
                while($i < $num){
                    $arr = pg_fetch_row ($resultado, $i);
                    $consulta = "SELECT descripcion FROM servicios WHERE id='".$arr[2]."'";
                    $rS = pg_query($consulta);
                    $arrS = pg_fetch_row ($rS, 0);
                    $consulta = "SELECT nombe, apellido, id_area FROM personal WHERE id='".$arr[12]."'";
                    $rP = pg_query($consulta);
                    $arrP = pg_fetch_row($rP, 0);
                    $consulta = "SELECT nombre, id_coordinacion FROM areas WHERE id='".$arrP[2]."'";
                    $rA = pg_query($consulta);
                    $arrA = pg_fetch_row($rA, 0);
                    $consulta = "SELECT nombre FROM coordinacion WHERE id ='".$arrA[1]."'";
                    $rC = pg_query($consulta);
                    $arrC = pg_fetch_row($rC, 0);
                    $ls .= "<tr><td>".$arr[0]."</td><td>".$arrS[0]."</td><td>".$arrP[0]." ".$arrP[1]."</td><td>".$arrA[0]."</td><td>".$arrC[0]."</td><td><a href=\"equipos_vis_edit.php?id=".$arr[0]."\">Editar</a>&nbsp;<a href=\"equipos_vis_edit.php?id=".$arr[0]."\">Ver</a></td></tr>";
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

    function idRequerimiento(){// Incrementar el nivel del id generado
        $consulta = "SELECT id FROM requerimientos ORDER BY CAST(id as integer) DESC LIMIT 1";

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

    function Datos($arg){
        $consulta = "SELECT id, nombre, apellido, id_area FROM personal WHERE id='".$arg."'";

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
                $arr = pg_fetch_row ($resultado, 0);
                $this->id_personal = $arr[0];
                $this->nomPersonal = $arr[1]." ".$arr[2];
                $consulta = "SELECT nombre, id_coordinacion FROM areas WHERE id='".$arr[3]."'";
                $rA = pg_query($consulta);
                $arrA = pg_fetch_row($rA, 0);
                $this->nomArea = $arrA[0];
                $consulta = "SELECT nombre FROM coordinacion WHERE id ='".$arrA[1]."'";
                $rC = pg_query($consulta);
                $arrC = pg_fetch_row($rC, 0);
                $this->nomCoor = $arrC[0];
            }
            pg_FreeResult($resultado);
            $conec->cerrarConexion();
        }
            return 1;// Se ejecuto satisfactoriamente
    }

    function servicios(){
        $consulta = "SELECT * FROM servicios ORDER BY id ASC";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Falló la consulta
        }

        $this->servicios = "<select name=\"cmbServicios\" id=\"cmbServicios\">";
        $i = 0;
        while ($i < pg_numrows($resultado)){
            $arr = pg_fetch_row($resultado, $i);
            $this->servicios .= "<option value=".$arr[0].">".$arr[1]."</option>";
            $i++;
        }

        $this->servicios .= "</select>";
        pg_FreeResult($resultado);
        $conec->cerrarConexion();
        return 1;
    }

    function equipos(){
        $consulta = "SELECT * FROM equipos ORDER BY id ASC";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Falló la conexión
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0; // Falló la consulta
        }

        $this->equipos = "<select name=\"cmbEquipos\" id=\"cmbEquipos\">";
        $i = 0;
        while ($i < pg_numrows($resultado)){
            $arr = pg_fetch_row($resultado, $i);
            $this->equipos .= "<option value=".$arr[0].">".$arr[1]."</option>";
            $i++;
        }

        $this->equipos .= "</select>";
        pg_FreeResult($resultado);
        $conec->cerrarConexion();
        return 1;
    }

    function guardar(){
        $consulta = "INSERT INTO requerimientos (id, fecha, id_servicio, descripcion, id_equipo, id_personal, estado) VALUES ('".$this->id."', '".$this->fecha."', '".$this->id_servicio."', '".$this->descripcion."', '".$this->id_equipo."', '".$this->id_personal."', '".$this->estado."')";

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

    function correoCordinador(){
        // Selecciono el área a la cual pertenece el personal solicitante del requerimiento
        $consulta = "SELECT id_area FROM personal WHERE id='".$this->id_personal."'";

        $conec = new Conexion();

        $conec->conectar();

        if (!$conec->obtenerConexion()){
            return -1;// Error en la conexion
        }

        $resultado = pg_query($consulta);

        if (!$resultado){
            return 0;// Error en la consulta
        }else{
            $arr = pg_fetch_row($resultado, 0);

            $consulta = "SELECT correo, nombre, apellido FROM personal WHERE id_area='".$arr[0]."' and id_nivel='3'";

            $resultado = pg_query($consulta);

            if (pg_numrows($resultado)>0){
                $arr = pg_fetch_row($resultado, 0);

                $this->mailCoordinador = $arr[0];
                $this->nomCoordinador = $arr[1]." ".$arr[2];
            }
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
}
?>

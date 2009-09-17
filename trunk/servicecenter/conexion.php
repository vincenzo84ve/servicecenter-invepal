<?php
class Conexion{
    var $conexion_bd;

    function conectar(){// Conectar a la base de datos
        $this->conexion_bd = pg_connect("host=190.109.100.36 port=5432 dbname=scdat user=postgres password=invepal1nv3p4l") or die('No pudo conectarse: ' . pg_last_error());
//        $this->conexion_bd = pg_connect("host=localhost port=5432 dbname=scdat user=postgres password=l4v1rg3n") or die('No pudo conectarse: ' . pg_last_error());
        return ($this->conexion_bd);
    }

    function obtenerConexion(){// Obtener el resultado de la conexión
        return ($this->conexion_bd);
    }

    function cerrarConexion(){// Cerrar la conexión a la base de datos
        // Cerrar conexion
        pg_close($this->conexion_bd);
    }
}
?>
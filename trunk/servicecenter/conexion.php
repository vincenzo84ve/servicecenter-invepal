<?php
class Conexion{
    var $conexion_bd;

    function conectar(){// Conectar a la base de datos
        $this->conexion_bd = pg_connect("host=localhost port=5432 dbname=scdat user=conexion password=l4v1rg3n") or die('No pudo conectarse: ' . pg_last_error());
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
<?php


$conexion_bd = pg_connect("host=localhost port=5432 dbname=scdat user=conexion password=l4v1rg3n");

$consulta = "SELECT correo, nombre, apellido FROM personal WHERE id='16074351'";

$resultado = pg_query($consulta);

$arr = pg_fetch_row($resultado, 0);

$r = mail("vincenzo84ve@gmail.com", "Asunto", "PruebA arr<p><b>'".$arr[1]."' '".$arr[2]."'</b>");

if ($r){
    echo "Listo!";
}else{
    echo "Falló!";
}

?>

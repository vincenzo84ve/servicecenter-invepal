<?php

$id = $_GET['id'];

# Conexión a la base de datos
$link = pg_connect("host=190.109.100.36 user=postgres password=invepal1nv3p4l dbname=scdat") or die(pg_last_error($link));

$consulta ="select id, nombre, mime, size, coalesce(archivo_oid,-1) as archivo_oid from anexo_requerimientos where id='".$id."'";

$resultado = pg_query($link, $consulta);

# Inicia la transacción
pg_query($link, "begin");

# Recupera los atributos del archivo
$row=pg_fetch_array($resultado,0);
pg_free_result($resultado);

# Abre el objeto blob
$file=pg_lo_open($link, $row['archivo_oid'], "r");

# Envío de cabeceras
header("Cache-control: private");
header("Content-type: $row[mime]");
header("Content-Disposition: attachment; filename=\"$row[nombre]\"");
header("Content-length: $row[size]");
header("Expires: ".gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

# Imprime el contenido del objeto blob
pg_lo_read_all($file);
# Cierra el objeto
pg_lo_close($file);
# Compromete la transacción
pg_query($link, "commit");

pg_close($link);

?>

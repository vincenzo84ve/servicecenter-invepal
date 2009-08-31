<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
$conexion_bd = pg_connect("host=localhost port=5432 dbname=scdat user=conexion password=l4v1rg3n");

//Limito la busqueda
$TAMANO_PAGINA = 10;

//examino la página a mostrar y el inicio del registro a mostrar
$pagina = $_GET["pagina"];
if (!$pagina) {
    $inicio = 0;
    $pagina=1;
}
else {
    $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}

//miro a ver el número total de campos que hay en la tabla con esa búsqueda
$consulta = "SELECT * FROM requerimientos ORDER BY cast(id as integer) ASC";

$resultado = pg_query($consulta);

$num = pg_numrows($resultado);
//calculo el total de páginas
$total_paginas = ceil($num / $TAMANO_PAGINA);

//pongo el número de registros total, el tamaño de página y la página que se muestra
echo "N&uacute;mero de registros encontrados: " . $num . "<br>";
echo "Se muestran p&aacute;ginas de " . $TAMANO_PAGINA . " registros cada una<br>";
echo "Mostrando la p&aacute;gina " . $pagina . " de " . $total_paginas . "<p>";

$consulta = "SELECT * FROM requerimientos ORDER BY cast(id as integer) OFFSET ".$inicio." LIMIT ".$TAMANO_PAGINA."";

    $resultado = pg_query($consulta);

    $num = pg_numrows($resultado);
    if ($num > 0){
        $i = 0;
        echo "<table>";
        echo "<tr><td><b>ID</b></td><td><b>Fecha</b></td><td><b>Servicio</b></td><td><b>Personal</b></td><td><b>Area</b></td><td><b>Coordinaci&oacute;n</b></td><td><b>Estado</b></td></tr>";
        while($i < $num){
            $arr = pg_fetch_row ($resultado, $i);
            $consulta = "SELECT descripcion FROM servicios WHERE id='".$arr[2]."'";
            $rS = pg_query($consulta);
            $arrS = pg_fetch_row ($rS, 0);
            $consulta = "SELECT nombre, apellido, id_area FROM personal WHERE id='".$arr[13]."'";
            $rP = pg_query($consulta);
            $arrP = pg_fetch_row($rP, 0);
            $consulta = "SELECT nombre, id_coordinacion FROM areas WHERE id='".$arrP[2]."'";
            $rA = pg_query($consulta);
            $arrA = pg_fetch_row($rA, 0);
            $consulta = "SELECT nombre FROM coordinacion WHERE id='".$arrA[1]."'";
            $rC = pg_query($consulta);
            $arrC = pg_fetch_row($rC, 0);
            echo "<tr><td>".$arr[0]."</td><td>".$arr[1]."</td><td>".$arrS[0]."</td><td>".$arrP[0]." ".$arrP[1]."</td><td>".$arrA[0]."</td><td>".$arrC[0]."</td><td>".$arr[14]."</td><td><a href=\"requerimientos_vis_edit.php?id=".$arr[0]."\">Editar</a>&nbsp;<a href=\"requerimientos_vis_detalle.php?id=".$arr[0]."\">Ver</a></td></tr>";
            $i++;
        }
        echo "</table>";
        
        pg_FreeResult($resultado);
    }


//muestro los distintos índices de las páginas, si es que hay varias páginas
if ($total_paginas > 1){
    for ($i=1;$i<=$total_paginas;$i++){
       if ($pagina == $i)
          //si muestro el índice de la página actual, no coloco enlace
          echo $pagina. " ";
       else
          //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página
          echo "<a href='paginacion.php?pagina=" . $i . "&criterio=" . $txt_criterio . "'>" . $i . "</a> ";
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>

<?php
//Retomo la sesión
session_start();

//Verificamos si realmente existe la sesión
if (!isset($_SESSION["autentificado"])){
    //si no existe le mando otra vez a la portada
    include ("acceso.php");
}else{
    //en otro caso llamo al menu correspondiente
    include ("su.php");
}
?>

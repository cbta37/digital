<?php 

$archivo=$_GET["archivo"];


if(!preg_match('/^[A-Za-z0-9-]+\.pdf$/', $archivo)){
   echo "<p>Nombre de archivo invalido</p>";
   exit;
}
$path_pdf = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/libros/".$archivo;
$mi_pdf = fopen ("$path_pdf", "r");
if (!$mi_pdf) {
    echo "<p>No puedo abrir el archivo para lectura</p>";
    exit;
}

header('Content-type: application/pdf');


fpassthru($mi_pdf);  
fclose ($archivo);
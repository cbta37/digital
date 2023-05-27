<?php
  require_once "./modelos/vistasModelo.php";
  class vistasControlador extends vistasModelo{
    //controlador para obtener plantilla
    public function obtenerPlantillaControlador(){
      return require_once "./vistas/plantilla.php";
    }

    //controlador obtener vistas
    public function obtenerVistasControlador(){
      if(isset( $_GET['views'] )){
        $ruta = explode("/", $_GET['views']);
        $respuesta = vistasModelo::obtenerVistasModelo($ruta[0]);
      }else{
        $respuesta = "login";
      }
      return $respuesta;
    }

  }
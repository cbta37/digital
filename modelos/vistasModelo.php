<?php
  class vistasModelo{
    //modelo para obtener las vistas
    protected static function obtenerVistasModelo($vistas){      
      $lista_blanca = ["home", "book-list", "book-new", "book-search",
                      "book-update", "category-list", "category-new", "category-search", "category-update", "user-list", "user-new", "user-search","user-update", "student-book-search",
                      "student-category-search", "student-book-search-category"];
      if( in_array($vistas, $lista_blanca) ){
        if(is_file("./vistas/contenidos/".$vistas."-view.php")){
          $contenido = "./vistas/contenidos/".$vistas."-view.php";
        }else{
          $contenido = "404";
        }
      }elseif($vistas=="login" || $vistas == "index"){
        $contenido = "login";        
      }elseif($vistas=="register"){
        $contenido = "register";
      }else{
        $contenido = "404";
      }
      return $contenido;
    }
  }
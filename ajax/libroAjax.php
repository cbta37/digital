<?php
  $peticionAjax = true;
  require_once "../config/app.php";
  
  if(isset($_POST['book_titulo_reg']) || isset($_POST['libro_id_del']) || isset($_POST['libro_id_up'])){
    //instancia al controlador
    require_once "../controladores/libroControlador.php";
    $ins_libro = new libroControlador();

    //Agregar libro
    if(isset($_POST['book_titulo_reg']) || isset($_POST['book_desc_reg'])){
      echo $ins_libro->agregarLibroControlador();
    }

    //Eliminar libro
    if(isset($_POST['libro_id_del'])){
      echo $ins_libro->eliminarLibroControlador();
    }

    //actualizar un libro
    if(isset($_POST['libro_id_up'])){
      echo $ins_libro->actualizarLibroControlador();
    }  

    
  }else{
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
  }
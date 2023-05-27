<?php
  $peticionAjax = true;
  require_once "../config/app.php";
  
  if(isset($_POST['category_nombre_reg']) || isset($_POST['categoria_id_del']) || isset($_POST['categoria_id_up'])){
    //instancia al controlador
    require_once "../controladores/categoriaControlador.php";
    $ins_categoria = new categoriaControlador();

    //Agregar categoria
    if(isset($_POST['category_nombre_reg'])){
      echo $ins_categoria->agregarCategoriaControlador();
    }

    //Eliminar categoria
    if(isset($_POST['categoria_id_del'])){
      echo $ins_categoria->eliminarCategoriaControlador();
    }

    //Actualizar categoria
    if(isset($_POST['categoria_id_up'])){
      echo $ins_categoria->actualizarCategoriaControlador();
    }

    
  }else{
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
  }
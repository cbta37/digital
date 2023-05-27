<?php
  $peticionAjax = true;
  require_once "../config/app.php";
  
  if(isset($_POST['usuario_dni_reg']) || isset($_POST['usuario_id_del']) || isset($_POST['usuario_id_up'])){
    //instancia al controlador
    require_once "../controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();
    //agregar un usuario
    if(isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])){      
      echo $ins_usuario->agregarUsuarioControlador();
    }
    //eliminar un usuario
    if(isset($_POST['usuario_id_del'])){      
      echo $ins_usuario->eliminarUsuarioControlador();
    }
    //actualizar un usuario
    if(isset($_POST['usuario_id_up'])){
      echo $ins_usuario->actualizarUsuarioControlador();
    }
  }else{
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
  }
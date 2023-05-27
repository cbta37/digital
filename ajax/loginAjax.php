<?php
  $peticionAjax = true;
  require_once "../config/app.php";
  
  if(isset($_POST['token']) && isset($_POST['usuario'])){
    
    require_once "../controladores/loginControlador.php";
    $ins_login = new loginControlador();
    
    echo $ins_login->cerrarSesionControlador();
    
  }else{
    session_start(['name'=>'SPM']);
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
  }
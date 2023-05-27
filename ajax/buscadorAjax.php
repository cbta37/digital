<?php 
  session_start(['name'=>'SPM']);
  require_once "../config/app.php";

  if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda'])){
    $data_url = [
      "usuario"=>"user-search",
      "libro"=>"book-search",
      "categoria"=>"category-search"
    ];
    if(isset($_POST['modulo'])){
      $modulo = $_POST['modulo'];
      if(!isset($data_url[$modulo])){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No podemos continuar con la búsqueda debido a un error",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();        
      }      
    }else{
      $alerta = array(
        "alerta"=>"simple",
        "titulo"=>"Ocurrió un error inesperado",
        "texto"=>"No podemos continuar con la búsqueda debido a un error de configuración",
        "tipo"=>"error"
      );            
      echo json_encode($alerta);
      exit();
    }

    $name_var = "busqueda_".$modulo;
    //iniciar búsqueda
    if(isset($_POST['busqueda_inicial'])){
      if($_POST['busqueda_inicial']==""){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"Por favor introduce un término de búsqueda para empezar",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit(); 
      }
      $_SESSION[$name_var] = $_POST['busqueda_inicial'];
    }

    //eliminar búsqueda
    if(isset($_POST['eliminar_busqueda'])){
      unset($_SESSION[$name_var]);
    }

    //redireccionar
    $url = $data_url[$modulo];
    $alerta=[
      "alerta"=>"redireccionar",
      "url"=>SERVER_URL.$url."/"
    ];

    echo json_encode($alerta);

  }else{
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
    exit();
  }
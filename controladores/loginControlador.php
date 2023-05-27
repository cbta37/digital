<?php
  if( $peticionAjax ){
      require_once "../modelos/loginModelo.php";
  }else{
      require_once "./modelos/loginModelo.php";
  }

  class  loginControlador extends loginModelo{
    //controlador para iniciar sesión
    public function iniciarSesionControlador(){
      $usuario = mainModel::limpiarCadena($_POST['usuario_log']);
      $clave = mainModel::limpiarCadena($_POST['clave_log']);

      //comprobar campos vacíos
      if($usuario == "" || $clave == ""){
        echo '
        <script>
          Swal.fire({
            title: "Ocurrió un error inesperado",
            text: "No has llenado todos los campos que son requeridos",
            type: "error",
            confirmButtonText: "Aceptar",
          });
        </script>
        ';
        exit();
      }

      //verificar integridad de los datos
      if( mainModel::verificarDatos("[a-zA-Z0-9]{1,35}", $usuario) ){
        echo '
        <script>
          Swal.fire({
            title: "Ocurrió un error inesperado",
            text: "El NOMBRE DE USUARIO no coincide con el formato solicitado",
            type: "error",
            confirmButtonText: "Aceptar",
          });
        </script>
        ';
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave) ){     
        echo '
        <script>
          Swal.fire({
            title: "Ocurrió un error inesperado",
            text: "La CLAVE no coincide con el formato solicitado",
            type: "error",
            confirmButtonText: "Aceptar",
          });
        </script>
        ';
        exit();
      }

      $clave = mainModel::encryption($clave);

      $datos_login = [
        "Usuario"=>$usuario,
        "Clave"=>$clave
      ];

      $datos_cuenta = loginModelo::iniciarSesionModelo($datos_login);

      if($datos_cuenta->rowCount()==1){
        $row = $datos_cuenta->fetch();
        session_start(['name'=>'SPM']);
        $_SESSION['id_smp'] = $row['usuario_id'];
        $_SESSION['nombre_smp'] = $row['usuario_nombre'];
        $_SESSION['apellido_smp'] = $row['usuario_apellido'];
        $_SESSION['usuario_smp'] = $row['usuario_usuario'];
        $_SESSION['privilegio_smp'] = $row['usuario_privilegio'];
        $_SESSION['token_smp'] = md5( uniqid(mt_rand(), true) );

        return header("Location: ".SERVER_URL."home/");
      }else{
        echo '
        <script>
          Swal.fire({
            title: "Ocurrió un error inesperado",
            text: "USUARIO Y/O CLAVE incorrectos",
            type: "error",
            confirmButtonText: "Aceptar",
          });
        </script>
        ';
      }
    }

    //controldor para forzar cierre de sesión
    public function forzarCierreSesionControlador(){
      session_unset();
      session_destroy();
      if( headers_sent() ){
        return "<script>
          window.location.href='".SERVER_URL."login/';
        </script>";
      }else{
        return header("Location: ".SERVER_URL."login/");
      }
    }

    //Controlador cerrar la sesión
    public function cerrarSesionControlador(){
      session_start(['name'=>'SPM']);
      $token = mainModel::decryption($_POST['token']);
      $usuario = mainModel::decryption($_POST['usuario']);
      if( $token == $_SESSION['token_smp'] && $usuario == $_SESSION['usuario_smp'] ){
        session_unset();
        session_destroy();
        $alerta = [
          "alerta"=>"redireccionar",
          "url"=>SERVER_URL."login",
        ];
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se pudo cerrar la sesión en el sistema",
          "tipo"=>"error"
        );            
      }      
      echo json_encode($alerta);      
    }
  }
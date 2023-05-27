<?php
  if( $peticionAjax ){
      require_once "../modelos/usuarioModelo.php";
  }else{
      require_once "./modelos/usuarioModelo.php";
  }

  class  usuarioControlador extends usuarioModelo{
    //controlador agregar usuario
    public function agregarUsuarioControlador(){
      $dni = mainModel::limpiarCadena($_POST['usuario_dni_reg']);
      $nombre = mainModel::limpiarCadena($_POST['usuario_nombre_reg']);
      $apellido = mainModel::limpiarCadena($_POST['usuario_apellido_reg']);      

      if(!isset($_POST['register-student'])){
        $telefono = mainModel::limpiarCadena($_POST['usuario_telefono_reg']);
        $direccion = mainModel::limpiarCadena($_POST['usuario_direccion_reg']);    
        $email = mainModel::limpiarCadena($_POST['usuario_email_reg']);
        $privilegio = mainModel::limpiarCadena($_POST['usuario_privilegio_reg']);
      }else{
        $privilegio = 3;
        $telefono = "";
        $direccion= "";
        $email = "";
      } 
      
      $usuario = mainModel::limpiarCadena($_POST['usuario_usuario_reg']);
      $clave1 = mainModel::limpiarCadena($_POST['usuario_clave_1_reg']);
      $clave2 = mainModel::limpiarCadena($_POST['usuario_clave_2_reg']);

      
      if($dni == "" || $nombre == "" || $apellido == "" || $usuario == ""
          || $clave1 == "" || $clave2 == ""){                                  
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"campos vacíos",
              "tipo"=>"error"
            );            
            echo json_encode($alerta);
            exit();
      }

      //verificando integridad de los datos
      if( mainModel::verificarDatos("[0-9-]{1,20}", $dni) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La matrícula no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El NOMBRE no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El APELLIDO no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if($telefono!=""){
        if( mainModel::verificarDatos("[0-9()+]{8,20}", $telefono) ){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"El TELEFONO no coincide con el formato indicado",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }        
      }

      if($direccion!=""){
        if( mainModel::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion) ){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"La DIRECCIÓN no coincide con el formato indicado",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }
      }      

      if( mainModel::verificarDatos("[a-zA-Z0-9]{1,35}", $usuario) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El USUARIO no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave1) ||
          mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave2)){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"Las CONSTRASEÑAS no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //comprobando dni existe en la bd
      $check_dni = mainModel::ejecutarConsultaSimple("SELECT usuario_dni FROM usuario 
      WHERE usuario_dni='$dni'");

      if($check_dni->rowCount()>0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La matrícula ingresado ya se encuentra registrado en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //comprobando usuario existe en la bd
      $check_user = mainModel::ejecutarConsultaSimple("SELECT usuario_usuario FROM usuario 
      WHERE usuario_usuario='$usuario'");

      if($check_user->rowCount()>0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El USUARIO ingresado ya se encuentra registrado en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if($email != ""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          $check_email = mainModel::ejecutarConsultaSimple("SELECT usuario_email FROM usuario 
          WHERE usuario_email='$email'");

          if($check_user->rowCount()>0){
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"El EMAIL ingresado ya se encuentra registrado en el sistema",
              "tipo"=>"error"
            );            
            echo json_encode($alerta);
            exit();
          }
        }else{
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Has ingresado un EMAIL no válido",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }  
      }
      
      if($clave1 != $clave2){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"Las CONTRASEÑAS no coinciden",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }else{
        $clave = mainModel::encryption($clave1);
      }

      if($privilegio < 1 || $privilegio >3){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El PRIVILEGIO seleccionado no es válido",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      $datos_usuario_reg = [
        "DNI"=>$dni,
        "Nombre"=>$nombre,
        "Apellido"=>$apellido,
        "Telefono"=>$telefono,
        "Direccion"=>$direccion,
        "Email"=>$email,
        "Usuario"=>$usuario,
        "Clave"=>$clave,
        "Estado"=>"Activa",
        "Privilegio"=>$privilegio
      ];   

      $agregar_usuario = usuarioModelo::agregarUsuarioModelo($datos_usuario_reg);

      if($agregar_usuario->rowCount()==1){
        $alerta = array(
          "alerta"=>"limpiar",
          "titulo"=>"Usuario registrado",
          "texto"=>"Usuario registrado exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha podido registrar el usuario",
          "tipo"=>"error"
        );            
      }    
      echo json_encode($alerta);            
    }//fin controlador

    //controlador paginar usuario
    public function paginadorUsuarioControlador($pagina, $registros, $privilegio, $id, $url, $busqueda){
      $pagina = mainModel::limpiarCadena($pagina);
      $registros = mainModel::limpiarCadena($registros);
      $privilegio = mainModel::limpiarCadena($privilegio);
      $id = mainModel::limpiarCadena($id);

      $url = mainModel::limpiarCadena($url);
      $url = SERVER_URL.$url."/";      

      $busqueda = mainModel::limpiarCadena($busqueda);

      $tabla = "";

      $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
      $inicio = ($pagina > 0) ? (($pagina*$registros)-$registros) : 0;

      if(isset($busqueda) && $busqueda != ""){
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((usuario_id!='$id' AND usuario_id!='1') AND (usuario_dni LIKE '%$busqueda%' OR usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
      }else{
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE usuario_id!='$id' AND usuario_id!='1' ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
      }

      $conexion = mainModel::connectionBD();
      $datos = $conexion->query($consulta);
      $datos = $datos->fetchAll();

      $total = $conexion->query("SELECT FOUND_ROWS()");
      $total = (int) $total->fetchColumn();

      $Npaginas = ceil($total/$registros);

      $tabla.='<div class="table-responsive">
                <table class="table table-dark table-sm">
                  <thead>
                    <tr class="text-center roboto-medium">
                      <th>#</th>
                      <th>MATRICULA</th>
                      <th>NOMBRE</th>                      
                      <th>TELÉFONO</th>
                      <th>USUARIO</th>
                      <th>EMAIL</th>
                      <th>ACTUALIZAR</th>
                      <th>ELIMINAR</th>
                    </tr>
                  </thead>
                  <tbody>';

      if($total>=1 && $pagina <= $Npaginas){
        $contador = $inicio+1;
        $reg_inicio=$inicio+1;
        foreach($datos as $rows){
          $tabla.='<tr class="text-center" >
                    <td>'.$contador.'</td>
                    <td>'.$rows['usuario_dni'].'</td>
                    <td>'.$rows['usuario_nombre'].' '.$rows['usuario_apellido'].'</td>                    
                    <td>'.$rows['usuario_telefono'].'</td>
                    <td>'.$rows['usuario_usuario'].'</td>
                    <td>'.$rows['usuario_email'].'</td>
                    <td>
                      <a href="'.SERVER_URL.'user-update/'.mainModel::encryption($rows['usuario_id']).'/" class="btn btn-success">
                          <i class="fas fa-sync-alt"></i>	
                      </a>
                    </td>
                    <td>
                      <form class= "FormularioAjax" action="'.SERVER_URL.'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="usuario_id_del" value="'.mainModel::encryption($rows['usuario_id']).'">
                        <button type="submit" class="btn btn-warning">
                            <i class="far fa-trash-alt"></i>
                        </button>
                      </form>
                    </td>
                  </tr> ';
          $contador++;
        }
        $reg_final = $contador-1;
      }else{
        if($total>=1){
          $tabla.='<tr class="text-center" ><td colspan="9">
            <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga click acá para recargar el listado</a>
          </td></tr>';          
        }else{
          $tabla.='<tr class="text-center" ><td colspan="9">No hay registros en el sistema</td></tr>';          
        }
      }
      
      $tabla.='</tbody></table></div>';    
      
      if($total>=1 && $pagina <= $Npaginas){
        $tabla.='<p class="text-right">Mostrando usuarios '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
        $tabla.=mainModel::paginadorTablas($pagina, $Npaginas, $url, 7);
      }

      return $tabla;
    } //fin controlador
    
    //controlador eliminar usuario
    public function eliminarUsuarioControlador(){

      //recibiendo el id del usuario
      $id = mainModel::decryption($_POST['usuario_id_del']);
      $id = mainModel::limpiarCadena($id);

      //comprobando el usuario principal
      if( $id == 1){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No podemos eliminar el usuario principal del sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //comprobando el usuario en la bd
      $check_usuario = mainModel::ejecutarConsultaSimple("SELECT usuario_id FROM usuario WHERE usuario_id = '$id'");
      if($check_usuario->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El usuario que intenta eliminar no existe en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //comprobando privilegios
      session_start(['name'=>'SPM']);
      if($_SESSION['privilegio_smp']!=1){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No tienes los permisos necesarios para realizar esta operación",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      $eliminar_usuario = usuarioModelo::eliminarUsuarioModelo($id);

      if($eliminar_usuario->rowCount()==1){
        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Usuario eliminado",
          "texto"=>"Usuario eliminado exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha podido eliminar el usuario, por favor intente nuevamente",
          "tipo"=>"error"
        );            
      }    
      echo json_encode($alerta);


    }//fin controlador

    //controlador datos usuario
    public function datosUsuarioControlador($tipo, $id){
      $tipo = mainModel::limpiarCadena($tipo);
      $id = mainModel::decryption($id);
      $id = mainModel::limpiarCadena($id);

      return usuarioModelo::datosUsuarioModelo($tipo, $id);
    }//fin controlador

    //controlador actualizar usuario
    public function actualizarUsuarioControlador(){
      //recibiendo id
      $id = mainModel::decryption($_POST['usuario_id_up']);
      $id = mainModel::limpiarCadena($id);

      //comprobar el usuario en la bd
      $check_usuario = mainModel::ejecutarConsultaSimple("SELECT * FROM usuario WHERE usuario_id='$id'");
      if($check_usuario->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No hemos encontrado el usuario en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }else{
        $campos = $check_usuario->fetch();
      }

      $dni = mainModel::limpiarCadena($_POST['usuario_dni_up']);
      $nombre = mainModel::limpiarCadena($_POST['usuario_nombre_up']);
      $apellido = mainModel::limpiarCadena($_POST['usuario_apellido_up']);
      $telefono = mainModel::limpiarCadena($_POST['usuario_telefono_up']);
      $direccion = mainModel::limpiarCadena($_POST['usuario_direccion_up']);

      $usuario = mainModel::limpiarCadena($_POST['usuario_usuario_up']);
      $email = mainModel::limpiarCadena($_POST['usuario_email_up']);

      if(isset($_POST['usuario_estado_up'])){
        $estado = mainModel::limpiarCadena($_POST['usuario_estado_up']);
      }else{
        $estado = $campos['usuario_estado'];        
      }

      if(isset($_POST['usuario_privilegio_up'])){
        $privilegio = mainModel::limpiarCadena($_POST['usuario_privilegio_up']);
      }else{
        $privilegio = $campos['usuario_privilegio'];        
      }

      $admin_usuario = mainModel::limpiarCadena($_POST['usuario_admin']);
      $admin_clave = mainModel::limpiarCadena($_POST['clave_admin']);      

      $tipo_cuenta = mainModel::limpiarCadena($_POST['tipo_cuenta']);

      if($dni == "" || $nombre == "" || $apellido == "" || $usuario == ""
          || $admin_usuario == "" || $admin_clave == ""){                                  
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"campos vacíos",
              "tipo"=>"error"
            );            
            echo json_encode($alerta);
            exit();
      }

      //verificando integridad de los datos
      if( mainModel::verificarDatos("[0-9-]{1,20}", $dni) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La matrícula no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El NOMBRE no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El APELLIDO no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if($telefono!=""){
        if( mainModel::verificarDatos("[0-9()+]{8,20}", $telefono) ){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"El TELEFONO no coincide con el formato indicado",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }        
      }

      if($direccion!=""){
        if( mainModel::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $direccion) ){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"La DIRECCIÓN no coincide con el formato indicado",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }
      }      

      if( mainModel::verificarDatos("[a-zA-Z0-9]{1,35}", $usuario) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El USUARIO no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-Z0-9]{1,35}", $admin_usuario) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"Tu nombre de USUARIO no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if( mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $admin_clave) ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"Tu CLAVE no coincide con el formato indicado",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      $admin_clave = mainModel::encryption($admin_clave);

      if($privilegio<1 || $privilegio>3){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El privilegio no corresponde a un valor válido",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if($estado != 'Activa' && $estado != 'Deshabilitada'){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El estado de la cuenta no corresponde a un valor válido",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if($dni != $campos['usuario_dni']){

        //comprobando dni existe en la bd
        $check_dni = mainModel::ejecutarConsultaSimple("SELECT usuario_dni FROM usuario 
        WHERE usuario_dni='$dni'");
  
        if($check_dni->rowCount()>0){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"La matrícula ingresado ya se encuentra registrado en el sistema",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }
      }

      if($usuario != $campos['usuario_usuario']){
        //comprobando usuario existe en la bd
        $check_user = mainModel::ejecutarConsultaSimple("SELECT usuario_usuario FROM usuario 
        WHERE usuario_usuario='$usuario'");
  
        if($check_user->rowCount()>0){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"El USUARIO ingresado ya se encuentra registrado en el sistema",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }
      }

      //comprobar el email
      if($email!=$campos['usuario_email'] && $email != ""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          $check_email = mainModel::ejecutarConsultaSimple("SELECT usuario_email FROM usuario 
          WHERE usuario_email='$email'");
    
          if($check_email->rowCount()>0){
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"El CORREO ingresado ya se encuentra registrado en el sistema",
              "tipo"=>"error"
            );            
            echo json_encode($alerta);
            exit();
          }
        }else{
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"El formato del correo no es válido",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }
      }

      //comprobando claves
      if($_POST['usuario_clave_nueva_1'] != '' || $_POST['usuario_clave_nueva_2'] != ''){
        if($_POST['usuario_clave_nueva_1'] != $_POST['usuario_clave_nueva_2']){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Las nuevas contraseñas no coinciden",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }else{
          if(mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $_POST['usuario_clave_nueva_1'])
          || mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $_POST['usuario_clave_nueva_2'])){        
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"Las nuevas contraseñas no coinciden con el formato solicitado",
              "tipo"=>"error"
            );            
            echo json_encode($alerta);
            exit();
          }       
          $clave = mainModel::encryption($_POST['usuario_clave_nueva_1']);
        }
      }else{
        $clave = $campos['usuario_clave'];
      }

      //comprobando las credenciales para actualizar datos
      if($tipo_cuenta == "Propia"){
        $check_cuenta = mainModel::ejecutarConsultaSimple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_clave='$admin_clave' AND usuario_id='$id'");
      }else{
        session_start(['name'=>'SPM']);
        if($_SESSION['privilegio_smp']!=1){
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"No cuenta con los permisos necesarios para realizar esta acción",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        }
        $check_cuenta = mainModel::ejecutarConsultaSimple("SELECT usuario_id FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_clave='$admin_clave'");
      }

      if($check_cuenta->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"Nombre y/o clave de administrador no válidos",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //preparando datos para enviarlos al modelo
      $datos_usuario_up = [
        "DNI"=>$dni,
        "Nombre"=>$nombre,
        "Apellido"=>$apellido,
        "Telefono"=>$telefono,
        "Direccion"=>$direccion,
        "Email"=>$email,
        "Usuario"=>$usuario,
        "Clave"=>$clave,
        "Estado"=>$estado,
        "Privilegio"=>$privilegio,
        "ID"=>$id
      ];

      if(usuarioModelo::actualizarUsuarioModelo($datos_usuario_up)){
        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Datos actualizados",
          "texto"=>"Los datos han sido actualizados exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No hemos podido actualizar los datos, por favor intente nuevamente",
          "tipo"=>"error"
        );  
      }
      echo json_encode($alerta);
    }//fin controlador
  }
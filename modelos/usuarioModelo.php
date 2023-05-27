<?php
  require_once "mainModel.php";

  class usuarioModelo extends mainModel{
    //modelo agregar usuario
    protected static function agregarUsuarioModelo($datos){
      $sql = mainModel::connectionBD()->prepare(
        "INSERT INTO usuario(usuario_dni, usuario_nombre, usuario_apellido, usuario_telefono,
          usuario_direccion, usuario_email, usuario_usuario, usuario_clave, usuario_estado, 
          usuario_privilegio) VALUES(:DNI, :Nombre, :Apellido, :Telefono, :Direccion, :Email,
          :Usuario, :Clave, :Estado, :Privilegio)");

      $sql->bindParam( ":DNI", $datos['DNI'] );
      $sql->bindParam( ":Nombre", $datos['Nombre'] );
      $sql->bindParam( ":Apellido", $datos['Apellido'] );
      $sql->bindParam( ":Telefono", $datos['Telefono'] );
      $sql->bindParam( ":Direccion", $datos['Direccion'] );
      $sql->bindParam( ":Email", $datos['Email'] );
      $sql->bindParam( ":Usuario", $datos['Usuario'] );
      $sql->bindParam( ":Clave", $datos['Clave'] );
      $sql->bindParam( ":Estado", $datos['Estado'] );
      $sql->bindParam( ":Privilegio", $datos['Privilegio'] );

      $sql->execute();

      return $sql;
    }

    //modelo eliminar usuario
    protected static function eliminarUsuarioModelo($id){
      $sql = mainModel::connectionBD()->prepare("DELETE FROM usuario WHERE usuario_id=:ID");

      $sql->bindParam(":ID", $id);
      $sql->execute();

      return $sql;
    }

    //modelo datos usuario
    protected static function datosUsuarioModelo($tipo, $id){
      if($tipo == "Unico"){
        $sql = mainModel::connectionBD()->prepare("SELECT * FROM usuario WHERE usuario_id=:ID");
        $sql->bindParam(":ID", $id);
      }elseif($tipo == "Conteo"){
        $sql = mainModel::connectionBD()->prepare("SELECT usuario_id FROM usuario WHERE usuario_id!='1'");
      }
      
      $sql->execute();
      return $sql;
    }

    //modelo actualizar usuario
    protected static function actualizarUsuarioModelo($datos){
      $sql = mainModel::connectionBD()->prepare("UPDATE usuario SET usuario_dni=:DNI, usuario_nombre=:Nombre, usuario_apellido=:Apellido, usuario_telefono=:Telefono, usuario_direccion=:Direccion, usuario_email=:Email, usuario_usuario=:Usuario, usuario_clave=:Clave, usuario_estado=:Estado, usuario_privilegio=:Privilegio WHERE usuario_id=:ID");
      $sql->bindParam(":DNI", $datos['DNI']);
      $sql->bindParam(":Nombre", $datos['Nombre']);
      $sql->bindParam(":Apellido", $datos['Apellido']);
      $sql->bindParam(":Telefono", $datos['Telefono']);
      $sql->bindParam(":Direccion", $datos['Direccion']);
      $sql->bindParam(":Email", $datos['Email']);
      $sql->bindParam(":Usuario", $datos['Usuario']);
      $sql->bindParam(":Clave", $datos['Clave']);
      $sql->bindParam(":Estado", $datos['Estado']);
      $sql->bindParam(":Privilegio", $datos['Privilegio']);
      $sql->bindParam(":ID", $datos['ID']);
    
      $sql->execute();
      return $sql;
    }
  }
<?php
  require_once "mainModel.php";

  class loginModelo extends mainModel{
    //modelo para iniciar sesión
    protected static function iniciarSesionModelo($datos){
      $sql=mainModel::connectionBD()->prepare("SELECT * FROM usuario WHERE usuario_usuario =
       :Usuario AND usuario_clave=:Clave AND usuario_estado='Activa'");

      $sql->bindParam(":Usuario", $datos['Usuario']);
      $sql->bindParam(":Clave", $datos['Clave']);
      $sql->execute();

      return $sql;
    }
  }
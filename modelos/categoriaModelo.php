<?php
  require_once "mainModel.php";

  class categoriaModelo extends mainModel{    
    //modelo agregar categoría
    protected static function agregarCategoriaModelo($datos){
      $sql = mainModel::connectionBD()->prepare("INSERT INTO categorias(nombre_categoria) VALUES(:Nombre)");


      $sql->bindParam( ":Nombre", $datos['Nombre'] );

      $sql->execute();

      return $sql;
    }

    //modelo eliminar categoria
    protected static function eliminarCategoriaModelo($id){
      $sql = mainModel::connectionBD()->prepare("DELETE FROM categorias WHERE id_categoria=:ID");

      $sql->bindParam(":ID", $id);
      $sql->execute();

      return $sql;
    }

    //modelo datos categoria
    protected static function datosCategoriaModelo($tipo, $id){
      if($tipo == "Unico"){
        $sql = mainModel::connectionBD()->prepare("SELECT * FROM categorias WHERE id_categoria=:ID");
        $sql->bindParam(":ID", $id);
      }elseif($tipo == "Conteo"){
        $sql = mainModel::connectionBD()->prepare("SELECT * FROM categorias");
      }
      
      $sql->execute();
      return $sql;
    }

    //modelo actualizar libro
    protected static function actualizarCategoriaModelo($datos){
      $sql = mainModel::connectionBD()->prepare("UPDATE categorias SET nombre_categoria=:Nombre WHERE id_categoria=:ID");
      
      $sql->bindParam(":Nombre", $datos['Nombre']);
      $sql->bindParam(":ID", $datos['ID']);
    
      $sql->execute();
      return $sql;
    }
  }
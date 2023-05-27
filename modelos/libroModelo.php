<?php
  require_once "mainModel.php";

  class libroModelo extends mainModel{
    //modelo agregar libro
    protected static function agregarLibroModelo($datos){
      $sql = mainModel::connectionBD()->prepare("INSERT INTO libros(foto, nombre, descripcion, disponible, id_categoria, fecha_ingreso, archivo_pdf) VALUES(:Foto, :Nombre, :Descripcion, :Disponible, :CategoriaId, :FechaIngreso, :Archivopdf)");

      $sql->bindParam( ":Foto", $datos['Foto'] );
      $sql->bindParam( ":Nombre", $datos['Nombre'] );
      $sql->bindParam( ":Descripcion", $datos['Descripcion'] );
      $sql->bindParam( ":Disponible", $datos['Disponible'] );
      $sql->bindParam( ":CategoriaId", $datos['CategoriaId'] );
      $sql->bindParam( ":FechaIngreso", $datos['FechaIngreso'] );
      $sql->bindParam( ":Archivopdf", $datos['Archivopdf'] );

      $sql->execute();

      return $sql;
    }

    //modelo eliminar libro
    protected static function eliminarLibroModelo($id){
      $sql = mainModel::connectionBD()->prepare("DELETE FROM libros WHERE id_libro=:ID");

      $sql->bindParam(":ID", $id);
      $sql->execute();

      return $sql;
    }

    //modelo datos libro
    protected static function datosLibroModelo($tipo, $id){
      if($tipo == "Unico"){
        $sql = mainModel::connectionBD()->prepare("SELECT * FROM libros WHERE id_libro=:ID");
        $sql->bindParam(":ID", $id);
      }elseif($tipo == "Conteo"){
        $sql = mainModel::connectionBD()->prepare("SELECT id_libro FROM libros");
      }
      
      $sql->execute();
      return $sql;
    }

    //modelo actualizar libro
    protected static function actualizarLibroModelo($datos){
      $sql = mainModel::connectionBD()->prepare("UPDATE libros SET foto=:Foto, nombre=:Nombre, descripcion=:Descripcion, disponible=:Disponible, id_categoria=:Categoria, fecha_ingreso=:FechaIngreso, archivo_pdf=:Archivo WHERE id_libro=:ID");
      $sql->bindParam(":Foto", $datos['Foto']);
      $sql->bindParam(":Nombre", $datos['Nombre']);
      $sql->bindParam(":Descripcion", $datos['Descripcion']);
      $sql->bindParam(":Disponible", $datos['Disponible']);
      $sql->bindParam(":Categoria", $datos['Categoria']);
      $sql->bindParam(":FechaIngreso", $datos['FechaIngreso']);
      $sql->bindParam(":Archivo", $datos['Archivo']);      
      $sql->bindParam(":ID", $datos['ID']);
    
      $sql->execute();
      return $sql;
    }
  }
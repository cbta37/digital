<?php
  if( $peticionAjax ){
      require_once "../modelos/categoriaModelo.php";
  }else{
      require_once "./modelos/categoriaModelo.php";
  }

  class  categoriaControlador extends categoriaModelo{
    //controlador agregar categoría
    public function agregarCategoriaControlador(){      
      $nombre = mainModel::limpiarCadena($_POST['category_nombre_reg']);           
  
      if($nombre == ""){                                  
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"campos vacíos",
              "tipo"=>"error"
            );            
            echo json_encode($alerta);
            exit();
      }
      
      //verificamos si existe ya la categoría seleccionada en la bd
      $check_categoria = mainModel::ejecutarConsultaSimple("SELECT nombre_categoria FROM categorias 
          WHERE nombre_categoria='$nombre'");

      if($check_categoria->rowCount()>0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La categoría ya existe en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      $datos_categoria_reg = [        
        "Nombre"=>$nombre
      ];

      $agregar_categoria = categoriaModelo::agregarCategoriaModelo($datos_categoria_reg);

      if($agregar_categoria->rowCount()==1){        
        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Categoría registrada",
          "texto"=>"Categoría registrada exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha podido registrar la categoría",
          "tipo"=>"error"
        );            
      }

      echo json_encode($alerta);
        
    }//fin controlador

    //controlador paginador de categorías
    public function paginadorCategoriaControlador($pagina, $registros, $privilegio, $url, $busqueda){
      $pagina = mainModel::limpiarCadena($pagina);
      $registros = mainModel::limpiarCadena($registros);
      $privilegio = mainModel::limpiarCadena($privilegio);      

      $url = mainModel::limpiarCadena($url);
      $url = SERVER_URL.$url."/";      

      $busqueda = mainModel::limpiarCadena($busqueda);

      $tabla = "";

      $pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
      $inicio = ($pagina > 0) ? (($pagina*$registros)-$registros) : 0;

      if(isset($busqueda) && $busqueda != ""){
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM categorias WHERE nombre_categoria LIKE '%$busqueda%' ORDER BY nombre_categoria ASC LIMIT $inicio, $registros";
      }else{
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM categorias ORDER BY nombre_categoria ASC LIMIT $inicio, $registros";
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
                      <th>NOMBRE CATEGORÍA</th>
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
                    <td>'.$rows['nombre_categoria'].'</td>                                        
                    <td>
                      <a href="'.SERVER_URL.'category-update/'.mainModel::encryption($rows['id_categoria']).'/" class="btn btn-success">
                          <i class="fas fa-sync-alt"></i>	
                      </a>
                    </td>
                    <td>
                      <form class= "FormularioAjax" action="'.SERVER_URL.'ajax/categoriaAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="categoria_id_del" value="'.mainModel::encryption($rows['id_categoria']).'">
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
        $tabla.='<p class="text-right">Mostrando categorías '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
        $tabla.=mainModel::paginadorTablas($pagina, $Npaginas, $url, 7);
      }

      return $tabla;
    } //fin controlador

    //controlador eliminar categoria
    public function eliminarCategoriaControlador(){
      //recibiendo el id de la categoria
      $id = mainModel::decryption($_POST['categoria_id_del']);
      $id = mainModel::limpiarCadena($id);

      //comprobando la categoria en la bd
      $check_categoria = mainModel::ejecutarConsultaSimple("SELECT id_categoria FROM categorias WHERE id_categoria = '$id'");
      if($check_categoria->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La categoria que intenta eliminar no existe en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //verificamos que ningún libro esté registrado con esta categoría      
      $check_libro_categoria = mainModel::ejecutarConsultaSimple("SELECT id_categoria FROM libros WHERE id_categoria = '$id'");
      if($check_libro_categoria->rowCount()>0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se puede eliminar. Existen libros con esta categoría. Para eliminarla, no deberá contar con libros pertenecientes a esta categoría",
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

      $eliminar_categoria = categoriaModelo::eliminarCategoriaModelo($id);

      if($eliminar_categoria->rowCount()==1){
        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Categoria eliminada",
          "texto"=>"Categoria eliminada exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha podido eliminar la categoria, por favor intente nuevamente",
          "tipo"=>"error"
        );            
      }    
      echo json_encode($alerta);

    }//fin controlador

    //controlador datos categoria
    public function datosCategoriaControlador($tipo, $id){
      $tipo = mainModel::limpiarCadena($tipo);
      $id = mainModel::decryption($id);
      $id = mainModel::limpiarCadena($id);

      return categoriaModelo::datosCategoriaModelo($tipo, $id);
    }//fin controlador

    //controlador actualizar categoria
    public function actualizarCategoriaControlador(){      
      //recibiendo id
      $id = mainModel::decryption($_POST['categoria_id_up']);
      $id = mainModel::limpiarCadena($id);

      //comprobar la categoria en la bd
      $check_categoria = mainModel::ejecutarConsultaSimple("SELECT * FROM categorias WHERE id_categoria='$id'");
      if($check_categoria->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No hemos encontrado la categoria en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      $nombre = mainModel::limpiarCadena($_POST['categoria_nombre_up']);
      

      if($nombre == ""){                                  
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"campos vacíos",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }     

      //verificamos si existe la categoría seleccionada en la bd
      $check_categoria = mainModel::ejecutarConsultaSimple("SELECT id_categoria FROM categorias 
          WHERE id_categoria='$id'");

      if($check_categoria->rowCount()<1){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La categoría seleccionada no es válida",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //verificamos si existe ya la categoría seleccionada en la bd
      $check_categoria = mainModel::ejecutarConsultaSimple("SELECT nombre_categoria FROM categorias 
          WHERE nombre_categoria='$nombre' AND id_categoria!='$id'");

      if($check_categoria->rowCount()>0){
        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La categoría ya existe en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //preparando datos para enviarlos al modelo      
      $datos_categoria_up = [
        "Nombre"=>$nombre,
        "ID"=>$id
      ];

      if(categoriaModelo::actualizarCategoriaModelo($datos_categoria_up)){                          
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
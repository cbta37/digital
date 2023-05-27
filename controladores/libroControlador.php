<?php
  if( $peticionAjax ){
      require_once "../modelos/libroModelo.php";
  }else{
      require_once "./modelos/libroModelo.php";
  }

  class  libroControlador extends libroModelo{
    //controlador agregar libro
    public function agregarLibroControlador(){
      
      $titulo = mainModel::limpiarCadena($_POST['book_titulo_reg']);
      $desc = mainModel::limpiarCadena($_POST['book_desc_reg']);
      
      $fecha_ingreso = mainModel::limpiarCadena($_POST['ingreso_inicio_reg']);

      //variables para manipular y guardar la imagen
      $img = $_FILES['imagen'];
      $name = $img['name'];
      $fecha = date("YmdHis");
      $tmpName = $img['tmp_name'];

      //variables para manipular el archivo pdf}
      $pdf = $_FILES['archivo'];
      $namepdf = $pdf['name'];
      $fechapdf = date("YmdHis");
      $tmpNamepdf = $pdf['tmp_name'];

      
      if(isset($_POST['item_categoria_reg'])){
        $categoria = mainModel::limpiarCadena($_POST['item_categoria_reg']);
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha añadido ninguna categoría, por favor añada una",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      if($titulo == "" || $desc == "" || $fecha_ingreso == ""){                                  
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
          WHERE id_categoria='$categoria'");

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

      //validar formato fecha
      $fecha_valida = mainModel::verificarFecha($fecha_ingreso);
      if( $fecha_valida ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La fecha seleccionada no es válida",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }

      //verificamos el contenido de la imagen
      if (!empty($name)) {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $formatos_permitidos =  array('png', 'jpeg', 'jpg');        
        if (!in_array($extension, $formatos_permitidos)) {
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Archivo no permitido",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        } else {
            $imgNombre = $fecha . ".jpg";                        
            $destino = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/img/libros/" . $imgNombre;


        }
      }elseif(!empty($_POST['foto_actual']) && empty($name)) {
        $imgNombre = $_POST['foto_actual'];
      }else {
        $imgNombre = "logo.png";
      }

      //verificamos el contenido del archivo pdf
      if (!empty($namepdf)) {
        $extension = pathinfo($namepdf, PATHINFO_EXTENSION);
        $formatos_permitidos =  array('pdf');        
        if (!in_array($extension, $formatos_permitidos)) {
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Archivo no permitido",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        } else {
            $pdfNombre = $fechapdf . ".pdf";                        
            $destinopdf = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/libros/" . $pdfNombre;
        }
      }elseif(!empty($_POST['archivo_actual']) && empty($namepdf)) {
        $pdfNombre = $_POST['archivo_actual'];
      }else {
        $pdfNombre = "";
      }

      $disp = "si";
      if($pdfNombre == ""){
        $disp = "no";
      }

      $datos_libro_reg = [
        "Foto"=>$imgNombre,
        "Nombre"=>$titulo,
        "Descripcion"=>$desc,
        "Disponible"=>$disp,
        "CategoriaId"=>$categoria,
        "FechaIngreso"=>$fecha_ingreso,
        "Archivopdf"=>$pdfNombre
      ];

      $agregar_libro = libroModelo::agregarLibroModelo($datos_libro_reg);

      if($agregar_libro->rowCount()==1){
        if (!empty($name)) {
          move_uploaded_file($tmpName, $destino);
           //Comprimos el fichero
        }
        if (!empty($namepdf)) {
          move_uploaded_file($tmpNamepdf, $destinopdf);
        }
        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Libro registrado",
          "texto"=>"Libro registrado exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha podido registrar el libro",
          "tipo"=>"error"
        );            
      }

      echo json_encode($alerta);
        
    }//fin controlador

    //buscador libros para los estudiantes
    public function buscarLibroControlador($busqueda, $category){
      if(isset($busqueda) && $busqueda != ""){      
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libros WHERE nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' OR fecha_ingreso LIKE '%$busqueda%' ORDER BY nombre ASC";
        if($category != ""){
          $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libros WHERE ((id_categoria='$category') AND (nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' OR fecha_ingreso LIKE '%$busqueda%')) ORDER BY nombre ASC";
        }
      }else{        
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libros ORDER BY nombre ASC";
        if($category != ""){
          $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libros WHERE id_categoria='$category' ORDER BY nombre ASC";        
        }        
      }

      

      $conexion = mainModel::connectionBD();
      $datos = $conexion->query($consulta);
      $datos = $datos->fetchAll();
      $total = $conexion->query("SELECT FOUND_ROWS()");
      $total = (int) $total->fetchColumn();

      $libros_encontrados="";
      if( $total >= 1 ){
        foreach($datos as $rows){
          if($rows['disponible']=="si"){
            $libros_encontrados.='
            <div style="min-width: 240px; max-width: 300px; min-height: 250px;" class="col-lg-3 col-md-4 col-sm-6 mb-2">
              <div class="service-box green" style="background: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), no-repeat center url('.SERVER_URL.'vistas/assets/img/libros/'.$rows["foto"].'); background-size: cover">                        
                  <p class="text-white font-weight-bold text-uppercase">'.$rows['nombre'].'</p>
                  <p class="text-white font-italic">'.$rows['descripcion'].'</p>
                  <div id="accordion">
                    <div class="card">                      
                      <div id="desc'.$rows['id_libro'].'" class="collapse font-weight-bold font-italic" aria-labelledby="headingOne" data-parent="#accordion"><div class="card-body">'.$rows['descripcion'].'</div></div>
                    </div>
                  </div>
                <a href="'.SERVER_URL.'vistas/contenidos/archivo-pdf.php?archivo='.$rows['archivo_pdf'].'" class="read-more" target="_blank"><span>Ver y Descargar</span> <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>';
          }
        }
      }else{
        $libros_encontrados.='<h3>Ningún Libro Encontrado</h3>';
      }

      return $libros_encontrados;
    }

    //controlador paginador de libros
    public function paginadorLibroControlador($pagina, $registros, $privilegio, $url, $busqueda){
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
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libros WHERE nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' OR fecha_ingreso LIKE '%$busqueda%' ORDER BY nombre ASC LIMIT $inicio, $registros";
      }else{
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM libros ORDER BY nombre ASC LIMIT $inicio, $registros";
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
                      <th>FOTO</th>
                      <th>NOMBRE</th>                      
                      <th>DESCRIPCIÓN</th>
                      <th>DISPONIBLE</th>
                      <th>CATEGORÍA</th>
                      <th>FECHA INGRESO</th>
                      <th>ARCHIVO PDF</th>
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
                    <td>
                      <img src="'.SERVER_URL.'vistas/assets/img/libros/'.$rows['foto'].'" width="50" height="50">
                    </td>
                    <td>'.$rows['nombre'].'</td>                    
                    <td>'.$rows['descripcion'].'</td>
                    <td>'.$rows['disponible'].'</td>
                    <td>'.$rows['id_categoria'].'</td>
                    <td>'.$rows['fecha_ingreso'].'</td>
                    <td>';
                      if($rows['disponible']=="si"){
                        $tabla.='<button class="btn btn-warning"><a href="'.SERVER_URL.'vistas/contenidos/archivo-pdf.php?archivo='.$rows['archivo_pdf'].'" target="_blank" ><b>Ver</b></a></button>';
                      }
                      $tabla.='</td>
                    <td>
                      <a href="'.SERVER_URL.'book-update/'.mainModel::encryption($rows['id_libro']).'/" class="btn btn-success">
                          <i class="fas fa-sync-alt"></i>	
                      </a>
                    </td>
                    <td>
                      <form class= "FormularioAjax" action="'.SERVER_URL.'ajax/libroAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="libro_id_del" value="'.mainModel::encryption($rows['id_libro']).'">
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
        $tabla.='<p class="text-right">Mostrando libros '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
        $tabla.=mainModel::paginadorTablas($pagina, $Npaginas, $url, 7);
      }

      return $tabla;
    } //fin controlador

    //controlador eliminar libro
    public function eliminarLibroControlador(){
      //recibiendo el id del libro
      $id = mainModel::decryption($_POST['libro_id_del']);
      $id = mainModel::limpiarCadena($id);

      //comprobando el libro en la bd
      $check_libro = mainModel::ejecutarConsultaSimple("SELECT id_libro, foto, archivo_pdf, disponible FROM libros WHERE id_libro = '$id'");
      if($check_libro->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"El libro que intenta eliminar no existe en el sistema",
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

      $eliminar_libro = libroModelo::eliminarLibroModelo($id);

      if($eliminar_libro->rowCount()==1){
        //eliminamos la imágen del libro del servidor
        $libro = $check_libro->fetch();

        if($libro['foto'] != 'logo.png'){
          $ruta_img = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/img/libros/".$libro['foto'];
          If(unlink($ruta_img)){
          }else {
            // there was a problem deleting the file 
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"No se ha podido eliminar el libro, por favor intente nuevamente",
              "tipo"=>"error"
            );            
          }
        }

        if($libro['disponible'] == "si"){
          $ruta_pdf = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/libros/".$libro['archivo_pdf'];
          If(unlink($ruta_pdf)) {
            // file was successfully deleted 
          } else {
            // there was a problem deleting the file 
            $alerta = array(
              "alerta"=>"simple",
              "titulo"=>"Ocurrió un error inesperado",
              "texto"=>"No se ha podido eliminar el libro, por favor intente nuevamente",
              "tipo"=>"error"
            );            
          }
        }        

        $alerta = array(
          "alerta"=>"recargar",
          "titulo"=>"Libro eliminado",
          "texto"=>"Libro eliminado exitosamente",
          "tipo"=>"success"
        );
      }else{
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No se ha podido eliminar el libro, por favor intente nuevamente",
          "tipo"=>"error"
        );            
      }    
      echo json_encode($alerta);

    }//fin controlador

    //controlador datos libros
    public function datosLibroControlador($tipo, $id){
      $tipo = mainModel::limpiarCadena($tipo);
      $id = mainModel::decryption($id);
      $id = mainModel::limpiarCadena($id);

      return libroModelo::datosLibroModelo($tipo, $id);
    }//fin controlador  

    //controlador actualizar libro
    public function actualizarLibroControlador(){
      
      //recibiendo id
      $id = mainModel::decryption($_POST['libro_id_up']);
      $id = mainModel::limpiarCadena($id);

      //comprobar el libro en la bd
      $check_libro = mainModel::ejecutarConsultaSimple("SELECT * FROM libros WHERE id_libro='$id'");
      if($check_libro->rowCount()<=0){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"No hemos encontrado el libro en el sistema",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }else{
        $campos = $check_libro->fetch();
      }

      $titulo = mainModel::limpiarCadena($_POST['book_titulo_up']);
      $desc = mainModel::limpiarCadena($_POST['book_desc_up']);      
      $fecha_ingreso = mainModel::limpiarCadena($_POST['ingreso_inicio_up']);
      $categoria = mainModel::limpiarCadena($_POST['item_categoria_reg']);


      if($titulo == "" || $desc == "" || $fecha_ingreso == ""){                                  
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
          WHERE id_categoria='$categoria'");

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

      //validar formato fecha
      $fecha_valida = mainModel::verificarFecha($fecha_ingreso);
      if( $fecha_valida ){
        $alerta = array(
          "alerta"=>"simple",
          "titulo"=>"Ocurrió un error inesperado",
          "texto"=>"La fecha seleccionada no es válida",
          "tipo"=>"error"
        );            
        echo json_encode($alerta);
        exit();
      }      

      //variables para manipular y guardar la imagen
      $img = $_FILES['imagen'];
      $name = $img['name'];
      $fecha = date("YmdHis");
      $tmpName = $img['tmp_name'];

      $nochange = false;
      
      if (!empty($name)) {        
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $formatos_permitidos =  array('png', 'jpeg', 'jpg');        
        if (!in_array($extension, $formatos_permitidos)) {
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Archivo no permitido",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        } else {
            $imgNombre = $fecha . ".jpg";                        
            $destino = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/img/libros/" . $imgNombre;
        }
      }elseif(!empty($_POST['foto_actual']) && empty($name)) {        
        $imgNombre = $_POST['foto_actual'];
      }else {
        $imgNombre = "logo.png";      
      }

      if ($campos['foto'] != 'logo.png' && $campos['foto'] != $imgNombre) {
          $destino = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/img/libros/";
          if (file_exists($destino . $campos['foto'])) {
              unlink($destino . $campos['foto']);
              $destino.=$imgNombre;
          }          
      }
                  
      //variables para manipular el archivo pdf}
      $pdf = $_FILES['archivo'];
      $namepdf = $pdf['name'];
      $fechapdf = date("YmdHis");
      $tmpNamepdf = $pdf['tmp_name'];

      //verificamos el contenido del archivo pdf
      if (!empty($namepdf)) {
        $extension = pathinfo($namepdf, PATHINFO_EXTENSION);
        $formatos_permitidos =  array('pdf');        
        if (!in_array($extension, $formatos_permitidos)) {
          $alerta = array(
            "alerta"=>"simple",
            "titulo"=>"Ocurrió un error inesperado",
            "texto"=>"Archivo no permitido",
            "tipo"=>"error"
          );            
          echo json_encode($alerta);
          exit();
        } else {
            $pdfNombre = $fechapdf . ".pdf";                        
            $destinopdf = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/libros/" . $pdfNombre;
        }
      }elseif(!empty($_POST['archivo_actual']) && empty($namepdf)) {
        $pdfNombre = $_POST['archivo_actual'];        
      }else {       
        $pdfNombre = "";        
      }

      if ($campos['archivo_pdf'] != '' && $campos['archivo_pdf'] != $pdfNombre) {
        $destinopdf = $_SERVER["DOCUMENT_ROOT"]."/digital/vistas/assets/libros/";
        if (file_exists($destinopdf . $campos['archivo_pdf'])) {
            unlink($destinopdf . $campos['archivo_pdf']);
            $destinopdf.=$pdfNombre;
        }

      }

      $disp = "si";
      if($pdfNombre == ""){
        $disp = "no";
      }      

      //preparando datos para enviarlos al modelo      
      $datos_libro_up = [
        "Foto"=>$imgNombre,
        "Nombre"=>$titulo,
        "Descripcion"=>$desc,
        "Disponible"=>$disp,
        "Categoria"=>$categoria,
        "FechaIngreso"=>$fecha_ingreso,
        "Archivo"=>$pdfNombre,
        "ID"=>$id
      ];

      if(libroModelo::actualizarLibroModelo($datos_libro_up)){                  
        
        if(!empty($name)){   
          move_uploaded_file($tmpName, $destino);     
         
        }
        
        if (!empty($namepdf)) {
          move_uploaded_file($tmpNamepdf, $destinopdf);
        }
        
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

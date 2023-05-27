<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fab fa-dashcube fa-fw"></i> &nbsp; Listado de libros por categoría
    <?php 
      $action = SERVER_URL."student-book-search-category/";
      $categoria = "";
      if(isset($pagina[1]) && $pagina[1] != ""){
        $categoria = $pagina[1];
        $action = SERVER_URL."student-book-search-category/".$categoria;
      }else{
        header("Location: ".SERVER_URL."student-category-search/");
          exit();
      }
      ?>
  </h3>
</div>

<div class="container-fluid">
  <form class= "form-neon" action="<?php echo $action ?>" method="POST" data-form="default" autocomplete="off">      
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-8 col-sm-6">
            <div class="form-group">
              <label for="inputSearch" class="bmd-label-floating">Buscar libro</label>
              <input type="text" class="form-control" name="libro_nombre_search" id="inputSearch" maxlength="30" required="">
            </div>
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-raised btn-info mr-2" style="height: 40px;"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
            <a href="<?php echo $action ?>" class="btn btn-raised btn-info" style="height: 40px;"><i class="fas fa-search"></i> &nbsp; VER TODO</a>            
          </div>          
        </div>
        </div>
      </div>
  </form>
</div>

<div class="container fluid">  
  <div class="booksearch row gy-4">
  <?php
    require_once "./controladores/libroControlador.php";

    $busqueda = "";
    if(isset($_POST['libro_nombre_search'])){
      $busqueda = $_POST['libro_nombre_search'];
    }
    
    $ins_libro = new libroControlador();
    echo $ins_libro->buscarlibroControlador($busqueda, $categoria);

  ?>
  </div>
</div>

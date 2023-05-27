<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fab fa-dashcube fa-fw"></i> &nbsp; Libros por categoría
  </h3>
</div>

<div class="container fluid">  
  <div class="booksearch row gy-4">
    <?php
      require_once "./controladores/categoriaControlador.php";
      $ins_categoria = new categoriaControlador();
      $categorias = $ins_categoria->datosCategoriaControlador("Conteo",0);
      if($categorias->rowCount() >= 1){
        $categorias = $categorias->fetchAll(); 
        foreach($categorias as $rows){       
    ?>    
        <div style="min-width: 240px; max-width: 300px" class="col-lg-3 col-md-4 col-sm-6 mb-1">
          <div class="service-box green">
              <p class="font-weight-bold text-uppercase"><?php echo $rows['nombre_categoria'] ?></p>
              <a href="<?php echo SERVER_URL; ?>student-book-search-category/<?php echo $rows['id_categoria'] ?>/" class="read-more"><span>Ver Libros</span> <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
    <?php } }else{ ?>
      <h3>No hay Categorías aún</h3>
    <?php }?>
  </div>
</div>
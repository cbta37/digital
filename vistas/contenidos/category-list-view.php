<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
      <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CATEGORÍAS
  </h3>  
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
      <li>
          <a href="<?php echo SERVER_URL; ?>category-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CATEGORÍA</a>
      </li>
      <li>
          <a class="active" href="<?php echo SERVER_URL; ?>category-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CATEGORÍAS</a>
      </li> 
      <li>
        <a href="<?php echo SERVER_URL; ?>category-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CATEGORÍA</a>
      </li>   
      
  </ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
  <?php
    require_once "./controladores/categoriaControlador.php";
    
    $ins_categoria = new categoriaControlador();
    echo $ins_categoria->paginadorCategoriaControlador($pagina[1], 10, $_SESSION['privilegio_smp'], $pagina[0], "");
  ?>
</div>
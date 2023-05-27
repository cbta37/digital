<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE LIBROS
  </h3>  
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?php echo SERVER_URL; ?>book-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR LIBRO</a>
    </li>
    <li>
      <a class="active" href="<?php echo SERVER_URL; ?>book-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE LIBROS</a>
    </li>
    <li>
      <a href="<?php echo SERVER_URL; ?>book-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR LIBRO</a>
    </li>
  </ul>	
</div>

<!-- Content here-->
<div class="container-fluid">
  <?php
    require_once "./controladores/libroControlador.php";
    
    $ins_libro = new libroControlador();
    echo $ins_libro->paginadorLibroControlador($pagina[1], 10, $_SESSION['privilegio_smp'], $pagina[0], "");
  ?>
</div>
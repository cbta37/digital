<!-- Page header -->

<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>

<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
  </h3>  
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?php echo SERVER_URL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
    </li>
    <li>
      <a class="active" href="<?php echo SERVER_URL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
    </li>
    <li>
      <a href="<?php echo SERVER_URL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
    </li>
  </ul>	
</div>

<!-- Content -->
<div class="container-fluid">                 
  <?php
    require_once "./controladores/usuarioControlador.php";
    
    $ins_usuario = new usuarioControlador();
    echo $ins_usuario->paginadorUsuarioControlador($pagina[1], 10, $_SESSION['privilegio_smp'], $_SESSION['id_smp'], $pagina[0], "");

  ?>
</div>
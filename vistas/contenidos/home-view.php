<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fab fa-dashcube fa-fw"></i> &nbsp; Bienvenido a la BIBLIOTECA DIGITAL CBTA 37
  </h3>
</div>

<!-- Content -->
<div class="full-box tile-container">
  <?php if( $_SESSION['privilegio_smp'] == 1 ){
    require_once "./controladores/libroControlador.php";
    $ins_libros = new libroControlador();
    $total_libros = $ins_libros->datosLibroControlador("Conteo",0);
  ?>  
    <a href="<?php echo SERVER_URL; ?>book-list/" class="tile">
      <div class="tile-tittle">Libros</div>
      <div class="tile-icon">
        <i class="fas fa-book fa-fw"></i>
        <p><?php echo $total_libros->rowCount(); ?> registrados</p>
      </div>
    </a>
  
    <?php } ?>

  <?php if( $_SESSION['privilegio_smp'] == 1 ){
    require_once "./controladores/categoriaControlador.php";
    $ins_categorias = new categoriaControlador();
    $total_categorias = $ins_categorias->datosCategoriaControlador("Conteo",0);
  ?>
  <a href="<?php echo SERVER_URL; ?>category-list/" class="tile">
    <div class="tile-tittle">Categorías</div>
    <div class="tile-icon">
      <i class="fa fa-fw fa-list-ol"></i>
      <p><?php echo $total_categorias->rowCount(); ?> Registradas</p>
    </div>
  </a>
  <?php } ?>

  <?php if( $_SESSION['privilegio_smp'] == 1 ){
    require_once "./controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();
    $total_usuarios = $ins_usuario->datosUsuarioControlador("Conteo",0);
  ?>

  <a href="<?php echo SERVER_URL; ?>user-list/" class="tile">
    <div class="tile-tittle">Usuarios</div>
    <div class="tile-icon">
      <i class="fas fa-user-secret fa-fw"></i>
      <p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
    </div>
  </a>
  
  <?php } ?>
  <a href="<?php echo SERVER_URL."user-update/".$lc->encryption($_SESSION['id_smp'])."/"; ?>" class="tile">
    <div class="tile-tittle">Mi Perfil</div>
    <div class="tile-icon">
      <i class="fas fa-user fa-fw"></i>
      <p>Ver</p>
    </div>
  </a>

  <?php if( $_SESSION['privilegio_smp'] == 3 ){ ?>
    <a href="<?php echo SERVER_URL; ?>student-book-search/" class="tile">
        <div class="tile-tittle">Libros</div>
        <div class="tile-icon">
          <i class="fas fa-book fa-fw"></i>
          <p>Ver más</p>
        </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>student-category-search/" class="tile">
        <div class="tile-tittle">Categorías</div>
        <div class="tile-icon">
          <i class="fas fa-book fa-fw"></i>
          <p>Ver más</p>
        </div>
    </a>
  <?php } ?>

</div>
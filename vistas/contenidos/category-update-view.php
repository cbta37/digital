<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
      <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ITEM
  </h3>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
  <li>
          <a class="active" href="<?php echo SERVER_URL; ?>category-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CATEGORÍA</a>
      </li>
      <li>
          <a href="<?php echo SERVER_URL; ?>category-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CATEGORÍAS</a>
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
    $datos_categoria = $ins_categoria->datosCategoriaControlador("Unico", $pagina[1]);
    if($datos_categoria->rowCount()==1){
      $campos=$datos_categoria->fetch();
  ?>
  <form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/categoriaAjax.php" method="POST" data-form="update" autocomplete="off">
    <input type="hidden" name="categoria_id_up" value="<?php echo $pagina[1] ?>">
    <fieldset>
    <legend><i class="far fa-plus-square"></i> &nbsp; Información de la categoría</legend>
    <div class="container-fluid">
    <div class="row">  
      <div class="col-12 col-md-6">
        <div class="form-group">
          <label for="categoria_nombre" class="bmd-label-floating">Nombre categoría</label>
          <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="categoria_nombre_up" id="categoria_nombre" maxlength="140" value="<?php echo $campos['nombre_categoria'] ?>">
        </div>
      </div>
    </div>
    </div>
    </fieldset>
    
    <p class="text-center" style="margin-top: 40px;">
    <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
    </p>
  </form>

<?php }else{
  ?>

  <div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
    <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
  </div>
  <?php } ?>
</div>
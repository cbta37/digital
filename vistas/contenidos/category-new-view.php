<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
      <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CATEGORÍA
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
<form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/categoriaAjax.php" method="POST" data-form="save" autocomplete="off">
<fieldset>
<legend><i class="far fa-plus-square"></i> &nbsp; Información del la categoría</legend>
<div class="container-fluid">
<div class="row">    
  <div class="col-12 col-md-6">
    <div class="form-group">
      <label for="category_nombre" class="bmd-label-floating">Nombre categoría</label>
      <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="category_nombre_reg" id="category_nombre" maxlength="140" required="">
    </div>
  </div>  
</div>
</div>
</fieldset>
<br><br><br>
<p class="text-center" style="margin-top: 40px;">
<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
&nbsp; &nbsp;
<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
</p>
</form>
</div>
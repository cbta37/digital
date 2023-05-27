<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
      <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CATEGORÍA
  </h3>  
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
  <li>
          <a href="<?php echo SERVER_URL; ?>category-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CATEGORÍA</a>
      </li>
      <li>
          <a href="<?php echo SERVER_URL; ?>category-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CATEGORÍAS</a>
      </li> 
      <li>
        <a class="active" href="<?php echo SERVER_URL; ?>category-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CATEGORÍA</a>
      </li>   
  </ul>
</div>

<!--CONTENT-->
<?php if(!isset($_SESSION['busqueda_categoria']) && empty($_SESSION['busqueda_categoria'])){ ?>
    <div class="container-fluid">
  <form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
      <input type="hidden" name="modulo" value="categoria">
      <div class="container-fluid">
          <div class="row justify-content-md-center">
              <div class="col-12 col-md-6">
                  <div class="form-group">
                      <label for="inputSearch" class="bmd-label-floating">¿Qué categoría estas buscando?</label>
                      <input type="text" class="form-control" name="busqueda_inicial" id="inputSearch" maxlength="30">
                  </div>
              </div>
              <div class="col-12">
                  <p class="text-center" style="margin-top: 40px;">
                      <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                  </p>
              </div>
          </div>
      </div>
  </form>
    </div>
<?php }else{ ?>

    <div class="container-fluid">
    <form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
        <input type="hidden" name="modulo" value="categoria">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_categoria'];?>”</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="container-fluid">
        <?php
            require_once "./controladores/categoriaControlador.php";
            
            $ins_categoria = new categoriaControlador();
            echo $ins_categoria->paginadorCategoriaControlador($pagina[1], 10, $_SESSION['privilegio_smp'], $pagina[0], $_SESSION['busqueda_categoria']);
        ?>
    </div>

<?php } ?>
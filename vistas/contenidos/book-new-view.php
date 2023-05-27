<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR LIBRO
  </h3>
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li> 
      <a class="active" href="<?php echo SERVER_URL; ?>book-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR LIBRO</a>
    </li>
    <li>
      <a href="<?php echo SERVER_URL; ?>book-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE LIBROS</a>
    </li>
    <li>
      <a href="<?php echo SERVER_URL; ?>book-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR LIBRO</a>
    </li>
  </ul>	
</div>

<!-- Content here-->
<div class="container-fluid">
  <form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/libroAjax.php" method="POST" data-form="save" autocomplete="off">
    <fieldset>
      <legend><i class="fas fa-list"></i> &nbsp; Información básica</legend>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="form-group">         
                  <input type="hidden" id="foto_actual" name="foto_actual">
                  <label for="imagen" id="icon-image" class="btn btn-primary mt-2 pl-0"><i class="fas fa-plus fa-fw"></i>Foto</label>
                  <span id="icon-cerrar"></span>
                  <input id="imagen" class="d-none" type="file" name="imagen" accept=".jpg,.jpeg,.png" onchange="preview(event)">
                  <img class="img-thumbnail d-none" id="img-preview" src="" width="150">           
            </div>
          </div>   
          <div class="col-12 col-md-6">
            <div class="form-group">
              <input type="hidden" id="archivo_actual" name="archivo_actual">
              <label for="archivo" id="icon-image2" class="btn btn-primary mt-2 pl-0">
              <i class="fas fa-plus fa-fw"></i>Selecciones un Archivo PDF</label>
              <input id="archivo" type="file" name="archivo" class="d-none" accept=".pdf" onchange="previewPDF(event)" src="">
              <span id="icon-cerrar2"></span>      
              <span class="fas fa-file-pdf fa-fw h2 mt-4 d-none" id="img-preview2"></span>
              <strong class="d-none" id="book-name">book.pdf</strong>
            </div>
          </div>       
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="book_titulo" class="bmd-label-floating">Título</label>
              <input type="text" class="form-control" name="book_titulo_reg" id="book_titulo" maxlength="254" required="">
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="book_desc" class="bmd-label-floating">Descripción</label>
              <input type="text"  class="form-control" name="book_desc_reg" id="book_desc" maxlength="254" required="">
            </div>
          </div>                   

          <?php 
              require_once "./controladores/categoriaControlador.php";
              $ins_categoria = new categoriaControlador();
              $categorias = $ins_categoria->datosCategoriaControlador("Conteo",0);   
              $id = 0;
          ?>

          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="item_categoria" class="bmd-label-floating">Categoría</label>
                <?php
                    if($categorias->rowCount() >= 1){
                      $categorias = $categorias->fetchAll(); ?>
                      <select class="form-control" name="item_categoria_reg" id="item_categoria">
                        <?php foreach($categorias as $rows){ ?>   
                          <option <?php if($id==$rows[0]){ ?> selected="" <?php } ?> value="<?php echo $rows[0]; ?>">&nbsp <?php echo $rows[1]; if($id==$rows[0]){ ?>  (Actual) <?php } ?> </option>
                            <?php } ?>                          
                      </select>
                    <?php }else{ ?>
                      <strong>Ninguna (Obligatorio)</strong><br><a class="btn btn-danger" href="<?php echo SERVER_URL;?>category-new/">Click Aquí para añadir una, por favor</a>
                <?php } ?>              
            </div>
          </div>

          <div class="col-12 col-md-6">
              <div class="form-group">
                  <label for="ingreso_inicio">Fecha de ingreso</label>
                  <input type="date" class="form-control" name="ingreso_inicio_reg" id="ingreso_inicio"
                  value="<?php echo date("Y-m-d"); ?>">
              </div>
          </div>
        </div>
      </div>
    </fieldset>
    <br>
    <p class="text-center" style="margin-top: 40px;">
      <button onclick="location.reload()" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
      &nbsp; &nbsp;    
      <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
    </p>
  </form>
</div>
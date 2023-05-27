<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<!-- Page header -->
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR LIBRO
  </h3>  
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a href="<?php echo SERVER_URL; ?>book-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR LIBRO</a>
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
  <?php 
    require_once "./controladores/libroControlador.php";
    $ins_libro = new libroControlador();
    $datos_libro = $ins_libro->datosLibroControlador("Unico", $pagina[1]);
    if($datos_libro->rowCount()==1){
      $campos=$datos_libro->fetch();
  ?>
  <form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/libroAjax.php" method="POST" data-form="update" autocomplete="off">
  <input type="hidden" name="libro_id_up" value="<?php echo $pagina[1] ?>">
  <fieldset>
      <legend><i class="fas fa-list"></i> &nbsp; Información básica</legend>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-6">            
            <div class="form-group">   
                <?php if($campos['foto']=='logo.png') { ?>      
                  <input type="hidden" id="foto_actual" name="foto_actual" 
                  value="<?php echo $campos['foto'] ?>">
                  <label for="imagen" id="icon-image" class="btn btn-primary mt-2 pl-0"><i class="fas fa-plus fa-fw"></i>Foto</label>
                  <span id="icon-cerrar"></span>
                  <input id="imagen" class="d-none" type="file" name="imagen" accept=".jpg,.jpeg,.png" onchange="preview(event)">
                  <img class="img-thumbnail d-none" id="img-preview" src="" width="150">           
                  <?php }else{?>
                    <input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $campos['foto'] ?>">
                    <label for="imagen" id="icon-image" class="btn btn-primary mt-2 pl-0 d-none"><i class="fas fa-plus fa-fw"></i>Foto</label>
                    <span id="icon-cerrar">
                      <button class="btn btn-danger" onclick="deleteImg()"><i class="fa fa-times-circle"></i></button>
                    </span>
                    <input id="imagen" class="d-none" type="file" name="imagen" accept=".jpg,.jpeg,.png" onchange="preview(event)">
                    <img class="img-thumbnail" id="img-preview" src="<?php echo SERVER_URL."vistas/assets/img/libros/".$campos['foto'] ?>" width="150">
                  <?php } ?>
            </div>
          </div>   
          <div class="col-12 col-md-6">
            <div class="form-group">
              <?php if($campos['disponible']=='no') { ?>
                <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $campos['archivo_pdf'] ?>">
                <label for="archivo" id="icon-image2" class="btn btn-primary mt-2 pl-0">
                <i class="fas fa-plus fa-fw"></i>Selecciones un Archivo PDF</label>
                <input id="archivo" type="file" name="archivo" class="d-none" accept=".pdf" onchange="previewPDF(event)" src="">
                <span id="icon-cerrar2"></span>      
                <span class="fas fa-file-pdf fa-fw h2 mt-4 d-none" id="img-preview2"></span>
                <strong class="d-none" id="book-name">book.pdf</strong>
              <?php }else{?>
                <input type="hidden" id="archivo_actual" name="archivo_actual" value="<?php echo $campos['archivo_pdf'] ?>">
                <label for="archivo" id="icon-image2" class="btn btn-primary mt-2 pl-0 d-none">
                <i class="fas fa-plus fa-fw"></i>Selecciones un Archivo PDF</label>
                <input id="archivo" type="file" name="archivo" class="d-none" accept=".pdf" onchange="previewPDF(event)" src="<?php echo SERVER_URL."vistas/assets/libros/".$campos['archivo_pdf'] ?>">
                <span id="icon-cerrar2">
                  <button class="btn btn-danger" onclick="deleteImg2()"><i class="fa fa-times-circle"></i></button>
                </span>      
                <span class="fas fa-file-pdf fa-fw h2 mt-4" id="img-preview2"></span>
                <strong class="" id="book-name"><?php echo $campos['nombre'] ?></strong>
                <?php } ?>
            </div>
          </div>       
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="book_titulo" class="bmd-label-floating">Título</label>
              <input type="text" class="form-control" name="book_titulo_up" id="book_titulo" maxlength="254" required="" value="<?php echo $campos['nombre'] ?>">
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="book_desc" class="bmd-label-floating">Descripción</label>
              <input type="text"  class="form-control" name="book_desc_up" id="book_desc" maxlength="254" required="" value="<?php echo $campos['descripcion'] ?>">
            </div>
          </div>                   

          <?php 
              require_once "./controladores/categoriaControlador.php";
              $ins_categoria = new categoriaControlador();
              $categorias = $ins_categoria->datosCategoriaControlador("Conteo",0);
            ?>

          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="item_categoria" class="bmd-label-floating">Categoría</label>
              <?php
                    if($categorias->rowCount() >= 1){
                      $categorias = $categorias->fetchAll(); ?>
                      <select class="form-control" name="item_categoria_reg" id="item_categoria">
                        <?php foreach($categorias as $rows){ ?>   
                          <option <?php if($campos['id_categoria']==$rows[0]){ ?> selected="" <?php } ?> value="<?php echo $rows[0]; ?>">&nbsp <?php echo $rows[1]; if($campos['id_categoria']==$rows[0]){ ?>  (Actual) <?php } ?> </option>
                            <?php } ?>                          
                      </select>
                    <?php }else{ ?>
                      <strong>Ninguna (Obligatorio)</strong><br><a class="btn btn-danger" href="<?php echo SERVER_URL; ?>category-new/">Click Aquí para añadir una, por favor</a>
                <?php } ?>              
            </div>
          </div>

          <div class="col-12 col-md-6">
              <div class="form-group">
                  <label for="ingreso_inicio">Fecha de ingreso</label>
                  <input type="date" class="form-control" name="ingreso_inicio_up" id="ingreso_inicio"
                  value="<?php echo $campos['fecha_ingreso'] ?>">
              </div>
          </div>
        </div>
      </div>
    </fieldset>
    <br>
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
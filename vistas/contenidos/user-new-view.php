<!-- Page header -->
<?php 
  if( $_SESSION['privilegio_smp'] != 1 ){ 
    echo $lc->forzarCierreSesionControlador();
    exit();
  }
?>
<div class="full-box page-header">
  <h3 class="text-left">
    <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO
  </h3>  
</div>

<div class="container-fluid">
  <ul class="full-box list-unstyled page-nav-tabs">
    <li>
      <a class="active" href="<?php echo SERVER_URL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
    </li>
    <li>
      <a href="<?php echo SERVER_URL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
    </li>
    <li>
      <a href="<?php echo SERVER_URL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
    </li>
  </ul>	
</div>

<!-- Content -->
<div class="container-fluid">
  <form class= "FormularioAjax form-neon" action="<?php echo SERVER_URL; ?>ajax/usuarioAjax.php" method="POST" data-form="save" autocomplete="off">
    <fieldset>
      <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label for="usuario_dni_reg" class="bmd-label-floating">Matrícula</label>
              <input type="text" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni_reg" id="usuario_dni_reg" maxlength="20" required="">
            </div>
          </div>
          
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label for="usuario_nombre_reg" class="bmd-label-floating">Nombres</label>
              <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre_reg" id="usuario_nombre_reg" maxlength="35" required="">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-group">
              <label for="usuario_apellido_reg" class="bmd-label-floating">Apellidos</label>
              <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido_reg" id="usuario_apellido_reg" maxlength="35" required="">
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="usuario_telefono_reg" class="bmd-label-floating">Teléfono</label>
              <input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_reg" id="usuario_telefono_reg" maxlength="20">
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="usuario_direccion_reg" class="bmd-label-floating">Dirección</label>
              <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="usuario_direccion_reg" id="usuario_direccion_reg" maxlength="190">
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <br><br><br>
    <fieldset>
      <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="usuario_usuario_reg" class="bmd-label-floating">Nombre de usuario</label>
              <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_usuario_reg" id="usuario_usuario_reg" maxlength="35" required="">
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="usuario_email_reg" class="bmd-label-floating">Email</label>
              <input type="email" class="form-control" name="usuario_email_reg" id="usuario_email" maxlength="70">
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="usuario_clave_1_reg" class="bmd-label-floating">Contraseña</label>
              <input type="password" class="form-control" name="usuario_clave_1_reg" id="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="usuario_clave_2_reg" class="bmd-label-floating">Repetir contraseña</label>
              <input type="password" class="form-control" name="usuario_clave_2_reg" id="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <br><br><br>
    <fieldset>
      <legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <p><span class="badge badge-info">Control total</span> Permisos para registrar, actualizar y eliminar</p>
            <!-- <p><span class="badge badge-success">Edición</span> Permisos para registrar y actualizar</p> -->
            <p><span class="badge badge-dark">Buscar</span> Solo permisos para hacer búsquedas y descargas</p>
            <div class="form-group">
              <select class="form-control" name="usuario_privilegio_reg">
                <option value="" selected="">Seleccione una opción</option>
                <option value="1">Control total</option>
                <!--<option value="2">Edición</option>-->
                <option value="3">Buscar</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <p class="text-center" style="margin-top: 40px;">
      <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
      &nbsp; &nbsp;
      <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
    </p>
  </form>
</div>
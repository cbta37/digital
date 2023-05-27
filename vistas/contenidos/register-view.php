<div class="login-container">
  <div class="register-content">
    
    <p class="text-center text-success font-weight-bold">
      Registrarme por primera vez
    </p>
    <form class= "FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/usuarioAjax.php" method="POST"  data-form="save" autocomplete="off" >
        <input type="hidden" name="register-student" value="yes">
        <fieldset>
          <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="form-group">
                  <label for="usuario_dni_reg" class="bmd-label-floating">Matrícula</label>
                  <input type="text" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni_reg" id="usuario_dni_reg" maxlength="20" required="">
                </div>
              </div>
              
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="usuario_nombre_reg" class="bmd-label-floating">Nombres</label>
                  <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre_reg" id="usuario_nombre_reg" maxlength="35" required="">
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label for="usuario_apellido_reg" class="bmd-label-floating">Apellidos</label>
                  <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido_reg" id="usuario_apellido_reg" maxlength="35" required="">
                </div>
              </div>
            </div>
          </div>
        </fieldset>        
        <fieldset>
          <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="form-group">
                  <label for="usuario_usuario_reg" class="bmd-label-floating">Nombre de usuario</label>
                  <input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_usuario_reg" id="usuario_usuario_reg" maxlength="35" required="">
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
      <p class="text-center" style="margin-top: 40px;">
        <a href="<?php echo SERVER_URL; ?>login" class="btn btn-raised btn-danger btn-sm"><i class="fas fa-arrow-left"></i> &nbsp; Volver Atrás</a>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; Registrarme</button>
      </p>
    </form>
  </div>
</div>
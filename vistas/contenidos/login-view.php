<div class="login-container">
  <div class="login-content">
    <p class="text-center">
      <i class="fas fa-user-circle fa-5x"></i>
    </p>
    <h3 class="text-primary text-center font-weight-bold">Biblioteca Digital CBTA 37</h3>
    <p class="text-center text-success font-weight-bold">
      Inicia sesión con tu cuenta      
    </p>
    <form action="" method="POST" autocomplete="off" >
      <div class="form-group">
        <label for="UserName" class="bmd-label-floating"><i class="fas fa-user-secret"></i> &nbsp; Usuario</label>
        <input type="text" class="form-control" id="UserName" name="usuario_log" pattern="[a-zA-Z0-9]{1,35}" maxlength="35" required="" >
      </div>
      <div class="form-group">
        <label for="UserPassword" class="bmd-label-floating"><i class="fas fa-key"></i> &nbsp; Contraseña</label>
        <input type="password" class="form-control" id="UserPassword" name="clave_log" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" autocomplete="true">
      </div>
      <button type="submit" class="btn-login text-center font-weight-bold">Iniciar Sesión</button>
      <p class="text-secondary text-center mt-2">¿Aún no tienes cuenta?</p>
      <a href="<?php echo SERVER_URL; ?>register" class="btn btn-raised btn-info btn-sm d-block"><i class="fas fa-arrow-right"></i> &nbsp; Registrarme</a>      
    </form>
  </div>
</div>

<?php
  if(isset($_POST['usuario_log']) && isset($_POST['clave_log'])){
    require_once "./controladores/loginControlador.php";
    $ins_login = new loginControlador();
    echo $ins_login->iniciarSesionControlador();
  }
?>
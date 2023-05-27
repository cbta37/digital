<script>
  let btn_salir = document.querySelector(".btn-exit");  
  btn_salir.addEventListener('click', function(e){
    e.preventDefault();    
    
    Swal.fire({
			title: '¿Estás seguro de cerrar la sesión?',
			text: "La sesión se cerrará y saldrás del sistema",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, salir',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				let url = '<?php echo SERVER_URL; ?>ajax/loginAjax.php';
        let token = ' <?php echo $lc->encryption($_SESSION['token_smp']) ?>';
        let usuario = ' <?php echo $lc->encryption($_SESSION['usuario_smp']) ?>';

        let datos = new FormData();

        datos.append("token", token);
        datos.append("usuario", usuario);
        
        fetch(url, {
          method: 'POST',
          body: datos
        })
        .then((respuesta) => respuesta.json())
        .then((respuesta) => {
          return alertasAjax(respuesta);
        });
			}
		}); 
  });
 
</script>
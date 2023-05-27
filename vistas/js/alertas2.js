const formulariosAjax = document.querySelectorAll(".FormularioAjax");

function enviarFormularioAjax(e) {
  e.preventDefault();
  let data = new FormData(this);
  let method = this.getAttribute("method");
  let action = this.getAttribute("action");
  let tipo = this.getAttribute("data-form");

  let headers = new Headers();
  let config = {
    method,
    headers,
    mode: "cors",
    cache: "no-cache",
    body: data,
  };

  let texto_alerta;

  if (tipo === "save") {
    texto_alerta = "Los datos quedarán guardados en el sistema";
  } else if (tipo === "delete") {
    texto_alerta = "Los datos serán eliminados completamente del sistema";
  } else if (tipo === "update") {
    texto_alerta = "Los datos del sistema serán actualizados";
  } else if (tipo === "search") {
    texto_alerta =
      "Se eliminará el término de búsqueda y tendrás que escribir uno nuevo";
  } else if (tipo === "loan") {
    texto_alerta = "¿Desea remover los datos para préstamos o reservaciones?";
  } else {
    texto_alerta = "¿Deseas realizar la operación solicitada?";
  }

  Swal.fire({
    title: "¿Estás seguro?",
    text: texto_alerta,
    type: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.value) {
      fetch(action, config)
        .then((respuesta) => respuesta.json())
        .then((respuesta) => {
          return alertasAjax(respuesta);
        });
    }
  });
}

formulariosAjax.forEach((formularios) => {
  formularios.addEventListener("submit", enviarFormularioAjax);
});

function alertasAjax(alerta) {
  if (alerta.alerta === "simple") {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      type: alerta.tipo,
      confirmButtonText: "Aceptar",
    });
  } else if (alerta.alerta === "recargar") {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      type: alerta.tipo,
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.value) {
        location.reload();
      }
    });
  } else if (alerta.alerta === "limpiar") {
    Swal.fire({
      title: alerta.titulo,
      text: alerta.texto,
      type: alerta.tipo,
      confirmButtonText: "Aceptar",
    }).then((result) => {
      if (result.value) {
        document.querySelector(".FormularioAjax").reset();
      }
    });
  } else if (alerta.alerta === "redireccionar") {
    window.location.href = alerta.url;
  }
}

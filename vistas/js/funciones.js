function preview(e) {
  var input = document.getElementById("imagen");
  var filePath = input.value;
  var extension = /(\.png|\.jpeg|\.jpg)$/i;
  if (!extension.exec(filePath)) {
    alertas("Seleccione un archivo valido", "warning");
    deleteImg();
    return false;
  } else {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").classList.remove("d-none");
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `
      <button class="btn btn-danger" onclick="deleteImg()"><i class="fa fa-times-circle"></i></button>
      `;
  }
}

function deleteImg() {
  document.getElementById("icon-cerrar").innerHTML = "";
  document.getElementById("icon-image").classList.remove("d-none");
  document.getElementById("img-preview").src = "";
  document.getElementById("img-preview").classList.add("d-none");
  document.getElementById("imagen").value = "";
  document.getElementById("foto_actual").value = "";
}

function alertas(msg, icono) {
  Swal.fire({
    position: "top-end",
    icon: icono,
    title: msg,
    showConfirmButton: false,
    timer: 3000,
  });
}

function previewPDF(e) {
  var input = document.getElementById("archivo");
  var filePath = input.value;
  var extension = /(\.pdf)$/i;
  if (!extension.exec(filePath)) {
    alertas("Seleccione un archivo valido", "warning");
    deleteImg2();
    return false;
  } else {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview2").classList.remove("d-none");
    document.getElementById("book-name").innerHTML = url.name;
    document.getElementById("book-name").classList.remove("d-none");
    document.getElementById("archivo").src = urlTmp;
    document.getElementById("icon-image2").classList.add("d-none");
    document.getElementById("icon-cerrar2").innerHTML = `
      <button class="btn btn-danger" onclick="deleteImg2()"><i class="fa fa-times-circle"></i></button>
      `;
  }
}

function deleteImg2() {
  document.getElementById("icon-cerrar2").innerHTML = "";
  document.getElementById("icon-image2").classList.remove("d-none");
  document.getElementById("archivo").src = "";
  document.getElementById("img-preview2").classList.add("d-none");
  document.getElementById("book-name").classList.add("d-none");
  document.getElementById("archivo").value = "";
  document.getElementById("archivo_actual").value = "";
}

function recargar(e) {
  e.preventDefault();
  location.reload();
}

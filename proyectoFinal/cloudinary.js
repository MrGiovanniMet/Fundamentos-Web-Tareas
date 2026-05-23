const widget = cloudinary.createUploadWidget(
  {
    cloudName: "dwj052lw2",
    uploadPreset: "Vet_tienda",
  },
  (error, result) => {
    if (!error && result.event === "success") {
      const url = result.info.secure_url;

      document.getElementById("imagen_url").value = url;

      const preview = document.getElementById("preview");
      preview.src = url;
      preview.style.display = "block";
    }
  }
);

function abrirWidget() {
  widget.open();
}
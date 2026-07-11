const valorUF = 78158;

const formulario = document.getElementById("formPropiedad");
const precioInput = document.getElementById("precio");
const precioUFInput = document.getElementById("precioUF");
const fotosInput = document.getElementById("fotos");
const galeriaFotos = document.getElementById("galeriaFotos");

precioInput.addEventListener("input", function () {
    let precio = parseFloat(precioInput.value);

    if (!isNaN(precio) && precio > 0) {
        precioUFInput.value = (precio / valorUF).toFixed(2);
    } else {
        precioUFInput.value = "";
    }
});

formulario.addEventListener("submit", function (e) {

    let tipo = document.getElementById("tipo").value;
    let descripcion = document.getElementById("descripcion").value.trim();
    let comuna = document.getElementById("comuna").value.trim();
    let sector = document.getElementById("sector").value.trim();
    let dormitorios = document.getElementById("dormitorios").value;
    let banos = document.getElementById("banos").value;
    let precio = document.getElementById("precio").value;
    let precioUF = document.getElementById("precioUF").value;
    let areaConstruida = document.getElementById("areaConstruida").value;
    let areaTerreno = document.getElementById("areaTerreno").value;
    let fecha = document.getElementById("fecha").value;
    let visita = document.getElementById("visita").value;

    if (
    tipo === "" ||
    descripcion === "" ||
    comuna === "" ||
    sector === "" ||
    precio === "" ||
    precioUF === "" ||
    fecha === "" ||
    visita === ""
) {
    if (tipo === "Casa") {
    if (dormitorios === "" || banos === "" || areaConstruida === "" || areaTerreno === "") {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Complete los datos de la casa."
        });

        return;
    }
}

if (tipo === "Departamento") {
    if (dormitorios === "" || banos === "" || areaConstruida === "") {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Complete los datos del departamento."
        });

        return;
    }
}

if (tipo === "Terreno") {
    if (areaTerreno === "") {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Complete los datos del terreno."
        });

        return;
    }
}
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Debe completar todos los campos obligatorios."
        });

        return;
    }
        let soloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/;

        if (
    !soloLetras.test(descripcion) ||
    !soloLetras.test(comuna) ||
    !soloLetras.test(sector)
) {
        e.preventDefault();

        Swal.fire({
    icon: "error",
    title: "Datos inválidos",
    text: "Descripción, comuna y sector solo permiten letras."
});

        return;
    }
         let fechaSeleccionada = new Date(fecha + "T00:00:00");
         let fechaActual = new Date();

         fechaActual.setHours(0, 0, 0, 0);

         if (fechaSeleccionada > fechaActual) {
         e.preventDefault();

         Swal.fire({
          icon: "error",
          title: "Fecha inválida",
          text: "La fecha de publicación no puede ser futura."
    });

    return;
}

    if (
        isNaN(dormitorios) ||
        isNaN(banos) ||
        isNaN(precio) ||
        isNaN(areaConstruida) ||
        isNaN(areaTerreno)
    ) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Datos inválidos",
            text: "Dormitorios, baños, precio y áreas deben contener solo números."
        });

        return;
    }
});

fotosInput.addEventListener("change", function () {
    galeriaFotos.innerHTML = "";

    let archivos = fotosInput.files;

    if (archivos.length > 10) {
        Swal.fire({
            icon: "warning",
            title: "Máximo 10 fotografías",
            text: "Solo puede subir hasta 10 imágenes."
        });

        fotosInput.value = "";
        return;
    }

    for (let i = 0; i < archivos.length; i++) {
        let archivo = archivos[i];

        if (!archivo.type.startsWith("image/")) {
            Swal.fire({
                icon: "error",
                title: "Archivo inválido",
                text: "Solo se permiten imágenes."
            });

            fotosInput.value = "";
            galeriaFotos.innerHTML = "";
            return;
        }

        let lector = new FileReader();

        lector.onload = function (evento) {
            let imagen = document.createElement("img");
            imagen.src = evento.target.result;
            imagen.style.width = "120px";
            imagen.style.height = "90px";
            imagen.style.objectFit = "cover";
            imagen.style.margin = "5px";
            imagen.style.borderRadius = "8px";

            galeriaFotos.appendChild(imagen);
        };

        lector.readAsDataURL(archivo);
    }
});
const tipoPropiedad = document.getElementById("tipo");

tipoPropiedad.addEventListener("change", function () {
    let tipo = tipoPropiedad.value;

    document.getElementById("campoDormitorios").style.display = "block";
    document.getElementById("campoBanos").style.display = "block";
    document.getElementById("campoAreaConstruida").style.display = "block";
    document.getElementById("campoAreaTerreno").style.display = "block";

    if (tipo === "Terreno") {
        document.getElementById("campoDormitorios").style.display = "none";
        document.getElementById("campoBanos").style.display = "none";
        document.getElementById("campoAreaConstruida").style.display = "none";

        document.getElementById("dormitorios").value = 0;
        document.getElementById("banos").value = 0;
        document.getElementById("areaConstruida").value = 0;
    }

    if (tipo === "Departamento") {
        document.getElementById("campoAreaTerreno").style.display = "none";
        document.getElementById("areaTerreno").value = 0;
    }
});
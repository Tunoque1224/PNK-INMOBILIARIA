const formPropietario = document.getElementById("formPropietario");
function validarRut(rutCompleto) {
    let rutLimpio = rutCompleto
        .replace(/\./g, "")
        .replace("-", "")
        .toUpperCase();

    if (rutLimpio.length < 2) {
        return false;
    }

    let cuerpo = rutLimpio.slice(0, -1);
    let dvIngresado = rutLimpio.slice(-1);

    if (!/^\d+$/.test(cuerpo)) {
        return false;
    }

    let suma = 0;
    let multiplicador = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += parseInt(cuerpo.charAt(i)) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }

    let resultado = 11 - (suma % 11);
    let dvCalculado;

    if (resultado === 11) {
        dvCalculado = "0";
    } else if (resultado === 10) {
        dvCalculado = "K";
    } else {
        dvCalculado = resultado.toString();
    }

    return dvIngresado === dvCalculado;
}

formPropietario.addEventListener("submit", function(e) {

    let rut = document.getElementById("rut").value.trim();
    let nombre = document.getElementById("nombre").value.trim();
    let fecha = document.getElementById("fecha").value;
    let correo = document.getElementById("correo").value.trim();
    let password = document.getElementById("password").value;
    let sexo = document.getElementById("sexo").value;
    let telefono = document.getElementById("telefono").value.trim();
    let propiedad = document.getElementById("propiedad").value.trim();

    if (
        rut === "" ||
        nombre === "" ||
        fecha === "" ||
        correo === "" ||
        password === "" ||
        sexo === "" ||
        telefono === "" ||
        propiedad === ""
    ) {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Debe completar todos los campos obligatorios."
        });
        return;
    }

    const formatoRut = /^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]$/;

    if (!formatoRut.test(rut)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "RUT inválido",
            text: "Debe ingresar el RUT con formato 12.345.678-9."
        });
        return;
    }
    if (!validarRut(rut)) {
    e.preventDefault();

    Swal.fire({
        icon: "error",
        title: "RUT inválido",
        text: "El dígito verificador no corresponde."
    });

    return;
}
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]+$/;

if (!soloLetras.test(nombre)) {
    e.preventDefault();

    Swal.fire({
        icon: "error",
        title: "Nombre inválido",
        text: "El nombre solo debe contener letras y espacios."
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
        text: "La fecha de nacimiento no puede ser futura."
    });

    return;
}

    const formatoCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!formatoCorreo.test(correo)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Correo inválido",
            text: "Ingrese un correo electrónico válido."
        });
        return;
    }
    const formatoTelefono = /^[0-9]{9}$/;

    if (!formatoTelefono.test(telefono)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Teléfono inválido",
            text: "Debe ingresar un teléfono de 9 dígitos."
        });
        return;
    }

    const formatoPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_-]).{8,}$/;

    if (!formatoPassword.test(password)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Contraseña insegura",
            text: "Debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial."
        });
        return;
    }

    // Si todo está correcto, el formulario se envía a guardar_propietario.php
});
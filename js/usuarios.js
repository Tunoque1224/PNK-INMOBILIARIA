const formUsuario = document.getElementById("formUsuario");
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

formUsuario.addEventListener("submit", function(e) {

    let rut = document.getElementById("rut").value.trim();
    let nombre = document.getElementById("nombre").value.trim();
    let correo = document.getElementById("correo").value.trim();
    let password = document.getElementById("password").value.trim();
    let rol = document.getElementById("rol").value;

    let formatoRut = /^[0-9]{1,2}\.[0-9]{3}\.[0-9]{3}-[0-9kK]$/;
    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    let formatoPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_-]).{8,}$/;

    if (rut === "" || nombre === "" || correo === "" || password === "" || rol === "") {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Debe completar todos los campos."
        });

        return;
    }

    if (!formatoRut.test(rut)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "RUT inválido",
            text: "Use el formato 12.345.678-9."
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

    if (!soloLetras.test(nombre)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Nombre inválido",
            text: "El nombre solo debe contener letras y espacios."
        });

        return;
    }

    if (!correo.includes("@") || !correo.includes(".")) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Correo inválido",
            text: "Ingrese un correo electrónico válido."
        });

        return;
    }

    if (!formatoPassword.test(password)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Contraseña insegura",
            text: "Debe incluir mayúscula, minúscula, número y símbolo."
        });

        return;
    }
});


const formUsuario = document.getElementById("formUsuario");

function validarRut(rutCompleto) {
    rutCompleto = rutCompleto.replace(/\./g, "").replace("-", "");

    if (rutCompleto.length < 8) {
        return false;
    }

    let cuerpo = rutCompleto.slice(0, -1);
    let dv = rutCompleto.slice(-1).toUpperCase();

    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += parseInt(cuerpo.charAt(i)) * multiplo;
        multiplo = multiplo < 7 ? multiplo + 1 : 2;
    }

    let esperado = 11 - (suma % 11);

    if (esperado == 11) esperado = "0";
    else if (esperado == 10) esperado = "K";
    else esperado = esperado.toString();

    return esperado === dv;
}

formUsuario.addEventListener("submit", function(e) {

    let rut = document.getElementById("rut").value.trim();
    let nombre = document.getElementById("nombre").value.trim();
    let correo = document.getElementById("correo").value.trim();
    let password = document.getElementById("password").value;
    let rol = document.getElementById("rol").value;

    if (rut === "" || nombre === "" || correo === "" || password === "" || rol === "") {
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
            title: "RUT incorrecto",
            text: "El dígito verificador del RUT no es válido."
        });
        return;
    }

    const formatoNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/;

    if (!formatoNombre.test(nombre)) {
        e.preventDefault();

        Swal.fire({
            icon: "error",
            title: "Nombre inválido",
            text: "El nombre solo puede contener letras."
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

});
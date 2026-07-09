const formPropietario = document.getElementById("formPropietario");

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
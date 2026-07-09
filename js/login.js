const formLogin = document.getElementById("formLogin");

formLogin.addEventListener("submit", function(e) {

    let correo = document.getElementById("correo").value.trim();
    let password = document.getElementById("password").value;

    if (correo === "" || password === "") {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Campos incompletos",
            text: "Debe ingresar el correo y la contraseña."
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
            title: "Contraseña incorrecta",
            text: "La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial."
        });
        return;
    }

    // Si todo está correcto, PHP procesa el login.
});
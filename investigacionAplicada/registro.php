<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
    <script>
        async function registrarUsuario(event) {
            event.preventDefault();
            const datos = {
                nombre: document.getElementById('nombre').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                telefono: document.getElementById('telefono').value
            };

            try {
                const respuesta = await fetch('/investigacionAplicada/controllers/usuarios.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });

                const resultado = await respuesta.json();
                alert(resultado.mensaje || resultado.error);

                if (!resultado.error) {
                    window.location.href = 'login.php';
                }
            } catch (error) {
                console.error("Error en la solicitud:", error);
                alert("Hubo un problema al conectar con el servidor.");
            }
        }
    </script>
</head>
<body>
    <h2>Registro de usuario</h2>
    <form onsubmit="registrarUsuario(event)">
        <input type="text" id="nombre" placeholder="Nombre" required><br>
        <input type="email" id="email" placeholder="Correo" required><br>
        <input type="password" id="password" placeholder="Contraseña" required><br>
        <input type="text" id="telefono" placeholder="Teléfono" required><br>
        <button type="submit">Registrar</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>

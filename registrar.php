<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $contrasena = trim($_POST['contrasena']);
    $fecha = date("d/m/y");

    // Validar campos
    if ($nombre && $email && $direccion && $telefono && $contrasena) {

        // Verificar que no exista email
        $sql_check = "SELECT * FROM datos WHERE email = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $error = "Este correo ya está registrado.";
        } else {
            // Insertar usuario
            $sql = "INSERT INTO datos (nombres, email, direccion, telefono, contrasena, fecha) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $email, $direccion, $telefono, $contrasena, $fecha);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Error al registrar, intenta de nuevo.";
            }
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style_registrar.css" />
</head>
<body>
  <div class="container">
    <div class="imagen"></div>

    <div class="formulario">
      <h2>Registro de Usuario</h2>

      <?php if (!empty($error)) { echo "<p class='error-message'>$error</p>"; } ?>

      <form method="post" action="">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <button type="submit">Registrarse</button>
      </form>

      <a href="index.php">¿Ya tienes cuenta? Iniciar sesión</a>
    </div>
  </div>
</body>


</html>

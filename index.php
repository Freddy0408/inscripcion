<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $contrasena = trim($_POST['contrasena']);

    $sql = "SELECT * FROM datos WHERE email = ? AND contrasena = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $contrasena);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        $_SESSION['id'] = $fila['id'];
        $_SESSION['nombre'] = $fila['nombres'];
        $_SESSION['rol'] = $fila['rol'];  // Guardamos el rol
        header("Location: cursos.php");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="style_index.css" />

</head>
<body>
    <div class="container">

<h2>Iniciar Sesión</h2>

<?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

<form method="post" action="">
    Correo electrónico:<br>
    <input type="email" name="email" required><br><br>

    Contraseña:<br>
    <input type="password" name="contrasena" required><br><br>

    <button type="submit">Ingresar</button>
</form>

<br>
<a href="registrar.php">¿No tienes cuenta? Regístrate</a>
</div>
</body>
</html>

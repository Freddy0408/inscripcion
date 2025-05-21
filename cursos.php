<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id'])) {
    header("Location: inicio_sesion.php");
    exit;
}

$usuario_id = $_SESSION['id'];

$query = "SELECT * FROM cursos";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cursos disponibles</title>
    <link rel="stylesheet" href="style_cursos.css" />

</head>
<body>

<h1>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>. Cursos disponibles:</h1>

<!-- Aquí puedes agregar el enlace para el admin -->
<?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
    <p><a href="admin_inscripciones.php" class="admin-panel-link">Panel Admin: Ver Inscripciones</a></p>
<?php endif; ?>


<table border="1" cellpadding="10">
    <tr>
        <th>Curso</th>
        <th>Descripción</th>
        <th>Duración (días)</th>
        <th>Inscribirse</th>
    </tr>

    <?php while ($curso = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($curso['nombre_curso']); ?></td>
        <td><?php echo htmlspecialchars($curso['descripcion']); ?></td>
        <td><?php echo $curso['duracion']; ?></td>
        <td>
            <form method="post" action="inscribirse.php">
                <input type="hidden" name="curso_id" value="<?php echo $curso['ID']; ?>">
                <button type="submit">Inscribirse</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<br>
<a href="mis_cursos.php">Ver mis cursos inscritos</a> | 
<a href="cerrar_sesion.php">Cerrar sesión</a>

</body>
</html>


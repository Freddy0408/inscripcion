<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$usuario_id = $_SESSION['id'];

$sql = "SELECT c.nombre_curso, c.descripcion, c.duracion 
        FROM cursos c
        JOIN inscripciones i ON c.ID = i.ID_curso
        WHERE i.ID_usuario = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mis cursos inscritos</title>
</head>
<body>

<h1>Cursos en los que estás inscrito, <?php echo htmlspecialchars($_SESSION['nombre']); ?>:</h1>

<?php if (mysqli_num_rows($result) == 0): ?>
    <p>No estás inscrito en ningún curso.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Curso</th>
            <th>Descripción</th>
            <th>Duración (días)</th>
        </tr>
        <?php while ($curso = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($curso['nombre_curso']); ?></td>
            <td><?php echo htmlspecialchars($curso['descripcion']); ?></td>
            <td><?php echo $curso['duracion']; ?></td>
        </tr>
        <?php } ?>
    </table>
<?php endif; ?>

<br>
<a href="cursos.php">Ver cursos disponibles</a> | 
<a href="cerrar_sesion.php">Cerrar sesión</a>

</body>
</html>

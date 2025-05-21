<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: inicio_sesion.php");
    exit;
}

$sql = "SELECT i.ID_INSCRIPCION, d.nombres, d.email, c.nombre_curso, c.descripcion, c.duracion 
        FROM inscripciones i
        JOIN datos d ON i.ID_usuario = d.id
        JOIN cursos c ON i.ID_curso = c.ID
        ORDER BY c.nombre_curso, d.nombres";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Admin - Inscripciones</title>
    <link rel="stylesheet" href="style_admin.css" />
</head>
<body>

<h1>Panel de Administrador - Inscripciones</h1>

<table>
    <thead>
        <tr>
            <th>ID Inscripción</th>
            <th>Nombre Usuario</th>
            <th>Email Usuario</th>
            <th>Curso</th>
            <th>Descripción Curso</th>
            <th>Duración (días)</th>
        </tr>
    </thead>
    <tbody>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['ID_INSCRIPCION']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombres']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_curso']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <td><?php echo $row['duracion']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay inscripciones registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<p><a href="cursos.php">Volver a Cursos</a> | <a href="cerrar_sesion.php">Cerrar sesión</a></p>

</body>
</html>

<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$usuario_id = $_SESSION['id'];
$curso_id = $_POST['curso_id'] ?? null;

if (!$curso_id) {
    echo "No se especificó un curso para inscribirse.";
    exit;
}

// Verificar si ya está inscrito
$sql = "SELECT * FROM inscripciones WHERE ID_usuario = ? AND ID_curso = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $curso_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "Ya estás inscrito en este curso.";
    echo '<br><a href="cursos.php">Volver a cursos</a>';
    exit;
}

// Insertar inscripción
$sql = "INSERT INTO inscripciones (ID_curso, ID_usuario) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $curso_id, $usuario_id);

if (mysqli_stmt_execute($stmt)) {
    echo "Inscripción realizada con éxito.";
} else {
    echo "Error al inscribirse.";
}

echo '<br><a href="cursos.php">Volver a cursos</a>';
?>

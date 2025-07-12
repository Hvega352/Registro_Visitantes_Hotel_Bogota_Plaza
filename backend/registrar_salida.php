<?php
require 'conexion.php';
date_default_timezone_set('America/Bogota');

$nombre = trim($_POST['nombre'] ?? '');

if ($nombre === '') {
    die("Debe ingresar un nombre o documento. <a href='../frontend/salida.html'>Volver</a>");
}

$sql = "SELECT id, nombre_completo, documento, fecha_ingreso, hora_ingreso
        FROM visitantes
        WHERE (nombre_completo LIKE ? OR documento LIKE ?)
          AND (fecha_salida IS NULL OR hora_salida IS NULL)
        ORDER BY fecha_ingreso DESC";

$stmt = $conn->prepare($sql);
$likeNombre = "%$nombre%";
$stmt->bind_param('ss', $likeNombre, $likeNombre);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No se encontró ningún visitante activo con ese nombre o documento. <a href='../frontend/salida.html'>Volver</a>");
}

echo "<h3>Seleccione el visitante para registrar salida:</h3>";
echo "<ul>";
while ($visitante = $result->fetch_assoc()) {
    echo "<li>";
    echo htmlspecialchars($visitante['nombre_completo']) . " - Documento: " . htmlspecialchars($visitante['documento']);
    echo " - Ingreso: " . htmlspecialchars($visitante['fecha_ingreso']) . " " . htmlspecialchars($visitante['hora_ingreso']);
    // Formulario para registrar salida de este visitante
    echo "<form style='display:inline;' action='registrar_salida_confirmar.php' method='post'>";
    echo "<input type='hidden' name='id_visitante' value='" . $visitante['id'] . "'>";
    echo "<button type='submit'>Registrar salida</button>";
    echo "</form>";
    echo "</li>";
}
echo "</ul>";
echo "<p><a href='../frontend/salida.html'>Volver</a></p>";

$stmt->close();
$conn->close();
?>

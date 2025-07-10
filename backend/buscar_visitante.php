<?php
require 'conexion.php';

$busqueda = $_GET['busqueda'] ?? '';
$busqueda = trim($busqueda);

if ($busqueda === '') {
    echo json_encode(null);
    exit;
}

$sql = "SELECT * FROM visitantes WHERE (nombre_completo LIKE ? OR documento LIKE ?) AND (fecha_salida IS NULL OR fecha_salida = '') LIMIT 1";
$stmt = $conn->prepare($sql);
$like = "%$busqueda%";
$stmt->bind_param('ss', $like, $like);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>

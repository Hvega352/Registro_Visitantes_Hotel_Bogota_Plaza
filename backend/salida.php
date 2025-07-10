<?php
require 'conexion.php';

$id = $_POST['id'] ?? '';
$fecha_salida = $_POST['fecha_salida'] ?? '';
$hora_salida = $_POST['hora_salida'] ?? '';

if ($id && $fecha_salida && $hora_salida) {
    $sql = "UPDATE visitantes SET fecha_salida = ?, hora_salida = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $fecha_salida, $hora_salida, $id);
    if ($stmt->execute()) {
        echo "¡Salida registrada correctamente!";
    } else {
        echo "Error al registrar la salida.";
    }
} else {
    echo "Datos incompletos.";
}
?>

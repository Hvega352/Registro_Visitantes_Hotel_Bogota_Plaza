<?php
require 'conexion.php';

$nombre_completo = $_POST['nombre_completo'] ?? '';
$documento = $_POST['documento'] ?? '';
$tipo_visitante = $_POST['tipo_visitante'] ?? '';
$empresa = $_POST['empresa'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo_electronico = $_POST['correo_electronico'] ?? '';
$fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
$hora_ingreso = $_POST['hora_ingreso'] ?? '';
$destino = $_POST['destino'] ?? '';
$otro_destino = $_POST['otro_destino'] ?? '';
$autoriza = $_POST['autoriza'] ?? '';
$observaciones = $_POST['observaciones'] ?? '';

if ($destino == "Otro" && $otro_destino != "") {
    $destino = $otro_destino;
}

$sql = "INSERT INTO visitantes (nombre_completo, documento, tipo_visitante, empresa, telefono, correo_electronico, fecha_ingreso, hora_ingreso, destino, autoriza, observaciones)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $nombre_completo, $documento, $tipo_visitante, $empresa, $telefono, $correo_electronico, $fecha_ingreso, $hora_ingreso, $destino, $autoriza, $observaciones);

if ($stmt->execute()) {
    header("Location: ../frontend/index.html?success=1");
    exit();
} else {
    echo "Error al registrar el ingreso: " . $conn->error;
}
?>

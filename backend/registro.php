<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "registro_visitantes";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Captura de datos del formulario
$nombre_completo     = $_POST['nombre_completo'];
$documento           = $_POST['documento'];
$tipo_visitante      = $_POST['tipo_visitante'];
$empresa             = $_POST['empresa'];
$telefono            = $_POST['telefono'];
$correo_electronico  = $_POST['correo_electronico'];
$fecha_ingreso       = $_POST['fecha_ingreso'];
$hora_ingreso        = $_POST['hora_ingreso'];
$fecha_salida        = $_POST['fecha_salida'];
$hora_salida         = $_POST['hora_salida'];
$destino             = $_POST['destino'];
$otro_destino        = $_POST['otro_destino'] ?? null;
$autoriza            = $_POST['autoriza'];
$observaciones       = $_POST['observaciones'];

// Preparar sentencia SQL
$sql = "INSERT INTO visitantes (
    nombre_completo,
    documento,
    tipo_visitante,
    empresa,
    telefono,
    correo_electronico,
    fecha_ingreso,
    hora_ingreso,
    fecha_salida,
    hora_salida,
    destino,
    otro_destino,
    autoriza,
    observaciones
) VALUES (
    '$nombre_completo',
    '$documento',
    '$tipo_visitante',
    '$empresa',
    '$telefono',
    '$correo_electronico',
    '$fecha_ingreso',
    '$hora_ingreso',
    '$fecha_salida',
    '$hora_salida',
    '$destino',
    '$otro_destino',
    '$autoriza',
    '$observaciones'
)";

// Ejecutar y verificar
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registro guardado correctamente'); window.location.href = '../frontend/index.html';</script>";
} else {
    echo "Error al guardar: " . $conn->error;
}

$conn->close();
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "registro_visitantes";

// Conexión a la base de datos
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Captura de datos del formulario (usando null coalescing operator)
$nombre_completo     = $_POST['nombre_completo'] ?? '';
$documento           = $_POST['documento'] ?? '';
$tipo_visitante      = $_POST['tipo_visitante'] ?? '';
$empresa             = $_POST['empresa'] ?? '';
$telefono            = $_POST['telefono'] ?? '';
$correo_electronico  = $_POST['correo_electronico'] ?? '';
$fecha_ingreso       = $_POST['fecha_ingreso'] ?? '';
$hora_ingreso        = $_POST['hora_ingreso'] ?? '';
$fecha_salida        = $_POST['fecha_salida'] ?? '';
$hora_salida         = $_POST['hora_salida'] ?? '';
$destino             = $_POST['destino'] ?? '';
$otro_destino        = $_POST['otro_destino'] ?? '';
$autoriza            = $_POST['autoriza'] ?? '';
$observaciones       = $_POST['observaciones'] ?? '';

// Validación simple (solo nombre, documento y tipo son obligatorios)
if (empty($nombre_completo) || empty($documento) || empty($tipo_visitante)) {
    echo "<script>alert('Por favor completa al menos los campos obligatorios: Nombre, Documento y Tipo'); window.history.back();</script>";
    exit();
}

// Sentencia SQL preparada
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
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssss",
    $nombre_completo,
    $documento,
    $tipo_visitante,
    $empresa,
    $telefono,
    $correo_electronico,
    $fecha_ingreso,
    $hora_ingreso,
    $fecha_salida,
    $hora_salida,
    $destino,
    $otro_destino,
    $autoriza,
    $observaciones
);

if ($stmt->execute()) {
    echo "<script>alert('✅ Registro guardado correctamente'); window.location.href = '../frontend/index.html';</script>";
} else {
    echo "❌ Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

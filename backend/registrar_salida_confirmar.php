<?php
// backend/registrar_salida_confirmar.php

require 'conexion.php';
date_default_timezone_set('America/Bogota');

$id_visitante = intval($_POST['id_visitante'] ?? 0);

if ($id_visitante <= 0) {
    die("<p>ID de visitante inválido. <a href='../frontend/salida.html'>Volver</a></p>");
}

// Buscar visitante para mostrar nombre
$sql = "SELECT nombre_completo FROM visitantes WHERE id = ? AND (fecha_salida IS NULL OR hora_salida IS NULL)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("<p>Error en la preparación de la consulta: " . htmlspecialchars($conn->error) . "</p>");
}
$stmt->bind_param('i', $id_visitante);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<p>Visitante no encontrado o ya tiene salida registrada. <a href='../frontend/salida.html'>Volver</a></p>");
}

$visitante = $result->fetch_assoc();

$fechaSalida = date('Y-m-d');
$horaSalida = date('H:i:s');

$updateSql = "UPDATE visitantes SET fecha_salida = ?, hora_salida = ? WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
if (!$updateStmt) {
    die("<p>Error en la preparación de la actualización: " . htmlspecialchars($conn->error) . "</p>");
}
$updateStmt->bind_param('ssi', $fechaSalida, $horaSalida, $id_visitante);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Confirmar Registro de Salida</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    :root {
      --verde-corporativo: #006837;
    }
    .btn-corporativo {
      background-color: var(--verde-corporativo);
      color: white;
      border: none;
    }
    .btn-corporativo:hover {
      background-color: #004d2f;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <?php if ($updateStmt->execute()): ?>
      <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Salida registrada correctamente</h4>
        <p><strong><?= htmlspecialchars($visitante['nombre_completo']) ?></strong></p>
        <hr>
        <p class="mb-0">Fecha y hora de salida: <strong><?= $fechaSalida . ' ' . $horaSalida ?></strong></p>
      </div>
      <a href="../frontend/salida.html" class="btn btn-corporativo">Registrar otra salida</a>
      <a href="../frontend/index.html" class="btn btn-secondary ms-2">Volver al inicio</a>
    <?php else: ?>
      <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Error al registrar la salida</h4>
        <p><?= htmlspecialchars($conn->error) ?></p>
      </div>
      <a href="../frontend/salida.html" class="btn btn-secondary">Volver</a>
    <?php endif; ?>
  </div>
</body>
</html>

<?php
$updateStmt->close();
$stmt->close();
$conn->close();
?>

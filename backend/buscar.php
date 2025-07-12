<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir conexión a la base de datos
require 'conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener parámetros GET y sanitizar
$documento = isset($_GET['documento']) ? trim($_GET['documento']) : '';
$nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';

$where = [];
$params = [];
$tipos = '';

// Construir condiciones dinámicas
if ($documento !== '') {
    $where[] = "documento LIKE ?";
    $params[] = "%$documento%";
    $tipos .= 's';
}
if ($nombre !== '') {
    $where[] = "nombre_completo LIKE ?";
    $params[] = "%$nombre%";
    $tipos .= 's';
}

$whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT nombre_completo, documento, fecha_ingreso, hora_ingreso, fecha_salida, hora_salida
        FROM visitantes
        $whereSql
        ORDER BY fecha_ingreso DESC";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular parámetros si existen
if ($params) {
    // bind_param requiere variables, no valores directos, por eso usamos referencia con ...
    $stmt->bind_param($tipos, ...$params);
}

if (!$stmt->execute()) {
    die("Error en la ejecución de la consulta: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Resultados de Búsqueda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 900px;
      margin-top: 40px;
      padding: 20px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h2 {
      color: #006837;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
    }
    .btn-volver {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Resultados de Búsqueda</h2>
    <a href="../frontend/buscar_formulario.html" class="btn btn-secondary btn-volver">Nueva búsqueda</a>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-success">
            <tr>
              <th>Nombre Completo</th>
              <th>Documento</th>
              <th>Fecha Ingreso</th>
              <th>Hora Ingreso</th>
              <th>Fecha Salida</th>
              <th>Hora Salida</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['nombre_completo']) ?></td>
                <td><?= htmlspecialchars($row['documento']) ?></td>
                <td><?= htmlspecialchars($row['fecha_ingreso']) ?></td>
                <td><?= htmlspecialchars($row['hora_ingreso']) ?></td>
                <td><?= htmlspecialchars($row['fecha_salida'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['hora_salida'] ?? '-') ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-warning" role="alert">
        No se encontraron registros que coincidan con la búsqueda.
      </div>
    <?php endif; ?>
  </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

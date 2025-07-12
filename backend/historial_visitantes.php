<?php
// backend/historial_visitantes.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'conexion.php'; // Ajusta la ruta si tu archivo de conexión está en otro lugar

// Obtener y sanitizar parámetros
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';
$mes = $_GET['mes'] ?? '';
$empresa = trim($_GET['empresa'] ?? '');
$nombre = trim($_GET['nombre'] ?? '');
$destino = trim($_GET['area'] ?? '');  // Nota: el formulario sigue enviando 'area' pero aquí lo usamos para filtrar 'destino'

$where = [];
$params = [];
$tipos = '';

// Filtros
if ($fecha_inicio !== '') {
    $where[] = "fecha_ingreso >= ?";
    $params[] = $fecha_inicio;
    $tipos .= 's';
}
if ($fecha_fin !== '') {
    $where[] = "fecha_ingreso <= ?";
    $params[] = $fecha_fin;
    $tipos .= 's';
}
if ($mes !== '') {
    $where[] = "DATE_FORMAT(fecha_ingreso, '%Y-%m') = ?";
    $params[] = $mes;
    $tipos .= 's';
}
if ($empresa !== '') {
    $where[] = "empresa LIKE ?";
    $params[] = "%$empresa%";
    $tipos .= 's';
}
if ($nombre !== '') {
    $where[] = "nombre_completo LIKE ?";
    $params[] = "%$nombre%";
    $tipos .= 's';
}
if ($destino !== '') {
    $where[] = "destino LIKE ?";
    $params[] = "%$destino%";
    $tipos .= 's';
}

$whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT nombre_completo, documento, empresa, destino, tipo_visitante, fecha_ingreso, hora_ingreso, fecha_salida, hora_salida
        FROM visitantes
        $whereSql
        ORDER BY fecha_ingreso DESC, hora_ingreso DESC";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

if ($params) {
    $stmt->bind_param($tipos, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Historial de Visitantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 1100px;
      margin-top: 40px;
      padding: 30px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h2 {
      color: #006837;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Historial de Visitantes</h2>
    <a href="../frontend/historial_visitantes.html" class="btn btn-secondary mb-3">Nueva búsqueda</a>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-success">
            <tr>
              <th>Nombre Completo</th>
              <th>Documento</th>
              <th>Empresa</th>
              <th>Destino (Área Visitada)</th>
              <th>Tipo Visitante</th>
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
                <td><?= htmlspecialchars($row['empresa']) ?></td>
                <td><?= htmlspecialchars($row['destino']) ?></td>
                <td><?= htmlspecialchars($row['tipo_visitante']) ?></td>
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
        No se encontraron registros que coincidan con los filtros seleccionados.
      </div>
    <?php endif; ?>
  </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

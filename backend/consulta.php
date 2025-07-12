<?php
require 'conexion.php';

$documento = $_GET['documento'] ?? '';
$nombre = $_GET['nombre'] ?? '';

$where = [];
$params = [];
$tipos = '';

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
  <title>Resultados de Consulta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">
  <h2>Resultados de Consulta</h2>
  <a href="../consulta.html" class="btn btn-secondary mb-3">Nueva búsqueda</a>
  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered">
      <thead>
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
  <?php else: ?>
    <p>No se encontraron registros que coincidan con la búsqueda.</p>
  <?php endif; ?>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

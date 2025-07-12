<?php
// backend/historial_busqueda_unica.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'conexion.php';

$termino = trim($_GET['termino'] ?? '');

if ($termino === '') {
    die("Debe ingresar un término de búsqueda.");
}

$likeTerm = "%$termino%";

$sql = "
SELECT nombre_completo, documento, empresa, destino, tipo_visitante, fecha_ingreso, hora_ingreso, fecha_salida, hora_salida
FROM visitantes
WHERE 
    nombre_completo LIKE ? OR
    empresa LIKE ? OR
    destino LIKE ? OR
    tipo_visitante LIKE ? OR
    DATE_FORMAT(fecha_ingreso, '%Y-%m-%d') LIKE ? OR
    DATE_FORMAT(fecha_ingreso, '%Y-%m') LIKE ? OR
    DATE_FORMAT(fecha_salida, '%Y-%m-%d') LIKE ? OR
    DATE_FORMAT(fecha_salida, '%Y-%m') LIKE ?
ORDER BY fecha_ingreso DESC, hora_ingreso DESC
";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param('ssssssss', $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Resultados Búsqueda Historial</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f8f9fa; }
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
    <h2>Resultados de Búsqueda en Historial</h2>
    <a href="../frontend/historial_busqueda_unica.html" class="btn btn-secondary mb-3">Nueva búsqueda</a>

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
        No se encontraron registros que coincidan con el término ingresado.
      </div>
    <?php endif; ?>
  </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

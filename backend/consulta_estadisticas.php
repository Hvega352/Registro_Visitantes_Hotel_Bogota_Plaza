<?php
// Activar reporte completo de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registro_visitantes";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Obtener parámetros GET y sanitizar
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
$tipo_visitante = isset($_GET['tipo_visitante']) ? $_GET['tipo_visitante'] : '';

// Validar formato de fechas (YYYY-MM-DD)
function validarFecha($fecha) {
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    return $d && $d->format('Y-m-d') === $fecha;
}

$where = [];
$params = [];
$tipos = '';

// Validar y agregar filtro fecha_inicio
if ($fecha_inicio !== '' && validarFecha($fecha_inicio)) {
    $where[] = "fecha_ingreso >= ?";
    $params[] = $fecha_inicio;
    $tipos .= 's';
} else if ($fecha_inicio !== '') {
    die("Fecha de inicio inválida.");
}

// Validar y agregar filtro fecha_fin
if ($fecha_fin !== '' && validarFecha($fecha_fin)) {
    $where[] = "fecha_ingreso <= ?";
    $params[] = $fecha_fin;
    $tipos .= 's';
} else if ($fecha_fin !== '') {
    die("Fecha de fin inválida.");
}

// Agregar filtro tipo_visitante si se especifica y no es vacío
if ($tipo_visitante !== '') {
    $where[] = "tipo_visitante = ?";
    $params[] = $tipo_visitante;
    $tipos .= 's';
}

// Construir cláusula WHERE
$whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

// Preparar consulta SQL
$sql = "SELECT nombre_completo, documento, fecha_ingreso, hora_ingreso, fecha_salida, hora_salida, tipo_visitante
        FROM visitantes
        $whereSql
        ORDER BY fecha_ingreso DESC";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular parámetros si hay
if ($params) {
    $stmt->bind_param($tipos, ...$params);
}

// Ejecutar consulta
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Resultados de Consulta Estadísticas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">
  <h2>Resultados de Consulta Estadísticas</h2>
  <a href="../frontend/consulta_estadisticas.html" class="btn btn-secondary mb-3">Nueva consulta</a>

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-striped table-bordered">
      <thead class="table-success">
        <tr>
          <th>Nombre Completo</th>
          <th>Documento</th>
          <th>Tipo de Visitante</th>
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
            <td><?= htmlspecialchars($row['tipo_visitante']) ?></td>
            <td><?= htmlspecialchars($row['fecha_ingreso']) ?></td>
            <td><?= htmlspecialchars($row['hora_ingreso']) ?></td>
            <td><?= htmlspecialchars($row['fecha_salida'] ?? '-') ?></td>
            <td><?= htmlspecialchars($row['hora_salida'] ?? '-') ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-warning" role="alert">
      No se encontraron registros que coincidan con los criterios de búsqueda.
    </div>
  <?php endif; ?>

</body>
</html>

<?php
// Cerrar conexiones
$stmt->close();
$conn->close();
?>

<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "registro_visitantes";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM visitantes ORDER BY id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Visitantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root {
      --verde-corporativo: #006837;
    }

    .titulo-corporativo {
      color: var(--verde-corporativo);
    }

    .btn-corporativo {
      background-color: var(--verde-corporativo);
      color: white;
      border: none;
    }

    .btn-corporativo:hover {
      background-color: #004d2f;
    }

    @media print {
      @page {
        size: A4 landscape;
        margin: 10mm;
      }

      html, body {
        width: 100%;
        height: 100%;
        font-size: 10px;
      }

      .btn, .text-end {
        display: none !important;
      }

      .logo-print {
        max-height: 60px;
        margin-bottom: 10px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
      }

      th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: left;
        vertical-align: top;
        word-wrap: break-word;
        font-size: 9px;
      }

      th {
        background-color: #f2f2f2;
      }

      th.observaciones-col, td.observaciones-col {
        max-width: 200px;
        white-space: pre-wrap;
      }
    }
  </style>
</head>
<body class="bg-light">
  <div class="container mt-4">
    <div class="text-center mb-3">
      <img src="../assets/logo.png" class="logo-print" alt="Logo del Hotel Bogotá Plaza">
      <h3 class="titulo-corporativo">Listado de Visitantes - Hotel Bogotá Plaza</h3>
    </div>

    <div class="text-end mb-3">
      <a href="../frontend/index.html" class="btn btn-corporativo">← Volver</a>
      <a href="exportar.php" class="btn btn-corporativo">📥 Exportar a Excel</a>
      <button onclick="alertaPDF()" class="btn btn-corporativo">🧾 Exportar a PDF</button>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover">
        <thead class="text-center">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>Tipo</th>
            <th>Empresa</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Ingreso</th>
            <th>Salida</th>
            <th>Destino</th>
            <th>Cuál otro</th>
            <th>Autoriza</th>
            <th class="observaciones-col">Observaciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . ($fila['id'] ?? '-') . "</td>";
              echo "<td>" . ($fila['nombre_completo'] ?? '-') . "</td>";
              echo "<td>" . ($fila['documento'] ?? '-') . "</td>";
              echo "<td>" . ($fila['tipo_visitante'] ?? '-') . "</td>";
              echo "<td>" . ($fila['empresa'] ?? '-') . "</td>";
              echo "<td>" . ($fila['telefono'] ?? '-') . "</td>";
              echo "<td>" . ($fila['correo_electronico'] ?? '-') . "</td>";
              echo "<td>" . ($fila['fecha_ingreso'] ?? '-') . " " . ($fila['hora_ingreso'] ?? '-') . "</td>";
              echo "<td>" . ($fila['fecha_salida'] ?? '-') . " " . ($fila['hora_salida'] ?? '-') . "</td>";
              echo "<td>" . ($fila['destino'] ?? '-') . "</td>";
              echo "<td>" . ($fila['otro_destino'] ?? '-') . "</td>";
              echo "<td>" . ($fila['autoriza'] ?? '-') . "</td>";
              echo "<td class='observaciones-col'>" . ($fila['observaciones'] ?? '-') . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='13' class='text-center'>No hay registros disponibles.</td></tr>";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function alertaPDF() {
      alert("📄 Recuerda: antes de guardar como PDF, selecciona 'Orientación horizontal (Paisaje)' en el cuadro de impresión.");
      window.print();
    }
  </script>
</body>
</html>

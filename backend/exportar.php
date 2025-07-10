<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "registro_visitantes";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=visitantes_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM visitantes ORDER BY id DESC";
$resultado = $conn->query($sql);

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>Tipo</th>
        <th>Empresa</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Fecha Ingreso</th>
        <th>Hora Ingreso</th>
        <th>Fecha Salida</th>
        <th>Hora Salida</th>
        <th>Destino</th>
        <th>Otro Destino</th>
        <th>Autoriza</th>
        <th>Observaciones</th>
      </tr>";

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
        echo "<td>" . ($fila['fecha_ingreso'] ?? '-') . "</td>";
        echo "<td>" . ($fila['hora_ingreso'] ?? '-') . "</td>";
        echo "<td>" . ($fila['fecha_salida'] ?? '-') . "</td>";
        echo "<td>" . ($fila['hora_salida'] ?? '-') . "</td>";
        echo "<td>" . ($fila['destino'] ?? '-') . "</td>";
        echo "<td>" . ($fila['otro_destino'] ?? '-') . "</td>";
        echo "<td>" . ($fila['autoriza'] ?? '-') . "</td>";
        echo "<td>" . ($fila['observaciones'] ?? '-') . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='15'>No hay registros disponibles.</td></tr>";
}
echo "</table>";

$conn->close();
?>

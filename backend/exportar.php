<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "registro_visitantes";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Cabeceras para forzar descarga Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=visitantes_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Cambia a ASC para que el primer registro sea el primero
$sql = "SELECT * FROM visitantes ORDER BY id ASC";
$resultado = $conn->query($sql);

echo "<table border='1'>";
echo "<tr>
        <th>N.º</th> <!-- Columna número -->
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
        <th>Autoriza</th>
        <th>Observaciones</th>
      </tr>";

if ($resultado->num_rows > 0) {
    $contador = 1; // contador para la numeración
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $contador . "</td>";  // Imprime número secuencial
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
        echo "<td>" . ($fila['autoriza'] ?? '-') . "</td>";
        echo "<td>" . ($fila['observaciones'] ?? '-') . "</td>";
        echo "</tr>";
        $contador++;
    }
} else {
    echo "<tr><td colspan='15'>No hay registros disponibles.</td></tr>";
}
echo "</table>";

$conn->close();
?>

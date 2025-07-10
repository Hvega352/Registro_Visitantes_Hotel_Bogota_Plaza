<?php
// Mostrar errores para depuración (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión
require 'conexion.php';

// Consulta para obtener todos los visitantes
$sql = "SELECT * FROM visitantes ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Consulta de Visitantes - Hotel Bogotá Plaza</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f2f2f2;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #003366;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #e9e9e9;
        }
        caption {
            caption-side: top;
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #003366;
        }
    </style>
</head>
<body>
    <table>
        <caption>Listado de Visitantes - Hotel Bogotá Plaza</caption>
        <thead>
            <tr>
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
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_completo']); ?></td>
                        <td><?php echo htmlspecialchars($row['documento']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_visitante']); ?></td>
                        <td><?php echo htmlspecialchars($row['empresa']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['correo_electronico']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_ingreso']); ?></td>
                        <td><?php echo htmlspecialchars($row['hora_ingreso']); ?></td>
                        <td><?php echo !empty($row['fecha_salida']) ? htmlspecialchars($row['fecha_salida']) : '-'; ?></td>
                        <td><?php echo !empty($row['hora_salida']) ? htmlspecialchars($row['hora_salida']) : '-'; ?></td>
                        <td><?php echo htmlspecialchars($row['destino']); ?></td>
                        <td><?php echo htmlspecialchars($row['autoriza']); ?></td>
                        <td><?php echo htmlspecialchars($row['observaciones']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14" style="text-align:center;">No hay registros disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>

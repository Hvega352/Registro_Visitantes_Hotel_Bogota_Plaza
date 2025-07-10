<?php
require 'conexion.php'; // Ajusta la ruta según tu proyecto

// Consulta total de visitantes
$sql_total = "SELECT COUNT(*) AS total_visitantes FROM visitantes";
$result_total = $conn->query($sql_total);
$total_visitantes = ($result_total && $result_total->num_rows > 0) ? $result_total->fetch_assoc()['total_visitantes'] : 0;

// Consulta visitantes por tipo
$sql_tipo = "SELECT tipo_visitante, COUNT(*) AS cantidad FROM visitantes GROUP BY tipo_visitante";
$result_tipo = $conn->query($sql_tipo);

// Consulta visitantes por empresa (top 5)
$sql_empresa = "SELECT empresa, COUNT(*) AS cantidad FROM visitantes GROUP BY empresa ORDER BY cantidad DESC LIMIT 5";
$result_empresa = $conn->query($sql_empresa);

// Puedes agregar más consultas según lo que necesites

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Visitantes</title>
    <link rel="stylesheet" href="ruta/a/tu/estilos.css"> <!-- Ajusta si usas CSS -->
</head>
<body>
    <h1>Estadísticas de Visitantes - Hotel Bogotá Plaza</h1>

    <h2>Total de Visitantes</h2>
    <p><strong><?php echo $total_visitantes; ?></strong></p>

    <h2>Visitantes por Tipo</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Tipo de Visitante</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_tipo && $result_tipo->num_rows > 0) {
                while ($row = $result_tipo->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['tipo_visitante']) . "</td>";
                    echo "<td>" . $row['cantidad'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No hay datos disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Top 5 Empresas con Más Visitantes</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_empresa && $result_empresa->num_rows > 0) {
                while ($row = $result_empresa->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['empresa']) . "</td>";
                    echo "<td>" . $row['cantidad'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No hay datos disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

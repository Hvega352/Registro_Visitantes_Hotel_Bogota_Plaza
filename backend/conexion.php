<?php
// Configuración de conexión a la base de datos
$servername = "localhost";      
$username = "root";             
$password = "Vega1429*";                 
$dbname = "registro_visitantes";  // Nombre exacto de tu base de datos

// Crea conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>

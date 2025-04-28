<?php
// filepath: d:\UNI\7MO SEMESTRE\hackaton\cntrlz\hackaton1-2025\db.php

// Configuración de la base de datos
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'nombre_de_tu_base_de_datos'; // Reemplaza con el nombre de tu base de datos
$username = 'root'; // Reemplaza con tu usuario de la base de datos
$password = '13246579801coco'; // Reemplaza con tu contraseña

try {
    // Crear una conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el modo de error de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejar errores de conexión
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
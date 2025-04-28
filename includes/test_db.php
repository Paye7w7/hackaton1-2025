<?php
// filepath: d:\UNI\7MO SEMESTRE\hackaton\cntrlz\hackaton1-2025\test_db.php

require 'db.php';

if ($pdo) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos.";
}
?>
<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/hackaton1-2025/includes/db.php';

// Obtener el nombre del usuario si está en sesión
if (isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
    $stmt = $pdo->prepare("SELECT nombre FROM Usuario WHERE idUsuario = :idUsuario");
    $stmt->execute([':idUsuario' => $idUsuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreUsuario = $usuario['nombre'] ?? 'Invitado';
} else {
    $nombreUsuario = 'Invitado';
}
?>

<nav class="navbar">
    <div class="navbar-brand">
        <a href="#">Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></a>
    </div>
    <ul class="navbar-links">
        <li><a href="../../logout.php">Cerrar Sesión</a></li>
    </ul>
</nav>
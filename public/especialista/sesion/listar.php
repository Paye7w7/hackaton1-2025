<?php
include '../../../includes/junteEsp.php';
require_once '../../../includes/db.php';

// Verificar si la sesión no está activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    header('Location: ../../login.php');
    exit;
}

// Consultar sesiones con estado "pendiente"
$queryPendientes = "
    SELECT * 
    FROM vista_usuario_sesion_detallada
    WHERE estado = 'pendiente'
";
$stmtPendientes = $pdo->prepare($queryPendientes);
$stmtPendientes->execute();
$sesionesPendientes = $stmtPendientes->fetchAll(PDO::FETCH_ASSOC);

// Consultar sesiones con estado "atendido"
$queryAtendidas = "
    SELECT * 
    FROM vista_usuario_sesion_detallada
    WHERE estado = 'atendido'
";
$stmtAtendidas = $pdo->prepare($queryAtendidas);
$stmtAtendidas->execute();
$sesionesAtendidas = $stmtAtendidas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Sesiones</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Sesiones</h1>
        <div class="row">
            <!-- Columna de sesiones pendientes -->
            <div class="column">
                <h2>Pendientes</h2>
                <?php if (!empty($sesionesPendientes)): ?>
                    <?php foreach ($sesionesPendientes as $sesion): ?>
                        <div class="card">
                            <h3>Sesión #<?php echo htmlspecialchars($sesion['idSesion']); ?></h3>
                            <p>Fecha: <?php echo htmlspecialchars($sesion['fechaSesion']); ?></p>
                            <p>Usuario: <?php echo htmlspecialchars($sesion['nombreCompleto']); ?></p>
                            <button onclick="location.href='detalle.php?idSesion=<?php echo $sesion['idSesion']; ?>'">Abrir</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay sesiones pendientes.</p>
                <?php endif; ?>
            </div>

            <!-- Columna de sesiones atendidas -->
            <div class="column">
                <h2>Atendidas</h2>
                <?php if (!empty($sesionesAtendidas)): ?>
                    <?php foreach ($sesionesAtendidas as $sesion): ?>
                        <div class="card">
                            <h3>Sesión #<?php echo htmlspecialchars($sesion['idSesion']); ?></h3>
                            <p>Fecha: <?php echo htmlspecialchars($sesion['fechaSesion']); ?></p>
                            <p>Usuario: <?php echo htmlspecialchars($sesion['nombreCompleto']); ?></p>
                            <button onclick="location.href='detalle.php?idSesion=<?php echo $sesion['idSesion']; ?>'">Abrir</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay sesiones atendidas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../../../includes/footer.php'; ?>
</body>
</html>

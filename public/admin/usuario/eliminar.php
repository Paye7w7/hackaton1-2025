<?php
require_once '../../../includes/db.php';

$idUsuario = $_GET['idUsuario'] ?? null;

if ($idUsuario) {
    try {
        $query = "DELETE FROM Usuario WHERE idUsuario = :idUsuario";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':idUsuario' => $idUsuario]);
        echo "<script>alert('Usuario eliminado exitosamente'); location.href='listar.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al eliminar usuario: " . $e->getMessage() . "'); location.href='listar.php';</script>";
    }
} else {
    echo "<script>alert('ID de usuario no proporcionado'); location.href='listar.php';</script>";
}
?>
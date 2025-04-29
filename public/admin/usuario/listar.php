<?php
include '../../../includes/junte.php';
require_once '../../../includes/db.php';

try {
    // Ajuste del query para incluir el nombre del rol y ordenar por el más reciente
    $query = "SELECT Usuario.*, Rol.nombreRol 
              FROM Usuario 
              INNER JOIN Rol ON Usuario.idRol = Rol.idRol
              ORDER BY Usuario.idUsuario DESC"; // Ordenar por ID en orden descendente
    $stmt = $pdo->query($query);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error al obtener usuarios: " . $e->getMessage() . "');</script>";
}
?>

<div>
    <a href="agregar.php" style="display: inline-block; margin-bottom: 15px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Agregar Nuevo Usuario</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Rol</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>CI</th>
            <th>Celular</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['idUsuario']; ?></td>
                <td><?php echo $usuario['nombreRol']; ?></td> <!-- Mostrar el nombre del rol -->
                <td><?php echo $usuario['nombre'] . ' ' . $usuario['apellidoP'] . ' ' . $usuario['apellidoM']; ?></td>
                <td><?php echo $usuario['correo']; ?></td>
                <td><?php echo $usuario['ci']; ?></td>
                <td><?php echo $usuario['celular']; ?></td>
                <td>
                    <a href="editar.php?idUsuario=<?php echo $usuario['idUsuario']; ?>">Editar</a>
                    <a href="eliminar.php?idUsuario=<?php echo $usuario['idUsuario']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>
    </div>

    <!-- Footer -->
    <?php include '../../../includes/footer.php'; ?>
</body>
</html>
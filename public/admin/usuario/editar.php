<?php
include '../../../includes/junte.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hackaton1-2025/includes/db.php';

$idUsuario = $_GET['idUsuario'] ?? null;

if (!$idUsuario) {
    echo "<script>alert('ID de usuario no proporcionado'); location.href='listar.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idRol = $_POST['idRol'];
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'];
    $correo = $_POST['correo'];
    $ci = $_POST['ci'];
    $celular = $_POST['celular'];
    $fechaNacimiento = $_POST['fechaNacimiento'];

    try {
        $query = "UPDATE Usuario SET idRol = :idRol, nombre = :nombre, apellidoP = :apellidoP, apellidoM = :apellidoM, 
                  correo = :correo, ci = :ci, celular = :celular, fechaNacimiento = :fechaNacimiento 
                  WHERE idUsuario = :idUsuario";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':idRol' => $idRol,
            ':nombre' => $nombre,
            ':apellidoP' => $apellidoP,
            ':apellidoM' => $apellidoM,
            ':correo' => $correo,
            ':ci' => $ci,
            ':celular' => $celular,
            ':fechaNacimiento' => $fechaNacimiento,
            ':idUsuario' => $idUsuario,
        ]);
        echo "<script>alert('Usuario actualizado exitosamente'); location.href='listar.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al actualizar usuario: " . $e->getMessage() . "');</script>";
    }
} else {
    $stmt = $pdo->prepare("SELECT * FROM Usuario WHERE idUsuario = :idUsuario");
    $stmt->execute([':idUsuario' => $idUsuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener los roles disponibles
    $stmtRoles = $pdo->query("SELECT idRol, nombreRol FROM Rol");
    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
}
?>

<body>
    <form method="POST">
        <label for="idRol">Rol:</label>
        <select name="idRol" required>
            <?php foreach ($roles as $rol): ?>
                <option value="<?php echo $rol['idRol']; ?>" <?php echo $rol['idRol'] == $usuario['idRol'] ? 'selected' : ''; ?>>
                    <?php echo $rol['nombreRol']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        <label for="apellidoP">Apellido Paterno:</label>
        <input type="text" name="apellidoP" value="<?php echo $usuario['apellidoP']; ?>" required>
        <label for="apellidoM">Apellido Materno:</label>
        <input type="text" name="apellidoM" value="<?php echo $usuario['apellidoM']; ?>" required>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required>
        <label for="ci">CI:</label>
        <input type="text" name="ci" value="<?php echo $usuario['ci']; ?>" required>
        <label for="celular">Celular:</label>
        <input type="text" name="celular" value="<?php echo $usuario['celular']; ?>" required>
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fechaNacimiento" value="<?php echo $usuario['fechaNacimiento']; ?>" required>
        <button type="submit">Actualizar Usuario</button>
    </form>
</body>
</html>
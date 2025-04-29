<?php
include '../../../includes/junte.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hackaton1-2025/includes/db.php';

// Obtener los roles disponibles
$stmtRoles = $pdo->query("SELECT idRol, nombreRol FROM Rol");
$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idRol = $_POST['idRol'];
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'];
    $correo = $_POST['correo'];
    $ci = $_POST['ci'];
    $celular = $_POST['celular'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    try {
        $query = "INSERT INTO Usuario (idRol, nombre, apellidoP, apellidoM, correo, ci, celular, fechaNacimiento, contrasena) 
                  VALUES (:idRol, :nombre, :apellidoP, :apellidoM, :correo, :ci, :celular, :fechaNacimiento, :contrasena)";
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
            ':contrasena' => $contrasena,
        ]);
        echo "<script>alert('Usuario agregado exitosamente'); location.href='listar.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al agregar usuario: " . $e->getMessage() . "');</script>";
    }
}
?>

<body>
    <form method="POST">
        <label for="idRol">Rol:</label>
        <select name="idRol" required>
            <option value="">Seleccione un rol</option>
            <?php foreach ($roles as $rol): ?>
                <option value="<?php echo $rol['idRol']; ?>"><?php echo $rol['nombreRol']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <label for="apellidoP">Apellido Paterno:</label>
        <input type="text" name="apellidoP" required>
        <label for="apellidoM">Apellido Materno:</label>
        <input type="text" name="apellidoM" required>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <label for="ci">CI:</label>
        <input type="text" name="ci" required>
        <label for="celular">Celular:</label>
        <input type="text" name="celular" required>
        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fechaNacimiento" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <button type="submit">Agregar Usuario</button>
    </form>
</body>
</html>
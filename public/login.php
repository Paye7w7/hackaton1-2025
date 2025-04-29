<?php
// Iniciar sesión
session_start();

// Incluir la conexión a la base de datos
require_once '../includes/db.php';

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    // Validar que los campos no estén vacíos
    if (!empty($correo) && !empty($contrasena)) {
        try {
            // Consultar si el usuario existe con el correo y la contraseña
            $query = "SELECT idUsuario, idRol FROM Usuario WHERE correo = :correo AND contrasena = :contrasena";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR); // Aquí asumimos que las contraseñas no están encriptadas
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $idRol = $user['idRol'];
                $idUsuario = $user['idUsuario'];

                // Guardar el idUsuario en la sesión
                $_SESSION['idUsuario'] = $idUsuario;

                // Redirigir según el rol del usuario
                if ($idRol == 1) {
                    echo "<script language='JavaScript'>
                        alert('Inicio de sesión exitoso. Bienvenido Especialista.');
                        location.assign('../public/especialista/index.php');
                        </script>";
                } elseif ($idRol == 2) {
                    echo "<script language='JavaScript'>
                        alert('Inicio de sesión exitoso. Bienvenido Estudiante.');
                        location.assign('../public/estudiante/index.php');
                        </script>";
                } elseif ($idRol == 3) {
                    echo "<script language='JavaScript'>
                        alert('Inicio de sesión exitoso. Bienvenido Administrador.');
                        location.assign('../public/admin/index.php');
                        </script>";
                } else {
                    echo "<script language='JavaScript'>
                        alert('Rol desconocido.');
                        location.assign('index.php');
                        </script>";
                }
            } else {
                echo "<script language='JavaScript'>
                    alert('Datos incorrectos o el usuario no existe.');
                    location.assign('index.php');
                    </script>";
            }
        } catch (PDOException $e) {
            echo "<script language='JavaScript'>
                alert('Error al consultar la base de datos: " . $e->getMessage() . "');
                location.assign('index.php');
                </script>";
        }
    } else {
        echo "<script language='JavaScript'>
            alert('Por favor, completa todos los campos.');
            location.assign('index.php');
            </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio de Sesión | cntrl z</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="wrapper">
    <form action="" method="POST">
      <h2>Inicio de Sesión</h2>
      <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
      <?php endif; ?>
      <div class="input-field">
        <input type="text" name="correo" required>
        <label>Ingresa tu correo</label>
      </div>
      <div class="input-field">
        <input type="password" name="contrasena" required>
        <label>Ingresa tu contraseña</label>
      </div>
      <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember">
          <p>Recuérdame</p>
        </label>
        <a href="#">¿Olvidaste tu contraseña?</a>
      </div>
      <button type="submit">Iniciar Sesión</button>
      <div class="register">
        <p>¿No tienes una cuenta? <a href="#">Regístrate</a></p>
      </div>
    </form>
  </div>
</body>
</html>
<?php
session_start();
include "db/conexion.php";

if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $resultado = $conexion->query($sql);
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        header("Location: dashboard.php");
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login | Gestor de Gastos</title>

  <!-- Bootstrap LOCAL -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">GestiGastos</a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <div class="card shadow p-4">
        <h3 class="text-center mb-3">Iniciar Sesión</h3>

        <?php if (isset($error)): ?>
          <div class="alert alert-danger text-center">
            <?php echo $error; ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button class="btn btn-success w-100">Ingresar</button>
        </form>

        <p class="text-center mt-3">
          ¿No tienes cuenta? <a href="register.php">Regístrate</a>
        </p>

      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS LOCAL -->
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

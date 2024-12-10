<?php
session_start();
include '../db.php';

// Manejo del inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $query->execute([$username]);
    $admin = $query->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Ingresar</button>
        
    </form>
    <a href="../frontend/index.php" class="back-button">← Volver</a>

    
</body>
</html>

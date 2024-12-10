<?php
include '../db.php'; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    

    try {

        $query = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $query->execute([$username, $password]);


        header("Location: index.php");
        exit; 
        
    } catch (PDOException $e) {
        die("Error al registrar administrador: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Administrador</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Administrador</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nombre de usuario</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="">Registrar</button>
        </form>
    <a href="../frontend/index.php" class="back-button">← Volver</a>
    </div>
</body>
</html>

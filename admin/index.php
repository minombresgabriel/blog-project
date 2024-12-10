<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['message'])) {
    echo "<p style='color: green; text-align: center;'>" . htmlspecialchars($_SESSION['message']) . "</p>";
    unset($_SESSION['message']); 
    
}

include '../db.php';


$query = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>Panel de Administración</h1>
    <div class="button-container">
    <a href="create.php" class="btn btn-create">Crear nueva publicación</a>
    <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
</div>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= $post['created_at'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $post['id'] ?>">Editar</a>
                        <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta publicación?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

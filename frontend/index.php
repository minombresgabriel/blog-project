<?php
include '../db.php';

$query = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Posts</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="main-header">
    <div class="container-menu">
        <a href="../admin/login.php" class="login-button">Iniciar Sesión</a>
        <a href="../admin/register_admin.php" class="login-button">Registro</a>

    </div>
</header>
    <div class="container">
        <h1 class="page-title">Publicaciones</h1>
        

        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <h2><?= htmlspecialchars($post['title']) ?></h2>
                    
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="post-image">
                    <?php endif; ?>
                    
                    <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 150))) ?>...</p>
                    <a href="post.php?id=<?= $post['id'] ?>" class="read-more">Leer más</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
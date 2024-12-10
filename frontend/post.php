<?php
include '../db.php';
$id = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$query->execute([$id]);
$post = $query->fetch();

if (!$post) {
    die("Publicación no encontrada.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <article class="post">
            <?php if (!empty($post['image'])): ?>
                <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="post-image">
            <?php endif; ?>

            <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        </article>
        <a href="index.php" class="back-button">← Volver</a>
    </div>
</body>
</html>
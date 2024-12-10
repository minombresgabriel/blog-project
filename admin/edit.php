<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';


$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$query->execute([$id]);
$post = $query->fetch();

if (!$post) {
    die("Publicación no encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $imagePath = $post['image']; 
    

    if (!empty($_FILES['image']['name'])) {

        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        $imageName = time() . '-' . basename($_FILES['image']['name']);
        $newImagePath = $uploadDir . $imageName;


        $imageType = mime_content_type($_FILES['image']['tmp_name']);
        if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], $newImagePath);


            if ($post['image'] && file_exists($post['image'])) {
                unlink($post['image']);
            }


            $imagePath = $newImagePath;
        } else {
            $error = "El formato de la imagen no es válido (solo JPG, PNG o GIF).";
        }
    }

    if (empty($title) || empty($content)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!isset($error)) {

        $query = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
        $query->execute([$title, $content, $imagePath, $id]);


        $_SESSION['message'] = "Publicación actualizada con éxito.";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Editar Publicación</h1>
    <form action="edit.php?id=<?= $post['id'] ?>" method="POST" enctype="multipart/form-data">
    <label for="title">Título:</label>
    <input type="text" name="title" id="title" value="<?= htmlspecialchars($post['title']) ?>" required>

    <label for="content">Contenido:</label>
    <textarea name="content" id="content" rows="5" required><?= htmlspecialchars($post['content']) ?></textarea>

    <label for="image">Imagen actual:</label><br>
    <?php if (!empty($post['image'])): ?>
        <img src="<?= htmlspecialchars($post['image']) ?>" alt="Imagen actual" style="max-width: 100px; height: auto;">
        <br>
    <?php endif; ?>
    <input type="file" name="image" id="image" accept="image/*">

    <button type="submit">Guardar cambios</button>
</form>

    <a href="index.php" class="back-button">Volver al panel</a>
</body>
</html>

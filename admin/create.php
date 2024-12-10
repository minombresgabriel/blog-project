<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $imagePath = null; 

    if (!empty($_FILES['image']['name'])) {
 
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = time() . '-' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        $imageType = mime_content_type($_FILES['image']['tmp_name']);
        if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        } else {
            $error = "El formato de la imagen no es válido (solo JPG, PNG o GIF).";
        }
    }

    if (empty($title) || empty($content)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!isset($error)) {
        $query = $pdo->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
        $query->execute([$title, $content, $imagePath]);


        $_SESSION['message'] = "Publicación creada con éxito.";
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
    <title>Crear Publicación</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Crear Publicación</h1>

    

    <form action="create.php" method="POST" enctype="multipart/form-data">
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <label for="title">Título:</label>
    <input type="text" name="title" id="title" required>

    <label for="content">Contenido:</label>
    <textarea name="content" id="content" rows="5" required ></textarea>

    <label for="image">Imagen:</label>
    <input type="file" name="image" id="image" accept="image/*">

    <button type="submit">Crear publicación</button>
</form>

    <a href="index.php" class="btn btn-logout">Volver al panel</a>
</body>
</html>

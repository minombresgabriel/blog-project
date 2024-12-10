<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

$id = $_GET['id'];
$query = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$query->execute([$id]);
$_SESSION['message'] = "Publicación eliminada con éxito.";

header("Location: index.php");
exit;
?>

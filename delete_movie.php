<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;
?>

<?php
require 'config.php';

$id = $_GET['id'];

$movie = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$movie->execute([$id]);
$movie = $movie->fetch();

if (!$movie) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie['title']) ?> - Movie Details</title>
    <link rel="stylesheet" href="css/detail_movie.css">
</head>
<body>
    <div class="container">
        <div class="poster">
            <img src="images/<?= htmlspecialchars($movie['image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
        </div>
        <div class="details">
            <h1><?= htmlspecialchars($movie['title']) ?></h1>
            <p><?= htmlspecialchars($movie['description']) ?></p>
            <p>Genre: <?= htmlspecialchars($movie['genre']) ?></p>
            <p>Release Date: <?= htmlspecialchars($movie['release_date']) ?></p>
            <a href="index.php">Back to Movies</a>
        </div>
    </div>
</body>
</html>

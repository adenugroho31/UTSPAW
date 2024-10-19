<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$id = $_GET['id'];

$movie = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$movie->execute([$id]);
$movie = $movie->fetch();

if (!$movie) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'] . '-01-01'; // Keep the same date format
    $genre = $_POST['genre'];

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $movie['image'];
    }

    $stmt = $pdo->prepare("UPDATE movies SET title = ?, description = ?, image = ?, release_date = ?, genre = ? WHERE id = ?");
    $stmt->execute([$title, $description, $image, $release_date, $genre, $id]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link rel="stylesheet" href="css/edit_movie.css">
</head>
<body>
    <div class="container">
        <h1>Edit Movie: <?= htmlspecialchars($movie['title']) ?></h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
            <textarea name="description" placeholder="Description"><?= htmlspecialchars($movie['description']) ?></textarea>
            <input type="file" name="image">
            <img src="images/<?= htmlspecialchars($movie['image']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>" width="100">
            <input type="number" name="release_date" placeholder="Release Year" min="1900" max="2099" step="1" required value="<?= substr($movie['release_date'], 0, 4) ?>">
            <input type="text" name="genre" placeholder="Genre" value="<?= htmlspecialchars($movie['genre']) ?>" required>
            <button type="submit">Update Movie</button>
        </form>
    </div>
</body>
</html>

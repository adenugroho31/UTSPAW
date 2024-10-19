<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'] . '-01-01';
    $genre = $_POST['genre'];

    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO movies (title, description, image, release_date, genre) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $image, $release_date, $genre]);
        header('Location: index.php');
        exit;
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <link rel="stylesheet" href="css/add_movie.css">
</head>
<body>
    <div class="container">
        <h1>Add a New Movie</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Movie Title" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="file" name="image" required>
            <input type="number" name="release_date" placeholder="Release Year" min="1900" max="2099" step="1" required>
            <input type="text" name="genre" placeholder="Genre" required>
            <button type="submit">Add Movie</button>
            <a href="index.php" class="back-btn">Back</a>
        </form>
    </div>
</body>
</html>

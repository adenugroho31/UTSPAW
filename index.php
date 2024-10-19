<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$movies = $pdo->query("SELECT * FROM movies")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Movies</h1>
            <div class="action-buttons">
                <a href="add_movie.php" class="add-movie">Add Movie</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </header>

        <table>
            <tr>
                <th>Title</th>
                <th>Genre</th>
                <th>Release Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($movies as $movie): ?>
            <tr>
                <td><?= htmlspecialchars($movie['title']) ?></td>
                <td><?= htmlspecialchars($movie['genre']) ?></td> <!-- Display Genre -->
                <td><?= htmlspecialchars($movie['release_date']) ?></td>
                <td>
                    <a href="edit_movie.php?id=<?= $movie['id'] ?>">Edit</a> |
                    <a href="delete_movie.php?id=<?= $movie['id'] ?>" onclick="return confirm('Are you sure you want to delete this movie?');">Delete</a> |
                    <a href="detail_movie.php?id=<?= $movie['id'] ?>">Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>

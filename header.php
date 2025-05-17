<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> RecipeVault </title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <header class="d-flex justify-content-between align-items-center mt-4">
        <h1>🍽️ RecipeVault</h1>
        <nav>
            <a href="index.php" class="mx-2">Home</a>
            <a href="search.php" class="mx-2">Search</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="add_recipe.php" class="mx-2">Add Recipe</a>
                <a href="logout.php" class="mx-2">Logout</a>
            <?php else: ?>
                <a href="login.php" class="mx-2">Login</a>
                <a href="register.php" class="mx-2">Register</a>
            <?php endif; ?>
        </nav>
    </header>

</div>

<hr>

</body>
</html>

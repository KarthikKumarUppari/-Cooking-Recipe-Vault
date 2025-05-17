<?php 
include "db.php"; 
include "includes/header.php"; 
?>

<h2>All Recipes</h2>

<?php
$sql = "SELECT * FROM recipes ORDER BY recipe_id DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div class='recipe'>";
    echo "<h3><a href='view_recipe.php?id=" . $row['recipe_id'] . "'>" . $row['title'] . "</a></h3>";
    echo "<p>Cuisine: " . $row['cuisine'] . " | Prep Time: " . $row['prep_time'] . " mins</p>";
    if ($row['image']) {
        echo "<img src='uploads/" . $row['image'] . "' width='200'>";
    }
    echo "</div><hr>";
}
include "includes/footer.php";
?>

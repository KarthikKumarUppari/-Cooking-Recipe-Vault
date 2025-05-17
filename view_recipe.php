<?php 
include "db.php"; 
include "includes/header.php"; 
//session_start();

$recipe_id = $_GET['id'];
$sql = "SELECT * FROM recipes WHERE recipe_id = $recipe_id";
$result = $conn->query($sql);
$recipe = $result->fetch_assoc();

echo "<h2>" . $recipe['title'] . "</h2>";
echo "<p><strong>Cuisine:</strong> " . $recipe['cuisine'] . "</p>";
echo "<p><strong>Ingredients:</strong><br>" . nl2br($recipe['ingredients']) . "</p>";
echo "<p><strong>Steps:</strong><br>" . nl2br($recipe['steps']) . "</p>";
echo "<p><strong>Nutrition:</strong><br>" . nl2br($recipe['nutrition']) . "</p>";
if ($recipe['image']) {
    echo "<img src='uploads/" . $recipe['image'] . "' width='300'>";
}

// Review Form
?>
<h3>Leave a Review</h3>
<form method="POST">
    <input type="number" name="rating" min="1" max="5" required><br>
    <textarea name="comment" placeholder="Your comment" required></textarea><br>
    <button type="submit">Submit Review</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO reviews (recipe_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $recipe_id, $user_id, $rating, $comment);
    $stmt->execute();
    $stmt->close();
}

// Display reviews
echo "<h3>Reviews</h3>";
$res = $conn->query("SELECT * FROM reviews WHERE recipe_id = $recipe_id ORDER BY timestamp DESC");
while ($row = $res->fetch_assoc()) {
    echo "<div class='review'>";
    echo "<p><strong>Rating:</strong> " . $row['rating'] . "/5<br>" . htmlspecialchars($row['comment']) . "</p>";
    echo "</div><hr>";
}

include "includes/footer.php";
?>

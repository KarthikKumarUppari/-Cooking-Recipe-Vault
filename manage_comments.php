<?php 
session_start();
include "../db.php"; 
include "../includes/header.php";

// Simple admin check – your user records should have a role field. Adjust accordingly.
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in as admin.";
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT role FROM users WHERE user_id = $user_id");
$user = $result->fetch_assoc();
if ($user['role'] !== 'admin') {
    echo "Access denied. You are not an admin.";
    exit;
}

// Delete review if requested
if (isset($_GET['delete'])) {
    $review_id = intval($_GET['delete']);
    $conn->query("DELETE FROM reviews WHERE review_id = $review_id");
    echo "Review deleted.";
}

// Display all reviews
echo "<h2>Manage Comments/Reviews</h2>";
$sql = "SELECT r.review_id, r.rating, r.comment, r.timestamp, u.username, rec.title as recipe_title 
        FROM reviews r 
        JOIN users u ON r.user_id = u.user_id 
        JOIN recipes rec ON r.recipe_id = rec.recipe_id
        ORDER BY r.timestamp DESC";
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
    echo "<div class='review'>";
    echo "<p><strong>Recipe:</strong> " . htmlspecialchars($row['recipe_title']) . "</p>";
    echo "<p><strong>User:</strong> " . htmlspecialchars($row['username']) . "</p>";
    echo "<p><strong>Rating:</strong> " . $row['rating'] . "/5</p>";
    echo "<p><strong>Comment:</strong> " . htmlspecialchars($row['comment']) . "</p>";
    echo "<p><strong>Date:</strong> " . $row['timestamp'] . "</p>";
    echo "<a href='?delete=" . $row['review_id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
    echo "</div><hr>";
}

include "../includes/footer.php";
?>

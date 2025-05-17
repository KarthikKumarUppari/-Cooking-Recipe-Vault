<?php 
include "db.php"; 
include "includes/header.php"; 
?>
<form method="GET" action="" class="container mt-4 p-4 border rounded bg-light shadow-sm" style="max-width: 500px;">
  <h3 class="text-center mb-4">Search Recipes</h3>

  <div class="mb-3">
    <label for="keyword" class="form-label">Enter Keyword</label>
    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="e.g., pasta, salad" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>" required>
  </div>

  <button type="submit" class="btn btn-success w-100">Search</button>
</form>


<?php
if (isset($_GET['keyword'])) {
    $keyword = $conn->real_escape_string($_GET['keyword']);
    $sql = "SELECT * FROM recipes WHERE title LIKE '%$keyword%' OR cuisine LIKE '%$keyword%' OR ingredients LIKE '%$keyword%'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<h3>Search Results:</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='recipe'>";
            echo "<h3><a href='view_recipe.php?id=" . $row['recipe_id'] . "'>" . $row['title'] . "</a></h3>";
            echo "<p>Cuisine: " . $row['cuisine'] . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "No recipes found.";
    }
}
include "includes/footer.php";
?>

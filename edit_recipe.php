<?php 
session_start();
include "db.php";
include "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to edit a recipe.";
    exit;
}

$recipe_id = $_GET['id'];
// Fetch recipe details
$stmt = $conn->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();
$stmt->close();

// Check if user is the owner
if ($_SESSION['user_id'] != $recipe['user_id']) {
    echo "You are not authorized to edit this recipe.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $cuisine = $_POST['cuisine'];
    $dietary_info = $_POST['dietary_info'];
    $nutrition = $_POST['nutrition'];

    // Handle image if uploaded
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $recipe['image']; // keep old image
    }
    
    $stmt = $conn->prepare("UPDATE recipes SET title=?, ingredients=?, steps=?, prep_time=?, cook_time=?, cuisine=?, dietary_info=?, nutrition=?, image=? WHERE recipe_id=?");
    $stmt->bind_param("sssiissssi", $title, $ingredients, $steps, $prep_time, $cook_time, $cuisine, $dietary_info, $nutrition, $image, $recipe_id);
    
    if ($stmt->execute()) {
        echo "Recipe updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    // Re-fetch updated recipe details
    $sql = "SELECT * FROM recipes WHERE recipe_id = " . $recipe_id;
    $result = $conn->query($sql);
    $recipe = $result->fetch_assoc();
}
?>
<h2>Edit Recipe</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Recipe Title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required><br>
    <textarea name="ingredients" placeholder="Ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea><br>
    <textarea name="steps" placeholder="Preparation Steps" required><?php echo htmlspecialchars($recipe['steps']); ?></textarea><br>
    <input type="number" name="prep_time" placeholder="Prep Time (mins)" value="<?php echo $recipe['prep_time']; ?>" required><br>
    <input type="number" name="cook_time" placeholder="Cook Time (mins)" value="<?php echo $recipe['cook_time']; ?>" required><br>
    <input type="text" name="cuisine" placeholder="Cuisine" value="<?php echo htmlspecialchars($recipe['cuisine']); ?>"><br>
    <input type="text" name="dietary_info" placeholder="Dietary Info" value="<?php echo htmlspecialchars($recipe['dietary_info']); ?>"><br>
    <textarea name="nutrition" placeholder="Nutrition Info"><?php echo htmlspecialchars($recipe['nutrition']); ?></textarea><br>
    <label>Change Image (if desired):</label>
    <input type="file" name="image"><br>
    <button type="submit">Update Recipe</button>
</form>

<?php include "includes/footer.php"; ?>

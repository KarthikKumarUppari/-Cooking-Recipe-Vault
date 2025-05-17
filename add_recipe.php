<?php 
include "db.php"; 
include "includes/header.php"; 
//session_start(); 
?>

<h2>Add Recipe</h2>
<form method="POST" enctype="multipart/form-data" class="container mt-4 p-4 border rounded bg-light shadow-sm" style="max-width: 600px;">
  <h3 class="mb-4 text-center">Submit a New Recipe</h3>

  <div class="mb-3">
    <label for="title" class="form-label">Recipe Title</label>
    <input type="text" id="title" name="title" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="ingredients" class="form-label">Ingredients</label>
    <textarea id="ingredients" name="ingredients" class="form-control" rows="3" placeholder="List ingredients separated by commas" required></textarea>
  </div>

  <div class="mb-3">
    <label for="steps" class="form-label">Preparation Steps</label>
    <textarea id="steps" name="steps" class="form-control" rows="4" required></textarea>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <label for="prep_time" class="form-label">Prep Time (mins)</label>
      <input type="number" id="prep_time" name="prep_time" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
      <label for="cook_time" class="form-label">Cook Time (mins)</label>
      <input type="number" id="cook_time" name="cook_time" class="form-control" required>
    </div>
  </div>

  <div class="mb-3">
    <label for="cuisine" class="form-label">Cuisine</label>
    <input type="text" id="cuisine" name="cuisine" class="form-control">
  </div>

  <div class="mb-3">
    <label for="dietary_info" class="form-label">Dietary Info</label>
    <input type="text" id="dietary_info" name="dietary_info" class="form-control">
  </div>

  <div class="mb-3">
    <label for="nutrition" class="form-label">Nutrition Info</label>
    <textarea id="nutrition" name="nutrition" class="form-control" rows="2" placeholder="e.g., Calories: 200, Protein: 10g"></textarea>
  </div>

  <div class="mb-3">
    <label for="image" class="form-label">Recipe Image</label>
    <input type="file" id="image" name="image" class="form-control">
  </div>

  <button type="submit" class="btn btn-success w-100">Submit Recipe</button>
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $prep_time = $_POST['prep_time'];
    $cook_time = $_POST['cook_time'];
    $cuisine = $_POST['cuisine'];
    $dietary_info = $_POST['dietary_info'];
    $nutrition = $_POST['nutrition'];
    $user_id = $_SESSION['user_id'];
    
    $image = $_FILES['image']['name'];
    if ($image) {
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }
    
    $stmt = $conn->prepare("INSERT INTO recipes (title, ingredients, steps, prep_time, cook_time, cuisine, dietary_info, nutrition, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiissssi", $title, $ingredients, $steps, $prep_time, $cook_time, $cuisine, $dietary_info, $nutrition, $image, $user_id);
    
    if ($stmt->execute()) {
        echo "Recipe added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
include "includes/footer.php";
?>

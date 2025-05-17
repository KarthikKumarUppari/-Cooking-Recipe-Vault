<?php
include "db.php";  // Include the database connection
include "includes/header.php";  // Include the header for the page

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password using bcrypt (default method)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert user data into the `users` table
    $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    if ($insert_stmt === false) {
        // If there was an issue with preparing the query, show the error
        echo "Error preparing statement: " . $conn->error;
    } else {
        // Bind the parameters to the query
        $insert_stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute the query
        if ($insert_stmt->execute()) {
            // If successful, notify the user
            echo "Registered successfully!";
        } else {
            // If execution fails, show the error message
            echo "Error executing query: " . $insert_stmt->error;
        }

        // Close the prepared statement
        $insert_stmt->close();
    }
}

?>

<!-- Registration form -->
<form method="POST" action="" class="container mt-5 p-4 border rounded bg-light shadow-sm" style="max-width: 500px;">
  <h3 class="text-center mb-4">Register</h3>

  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
  </div>

  <button type="submit" class="btn btn-primary w-100">Register</button>
</form>


<?php
include "includes/footer.php";  // Include the footer for the page
?>

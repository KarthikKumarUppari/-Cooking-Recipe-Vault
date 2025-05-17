<?php 
include "db.php"; 
include "includes/header.php"; 
//session_start();  // Start the session to manage login state

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    echo "You are already logged in! <a href='index.php'>Go to Home</a>";
    exit();
}

?>
<form method="POST" action="" class="container mt-5 p-4 border rounded bg-light shadow-sm" style="max-width: 500px;">
  <h3 class="text-center mb-4">Login</h3>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
  </div>

  <button type="submit" class="btn btn-primary w-100">Login</button>
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to check if user exists with the provided email
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);

    // Check if the email exists and password matches
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // Set session variables for the logged-in user
        $_SESSION['user_id'] = $user_id;
        
        // Redirect user to the home page or dashboard
        echo "Login successful! <a href='index.php'>Go to Home</a>";
    } else {
        echo "Invalid login! Please check your credentials.";
    }
    
    // Close the prepared statement
    $stmt->close();
}
?>

<?php include "includes/footer.php"; ?>

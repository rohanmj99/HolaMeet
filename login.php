<?php
// Start session
session_start();

// Include database connection file
include_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare SQL statement to retrieve user data based on email
    $sql = "SELECT * FROM users WHERE email = ?";

    // Create a prepared statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters to statement
    $stmt->bindParam(1, $email);

    // Execute the statement
    $stmt->execute();

    // Fetch the user's data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            session_start();

            // Store data in session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            // Redirect to dashboard page
            header("Location: dashboard.html");
            exit();
        } else {
            // Password is incorrect
            $error = "Incorrect password. Please try again.";
            header("Location: login.html?error=" . urlencode($error));
            exit();
        }
    } else {
        // User with given email not found
        $error = "User with this email does not exist.";
        header("Location: login.html?error=" . urlencode($error));
        exit();
    }
}
?>
<?php
// Include database connection file
include_once "db.php";

// Initialize variables
$email = $password = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to insert data into database
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

    // Create a prepared statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters to statement
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        $successMessage = "Account created successfully.";
    } else {
        // Error handling
        echo "Error: Unable to create account.";
    }
}

// Fetch and display stored users
$stmt = $pdo->prepare("SELECT email, password FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stored Users</title>
</head>
<body>
    <h2>Stored Users</h2>
    <?php if (!empty($successMessage)) : ?>
        <p><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Email</th>
            <th>Password (Hashed)</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['password']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p>Redirecting to login page...</p>

    <?php
    // Redirect to login page after displaying users
    header("refresh:5; url=login.html"); // Redirect to login.html after 5 seconds
    exit; // Stop execution of further code
    ?>
</body>
</html>
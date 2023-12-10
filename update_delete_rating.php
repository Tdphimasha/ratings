<?php
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating_id = isset($_POST['rating_id']) ? $_POST['rating_id'] : null;
    $new_rating = isset($_POST['new_rating']) ? $_POST['new_rating'] : null;
    $new_comment = isset($_POST['new_comment']) ? $_POST['new_comment'] : null;

    // Example user ID (you should get this from your authentication system)
    $user_id = 1;

    // Example database connection using PDO
    $dsn = "mysql:host=localhost;dbname=healthmate";
    $username = "root@'localhost";
    $password = "YES";

    try {
        $conn = new PDO($dsn, $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    if (isset($_POST['add'])) {
        // Add a new rating
        $sql = "INSERT INTO ratings (user_id, rating, comment) VALUES (:user_id, :rating, :comment)";
    } elseif (isset($_POST['update'])) {
        // Update an existing rating
        $sql = "UPDATE ratings SET rating = :rating, comment = :comment WHERE id = :rating_id AND user_id = :user_id";
    } elseif (isset($_POST['delete'])) {
        // Delete an existing rating
        $sql = "DELETE FROM ratings WHERE id = :rating_id AND user_id = :user_id";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':rating_id', $rating_id, PDO::PARAM_INT);
    $stmt->bindParam(':rating', $new_rating, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $new_comment, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect back to the index page after the operation
    header('Location: index.php');
    exit();
}
?>

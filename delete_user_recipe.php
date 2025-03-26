<?php
session_start();
$recipesConn = new mysqli("localhost", "root", "", "food_recipes");

if (!isset($_SESSION['namee'])) {
    header("Location: admin.html");
    exit();
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $deleteQuery = "DELETE FROM userrecipes WHERE id = ?";
    $stmt = $recipesConn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Recipe deleted successfully'); window.location.href='added.php';</script>";
    } else {
        echo "<script>alert('Error deleting recipe'); window.location.href='added.php';</script>";
    }

    $stmt->close();
}
$recipesConn->close();
?>
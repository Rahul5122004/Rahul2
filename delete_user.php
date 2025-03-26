<?php
session_start();
$usersConn = new mysqli("localhost", "root", "", "sign");

if (isset($_GET['email'])) {
    $email = $usersConn->real_escape_string($_GET['email']);
    $deleteQuery = "DELETE FROM signup WHERE email='$email'";

    if ($usersConn->query($deleteQuery) === TRUE) {
        echo "<script>alert('User deleted successfully'); window.location.href='adminrecipes.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $usersConn->error . "'); window.location.href='admin_dashboard.php';</script>";
    }
} else {
    header("Location: adminrecipes.php");
    exit();
}
?>
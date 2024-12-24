<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['matric'])) {
    // Redirect to the login page if the user is not authenticated
    header("Location: login.php");
    exit();
}


include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the POST request
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->updateUser($matric, $name, $role);

    // Close the connection
    $db->close();

    header('Location: read.php');
}
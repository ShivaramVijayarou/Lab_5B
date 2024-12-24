<?php
session_start(); // Start the session

// Store session (this should actually be set during login, not here)
$_SESSION['matric'] = 1; // Example: User ID of the logged-in user

include 'Database.php';
include 'User.php';

// Create an instance of the Database class and get the connection
$database = new Database();
$db = $database->getConnection();

// Get user details based on the session user ID
$userName = "Guest"; // Default name if no session or user found
if (isset($_SESSION['matric'])) {
    $query = "SELECT name FROM users WHERE matric = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $_SESSION['matric']);
    $stmt->execute();
    $stmt->bind_result($name);
    if ($stmt->fetch()) {
        $userName = $name;
    }
    $stmt->close();
}

// Create an instance of the User class
$user = new User($db);
$result = $user->getUsers();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 2rem;
        }
        .table-container {
            margin-top: 2rem;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">User Details</h1>
        <p class="welcome-message">Welcome, <strong><?php echo $userName; ?></strong>!</p>

        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Matric</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php




                    if ($result->num_rows > 0) {
                        // Fetch each row from the result set
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row["matric"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo ucfirst($row["role"]); ?></td>
                                <td class="text-center">
                                    <a href="update_form.php?matric=<?php echo $row["matric"]; ?>" class="btn btn-warning btn-sm">Update</a>
                                </td>
                                <td class="text-center">
                                    <a href="delete.php?matric=<?php echo $row["matric"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
                    }
                    // Close connection
                    $db->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <a href="logout.php">Logout</a>
</body>

</html>

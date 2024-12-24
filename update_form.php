<?php
include 'Database.php';
include 'User.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    // Fetch user details using the matric value
    $user = new User($db);
    $userDetails = $user->getUser($matric);

    // Close the database connection
    $db->close();

    // Check if user details are found
    if (!$userDetails) {
        die("Error: No user found with the provided matric.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1 class="form-header">Update User</h1>
        <form action="update.php" method="post">
            <!-- Hidden input to pass matric -->
            <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($userDetails['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">Please select</option>
                    <option value="lecturer" >Lecturer</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

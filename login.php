<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];

    $conn = new mysqli('localhost', 'root', '', 'lab_5');
    $result = $conn->query("SELECT * FROM users WHERE matric='$matric'");

    if ($result->num_rows > 0) {
        // Set the session variable for the logged-in user
        $_SESSION['user'] = $matric;
        header('Location: display.php'); // Redirect to the protected page
        exit();
    } else {
        echo "Invalid Matric Number";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1 class="login-header">Login</h1>
        <form action="authenticate.php" method="post">
            <div class="mb-3">
                <label for="matric" class="form-label">Matric</label>
                <input type="text" class="form-control" id="matric" name="matric" placeholder="Enter your matric" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="register_form.php" class="text-decoration-none">Register here</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>



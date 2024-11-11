<?php
// Initialize error messages array
$errors = [];

// Start session for error handling after redirects
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Validate fields
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Proceed with validation if no errors
    if (empty($errors)) {
        // Hardcoded valid credentials (this could be replaced with a database check)
        $valid_email = "user@example.com";
        $valid_password = "password123";

        if ($email == $valid_email && $password == $valid_password) {
            header("Location: dashboard.php");
            exit(); // Ensure no further code execution
        } else {
            $errors[] = "Invalid email or password.";
        }
    }

    // Store errors in session and redirect
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ".$_SERVER['PHP_SELF']);
        exit(); // Ensure no further code execution
    }
}

// Display errors if they exist
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Clear errors after displaying them
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
            flex-direction: column; /* This ensures vertical layout */
        }
        .login-container {
            width: 90%;
            max-width: 400px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            overflow: hidden;
            position: relative;
            margin-top: 20px; /* Space between the error box and login form */
        }
        .header {
            background-color: #f2f2f2;
            padding: 15px;
            text-align: left;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .error-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 0;
            border: 1px solid #f5c6cb;
            position: relative;
            box-sizing: border-box;
            width: 60%; /* Adjust width to 60% */
            max-width: 400px; /* Set max-width to 400px */
            text-align: left;
            margin: 20px auto; /* Centers the error box */
        }
        .error-box h4 {
            margin: 0;
            font-weight: bold;
            font-size: 16px;
        }
        .error-box ul {
            margin: 5px 0 0;
            padding-left: 20px;
        }
        .error-box li {
            list-style-type: disc;
            font-size: 14px;
        }
        .close-btn {
            font-weight: bold;
            cursor: pointer;
            color: #721c24;
            font-size: 20px;
            position: absolute;
            top: 5px;
            right: 10px;
            background-color: transparent;
            border: none;
        }
        .form-group {
            padding: 0 20px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 20px;
            box-sizing: border-box;
        }
        .login-button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 600px) {
            .login-container {
                width: 100%;
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>

<!-- Display errors at the top of the page -->
<?php if (!empty($errors)): ?>
    <div class="error-box">
        <h4>System Errors</h4>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
<?php endif; ?>

<div class="login-container">
    <div class="header">
        <h2>Login</h2>
    </div>

    <form method="post" action="">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo isset($email) ? $email : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="login-button">Login</button>
    </form>
</div>

</body>
</html>

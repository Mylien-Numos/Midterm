<?php
session_start();
require 'functions.php';
$userEmail = isset($_SESSION["email"]) ? $_SESSION["email"] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-logout {
            position: relative;
            font-size: 18px;
            font-weight: 400;
            color: #333;
            margin-top: 50px;
            margin-bottom: 100px;
            left: 840px;
            top: 150px;
        }

        .welcome-message {
            position: relative;
            font-size: 18px;
            font-weight: 400;
            color: #333;
            margin-left: -30px;
            margin-top: 30px;
            margin-bottom: 50px;
            left: 180px;
            top: 10px;
        }

        @media (min-width: 768px) {
            .welcome-message {
                font-size: 22px;
                margin-top: 40px;
                margin-bottom: 60px;
                left: 230px;
                top: 20px;
            }
        }

        @media (max-width: 768px) {
            .custom-logout {
                font-size: 16px;
                left: 150px;
                top: 20px;
            }
        }

        @media (max-width: 576px) {
            .custom-logout {
                font-size: 14px;
                left: 100px;
                top: 30px;
            }
        }

        @media (max-width: 400px) {
            .custom-logout {
                font-size: 12px;
                left: 50px;
                top: 40px;
            }
        }

        .card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-body {
            flex-grow: 1;
        }

        .card-header {
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <!-- Logout Form (Button) -->
        <form action="logout.php" method="POST" class="custom-logout">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>

        <!-- Welcome Message -->
        <div class="welcome-message">
            <p>Welcome to the System: <?= htmlspecialchars($userEmail); ?></p>
        </div>
     
        <!-- Dashboard Content -->
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h5>Add a Subject</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>This section allows you to add a new subject in the system. Click the button below to proceed with the adding process.</p>
                        <a href="subject/add.php" class="btn btn-primary">Add Subject</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h5>Register a Student</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>This section allows you to register a new student in the system. Click the button below to proceed with the .</p>
                        <a href="student/register.php" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

$errors = [];

// Handling form submission to add a student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = trim($_POST['student_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);

    if (empty($student_id)) {
        $errors[] = "Student ID is required";
    }
    if (empty($first_name)) {
        $errors[] = "First Name is required";
    }
    if (empty($last_name)) {
        $errors[] = "Last Name is required";
    }

    if (empty($errors)) {
        $_SESSION['students'][] = [
            'student_id' => $student_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ];
    }
}

// Handling delete student action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student_id'])) {
    $delete_student_id = $_POST['delete_student_id'];
    $_SESSION['students'] = array_filter($_SESSION['students'], function($student) use ($delete_student_id) {
        return $student['student_id'] !== $delete_student_id;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a New Student</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 2rem auto;
        }

        .breadcrumb {
            display: flex;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 1.5rem;
            background-color: #f1f3f5;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb span {
            margin: 0 0.3rem;
        }

        .card {
            padding: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-bottom: 1.5rem;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .error-box {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            position: relative;
            max-width: 1100px;
        }
        .error-box h4 {
            font-weight: bold;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #721c24;
        }
        .error-box ul {
            padding-left: 1.2rem;
            list-style-type: disc;
        }
        .error-box li {
            margin-bottom: 0.3rem;
        }
        .error-box .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #721c24;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .form-group input:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.4);
            outline: none;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }
        th, td {
            padding: 0.8rem;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }

        /* Button styles for Edit, Delete, Attach */
        .btn-edit {
            background-color: #17a2b8;
            color: #fff;
            padding: 0.5rem 0.9rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
            margin-right: 0.5rem;
        }
        .btn-edit:hover {
            background-color: #138496;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            padding: 0.5rem 0.9rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
            margin-right: 0.5rem;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-attach {
            background-color: #ffc107;
            color: #fff;
            padding: 0.5rem 0.9rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }
        .btn-attach:hover {
            background-color: #e0a800;
        }

        /* Media Query for Responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
            table, th, td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Register a New Student</h2>

    <nav class="breadcrumb">
        <a href="#">Dashboard</a><span>/</span>
        <span>Register Student</span>
    </nav>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            <h4>System Errors</h4>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <form action="" method="POST">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" name="student_id" id="student_id" placeholder="Enter Student ID">
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter First Name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name">
            </div>
            <button type="submit" class="btn-primary">Add Student</button>
        </form>
    </div>

    <h3>Student List</h3>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($_SESSION['students'])): ?>
                <tr>
                    <td colspan="4" class="text-center">No student records found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($_SESSION['students'] as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['student_id']) ?></td>
                        <td><?= htmlspecialchars($student['first_name']) ?></td>
                        <td><?= htmlspecialchars($student['last_name']) ?></td>
                        <td>
                            <button class="btn-edit">Edit</button>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="delete_student_id" value="<?= htmlspecialchars($student['student_id']) ?>">
                                <button type="submit" class="btn-danger">Delete</button>
                            </form>
                            <button class="btn-attach">Attach Subject</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

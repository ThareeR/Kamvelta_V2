<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .success-message {
            font-size: 24px;
            font-weight: bold;
            color: #34c759;
        }
        .login-link {
            text-decoration: none;
            color: #337ab7;
        }
        .login-link:hover {
            color: #23527c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="success-message">Registration Successful!</h2>
        <p>Your account has been created successfully.</p>
        <p>You can now login to your account using the credentials you provided during registration.</p>
        <p><a href="login.php" class="login-link">Login</a></p>
    </div>
</body>
</html>
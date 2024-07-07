<?php include_once __DIR__.'/../config.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?> /assets/css/styles.css">
    <!-- <style>
        body{
            background-image: url("<?php echo BASE_URL;?>/assets/images/nature.jpg");
            opacity: 0.2;
            position: absolute;
            z-index: -1;
        }
    </style> -->
    <!-- <link rel="stylesheet" href="../assets/css/generalStyles.css"> -->
    <title>Kamvelta Holiday Resort</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar_logo"> 
            <img src="<?php echo BASE_URL; ?>/assets/images/logo.png" id=logo alt="Kamvelta Logo" /> 
        </a>
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">Kamvelta</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/index.php">Home</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/views/home.php#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/views/home.php#contact">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><font color = "black">Accommodation</font></a>
                        <a class="dropdown-item" href="#"><font color = "black">Banquet Hall</font></a>
                        <a class="dropdown-item" href="#"><font color = "black">Restaurant</font></a>
                        <a class="dropdown-item" href="#"><font color = "black">Photo Location</font></a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/auth/login.php">Make a Reservation</a>
                </li>
            </ul>
            <!-- <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <?php //if (isset($_SESSION['username'])): ?>
                        <a class="nav-link" href="<?php //echo $_SERVER['HTTP_HOST'] ?>dashboard/customer.php">Dashboard</a>
                    <?php //else: ?>
                        <a class="nav-link" href="<?php //echo $_SERVER['HTTP_HOST'] ?>views/login.php">Login</a>
                    <?php //endif; ?>
                </li>
            </ul> -->
        </div>
    </nav>
</body>
</html> 

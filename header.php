<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $b_title; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>

    <!-- to use icons from fontawesome -->
    <script src="https://kit.fontawesome.com/006f14bf04.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- since this file is for header, (body, html) tag will go to footer file -->

    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="default.php">Netflix Viewing Activity</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="list.php">Viewing Activity List</a></li>
                <?php
                session_start();
                if (isset($_SESSION['userId'])) {
                    echo '<li><a href="input.php">Add Viewing Activity</a></li>';
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (empty($_SESSION['userId'])) {
                    echo '<li><a href="register.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>';
                } else {
                    echo '<li><a href="#">' . $_SESSION['username'] . '</a></li>
                        <li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
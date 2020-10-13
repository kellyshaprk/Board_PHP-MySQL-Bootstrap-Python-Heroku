<?php
// clear the session variables then kill the user's session
session_start();

session_destroy();

header('location:login.php');
?>
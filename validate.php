<?php
$b_title ="Validate";
$username = $_POST['username'];
$password = $_POST['password'];

try
{
    require('db.php');

    $sql = "SELECT userId, password FROM my_nf_user WHERE userId = :username";

    $cmd = $db->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->execute();

    $user = $cmd->fetch();

    if (!password_verify($password, $user['password'])) {
        header('location:login.php?invalid=true');
        exit();
    } else {
        session_start(); // 창을 띄운 순간부터 이미 세션은 시작된 것. connect to existing session so we can write to it
        $_SESSION['userId'] = $user['userId'];
        $_SESSION['username'] = $username;
        header('location:list.php');
    }

    $db = null;
}
catch (Exception $e)
{
    // send
    mail('kelly.shpark@gmail.com', 'Netflix page Error: ' . $b_title , $e);
    // show generic error page
    header('location:error.php');
}
?>

<?php
$b_title = "Save Registration";
require('header.php');

// store form inputs in variables
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$ok = true;

// validate inputs
if(empty($username))
{
    echo 'Username is Required <br />';
    $ok = false;
}

if(strlen($password) < 8)
{
    echo 'Password is invalid <br />';
    $ok = false;
}

if ($password != $confirm)
{
    echo 'Passwords do not match <br />';
    $ok = false;
}

if ($ok)
{
    try {
        // hash the password
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        // connect
        require('db.php');

        // set up and execute the insert
        $sql = "INSERT INTO my_nf_user (userId, password) VALUES(:username, :password);"; 
        // test@test.com / Test1234
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
        $cmd->bindParam(':password', $hashedpassword, PDO::PARAM_STR, 255);
        $cmd->execute();

        // disconnect
        $db = null;

        // redirect to login
        header('location:login.php');
    }
    catch (Exception $e)
    {
        // send
        mail('kelly.shpark@gmail.com', 'Netflix page Error: ' . $b_title , $e);
        // show generic error page
        header('location:error.php');
    }
}
?>
</body>
</html>

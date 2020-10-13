<?php
$b_title = "Save Activity";
require('header.php');
require('auth.php');

// introduce variables to store the form input variables
$title = $_POST ['title'];
$mm = $_POST ['mm'];
$dd = $_POST ['dd'];
$yy = $_POST ['yy'];
$genre = $_POST ['genre'];
$rating = $_POST ['rating'];
$cmnt = $_POST ['cmnt'];
$ord = $_POST['ord'];
$poster = $_POST['poster'];


// validate each input
$ok = true;

if (empty($title))
{
    echo "Title is Required. <br />";
    $ok = false;
}

// to compare [the input date] to [current date]
// if [the input date] > [current date] => echo message, does not save the data

// to make easy to compare, replace from the full name of the month to a number (string type)
switch ($mm)
{
    case "January":
        $mm_num = "01";
        break;
    case "February":
        $mm_num = "02";
        break;
    case "March":
        $mm_num = "03";
        break;
    case "April":
        $mm_num = "04";
        break;
    case "May":
        $mm_num = "05";
        break;
    case "June":
        $mm_num = "06";
        break;
    case "July":
        $mm_num = "07";
        break;
    case "August":
        $mm_num = "08";
        break;
    case "September":
        $mm_num = "09";
        break;
    case "October":
        $mm_num = "10";
        break;
    case "November":
        $mm_num = "11";
        break;
    case "December":
        $mm_num = "12";
        break;
}

$today = date("Ymd");
$dt = $yy . "" . $mm_num . "" . $dd;

// compare the date vs. now
if ($today < date('Ymd', strtotime($dt)))
{
    echo "<h2>Save Failed</h2>";
    echo "The date cannot be future than now (Input date: " . $mm . " " . $dd . ", " . $yy . ").";
    $ok = false; // do not save the data
}

// date validation
if (!(checkdate($mm_num,$dd,$yy)))
{
    echo "<h2>Save Failed</h2>";
    echo "Check the date (Input date: " . $mm_num . " " . $dd . ", " . $yy . ").";
    $ok = false; // do not save the data
}

// check and validate logo upload
// EDIT -> SAVE => the Poster keeps saved
if (isset($_FILES['poster']['name']))
{
    $posterFile = $_FILES['poster'];

    if ($posterFile['size'] > 0)
    {
        // generate unique file name
        $poster = session_id() . "-" . $posterFile['name'];

        // check file type
        $fileType = null;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $posterFile['tmp_name']);

        // allow only jpeg & png
        if (($fileType != "image/jpeg") && ($fileType != "image/png"))
        {
            echo 'Please upload a valid JPG or PNG logo<br />';
            $ok = false;
        }
        else
        {
            // save the file
            move_uploaded_file($posterFile['tmp_name'], "img/{$poster}");
        }
    }

}

// connect to the database with server, username, password, dbname
// only save if no validation errors
if ($ok)
{
    try {
        // db connect
        require('db.php');

        if (empty($ord)) {
            $sql = "INSERT INTO my_nf_viewing (title, mm, dd, yy, genre, rating, cmnt, poster) VALUES (:title, :mm, :dd, :yy, :genre, :rating, :cmnt, :poster)";
        } else {
            $sql = "UPDATE my_nf_viewing SET title = :title, mm = :mm, dd = :dd, yy = :yy, genre = :genre, rating = :rating, cmnt = :cmnt, poster = :poster WHERE ord = :ord";
        }

        $cmd = $db->prepare($sql);
        $cmd->bindParam(':title', $title, PDO::PARAM_STR, 100);
        $cmd->bindParam(':mm', $mm, PDO::PARAM_STR, 9);
        $cmd->bindParam(':dd', $dd, PDO::PARAM_STR, 2);
        $cmd->bindParam(':yy', $yy, PDO::PARAM_STR, 4);
        $cmd->bindParam(':genre', $genre, PDO::PARAM_STR, 20);
        $cmd->bindParam(':rating', $rating, PDO::PARAM_STR, 5);
        $cmd->bindParam(':cmnt', $cmnt, PDO::PARAM_STR, 500);
        $cmd->bindParam(':poster', $poster, PDO::PARAM_STR, 100);

        if (!empty($ord)) {
            $cmd->bindParam('ord', $ord, PDO::PARAM_INT);
        }

        $cmd->execute();

        // disconnect!!! after inserting, disconnect from the database
        $db = null;

        // redirect
        header('location:list.php');
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

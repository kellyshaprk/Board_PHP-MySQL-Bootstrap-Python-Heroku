<?php
$b_title = "Viewing Activity Detail";
require('header.php');

try {
    require('db.php');
    require('auth.php');

    // initialize variables
    /* 
    수동 입력) previous version : you have to fill each field to store the data
    */

    $title = null;
    $mm = null;
    $dd = null;
    $yy = null;
    $genre = null;
    $poster = null;
    $rating = null;
    $cmnt = null;
    $ord  = null;
    $search = null;	

    // was an existing id(ord column data) passed to this page? if so, select the matching record from the database
    if (!empty($_GET['ord'])) {
        // assign the club_id
        $ord = $_GET['ord'];

        // set up query
        $sql = "SELECT * FROM my_nf_viewing WHERE ord = :ord";

        // execute
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':ord', $ord, PDO::PARAM_INT);
        $cmd->execute();
        $my_nf = $cmd->fetch(); // only one row - $ord

        // store each column value in a variable
        $title = $my_nf['title'];
        $mm = $my_nf['mm'];
        $dd = $my_nf['dd'];
        $yy = $my_nf['yy'];
        $genre = $my_nf['genre'];
        $rating = $my_nf['rating'];
        $cmnt = $my_nf['cmnt'];
        $poster = $my_nf['poster'];
    }

    // disconnect
    $db = null;
} catch (Exception $e) {
    // send
    mail('kelly.shpark@gmail.com', 'Netflix page Error: ' . $b_title, $e);

    // show generic error page
    header('location:error.php');
}
?>

<!-- 서치기능 -->
<!-- if you click on the button, it executes the python file to show you the list of the movies/dramas
 -->
<form method="post">
    <input type="submit" name="title_search" id="title_search" value="search by title" /><br />
</form>


<?php

if (array_key_exists('title_search', $_POST)) {


    $output = exec(' sudo python test.py ');

    if (!empty($output)) {
        echo "Successfully";
        echo "<br>";
    } else {
        echo "fail";
    }
}

?>


<form method="post">
    <input name="search" id="search" required value="<?php echo $search; ?>" />
    <input type="submit" value="Search" class="btn btn-success" />
        <?php
        {   
            echo "aa";
            // get search text from the input form
            $search = isset($_POST["search"]) ?  $_POST["search"] : '';
            // replace from white space to "_" 
            $search = preg_replace('/\s+/', "_", $search);
            // execute python using the variable
            //$result = shell_exec("python main.py $search");
            $result = json_decode(exec("python main.py $search"), true);
            echo $result; //파일 생성해도 어디에 떨궈지는지 모르겠음,,, 파일 생성 + 인자값 넘겨주는걸로 처리함
         }        
        ?>
</form>
	

<form action="save.php" method="post" enctype="multipart/form-data">
    <!--  start the container -->
    <main class="container">
        <div class="jumbotron" style="background-color: #e3f2fd;">

            <fieldset>
                <!-- assume that viewers can watch the same program (movie) many times -->
                <label for="title" class="col-md-1">Title: </label>
                <input name="title" id="title" required value="<?php echo $title; ?>" />
            </fieldset>
            <fieldset>
                <label for="mm" class="col-md-1">Date: </label>
                <?php
                // connect
                require('db.php');

                // set up query
                $sql = "select mm from nf_mm order by ord";
                $cmd = $db->prepare($sql);

                // fetch the results
                $cmd->execute();
                $month = $cmd->fetchAll();

                // start the select
                echo '<select name = "mm">';

                // loop through and create a new option tag for each type
                foreach ($month as $m) {
                    if ($m['mm'] == $mm) {
                        echo '<option selected>' . $m[mm] . '</option>';
                    } else {
                        echo '<option>' . $m[mm] . '</option>';
                    }
                }

                // close the select
                echo '</select>';

                // disconnect
                $db = null;
                ?>
            </fieldset>
            <fieldset>
                <label for="dd" class="col-md-1"></label>
                <?php
                // connect
                require('db.php');

                // set up query
                $sql = "select dd from nf_dd";
                $cmd = $db->prepare($sql);

                // fetch the results
                $cmd->execute();
                $day = $cmd->fetchAll();

                // start the select
                echo '<select name = "dd">';

                // loop through and create a new option tag for each type
                foreach ($day as $d) {
                    if ($d['dd'] == $dd) {
                        echo '<option selected>' . $d[dd] . '</option>';
                    } else {
                        echo '<option>' . $d[dd] . '</option>';
                    }
                }

                // close the select
                echo '</select>';

                // disconnect
                $db = null;
                ?>
            </fieldset>
            <fieldset>
                <label for="yy" class="col-md-1"></label>
                <?php
                // connect
                require('db.php');

                // set up query
                $sql = "select yy from nf_yy order by ord desc";
                $cmd = $db->prepare($sql);

                // fetch the results
                $cmd->execute();
                $year = $cmd->fetchAll();

                // start the select
                echo '<select name = "yy">';

                // loop through and create a new option tag for each type
                foreach ($year as $y) {
                    if ($y['yy'] == $yy) {
                        echo '<option selected>' . $y[yy] . '</option>';
                    } else {
                        echo '<option>' . $y[yy] . '</option>';
                    }
                }

                // close the select
                echo '</select>';

                // disconnect
                $db = null;
                ?>
            </fieldset>

            <fieldset>
                <label for="genre" class="col-md-1">Genre: </label>
                <?php
                // connect
                require('db.php');

                // set up query
                $sql = "select genre from nf_genre order by genre";
                $cmd = $db->prepare($sql);

                // fetch the results
                $cmd->execute();
                $genre_d = $cmd->fetchAll();

                // start the select
                echo '<select name = "genre">';

                // loop through and create a new option tag for each type
                foreach ($genre_d as $g) {
                    if ($g['genre'] == $genre) {
                        echo '<option selected>' . $g[genre] . '</option>';
                    } else {
                        echo '<option>' . $g[genre] . '</option>';
                    }
                }

                // close the select
                echo '</select>';

                // disconnect
                $db = null;
                ?>
            </fieldset>

            <fieldset>
                <label for="rating" class="col-md-1">Rating: </label>
                <?php
                // connect
                require('db.php');

                // set up query
                $sql = "select rating from nf_rating order by ord";
                $cmd = $db->prepare($sql);

                // fetch the results
                $cmd->execute();
                $rating_d = $cmd->fetchAll();

                // start the select
                echo '<select name = "rating">';

                // loop through and create a new option tag for each type
                foreach ($rating_d as $r) {
                    if ($r['rating'] == $rating) {
                        echo '<option selected>' . $r[rating] . '</option>';
                    } else {
                        echo '<option>' . $r[rating] . '</option>';
                    }
                }

                // close the select
                echo '</select>';

                // disconnect
                $db = null;
                ?>
            </fieldset>

            <fieldset>
                <label for="poster" class="col-md-1">Poster:</label>
                <input type="file" name="poster" id="poster" />
            </fieldset>
            <div class="col-md-offset-1">
                <?php
                if (!empty($poster)) {
                    echo "<img src=\"img/$poster\" alt=\"Poster\" />";
                }
                ?>
            </div>

            <fieldset>
                <label for="cmnt" class="col-md-1">Comment: </label>
                <textarea name="cmnt" id="cmnt"><?php echo $cmnt; ?></textarea>
            </fieldset>
            <button class="col-md-offset-1 btn btn-primary">Save</button>
            <input type="hidden" name="ord" id="ord" value="<?php echo $ord ?>" />
            <input type="hidden" name="poster" id="poster" value="<?php echo $poster ?>" />
        </div>
    </main>
</form>
</body>

</html>
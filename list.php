<?php
$b_title = "Viewing Activity";
require('header.php');

try
{
    // connect
    require('db.php');
 
    // set up query
    $sql = "SELECT * FROM heroku_d75026005cbf48e.my_nf_viewing ORDER BY ord DESC";

    // execute & store the result
    $cmd = $db->prepare($sql);
    $cmd->execute();
    $my_nf = $cmd->fetchAll();

    // start the container
    echo '<main class = "container">';
    echo '<div class ="jumbotron" style="background-color: #e3f2fd; background-size: 100%;">';
    // start the table
    echo '<table class="table table-hover sortable table-responsive" "><thead class="bg-success"><th>Title</th><th></th><th>Date</th><th>Genre</th><th>Rating</th><th>Comment</th>';

    // only member can see this part
    if (isset($_SESSION['userId'])) {
        echo "<th>Action</th>";
    }

    echo '</thead>';

    // loop through the data & show each restaurant on a new row
    // date format: mm dd, yyyy
    foreach ($my_nf as $m) {
        echo "<tr><td> {$m['title']} </td>";

        if (!empty($m['poster']))
        {
            echo "<td><img src=\"img/{$m['poster']}\" alt=\"Poster\" height=\"50px\" /> </td>";
        }
        else
        {
            echo "<td></td>";
        }
        echo '</td><td>' . $m['mm'] . " " . $m['dd'] . ", " . $m['yy'] .
            '</td><td>' . $m['genre'] .
            '</td><td>' . $m['rating'] .
            '</td><td>' . $m['cmnt'] . '</td>';

        // only member can see this part
        if (isset($_SESSION['userId'])) {
            echo "<td><a href=\"input.php?ord={$m['ord']}\"> Edit </a> 
                      <a href=\"delete.php?ord={$m['ord']} \" class=\"text-danger confirmation\">Delete</a></td>";
        }

        echo '</tr>';
    }
    // close the table
    echo '</table>';

    echo '</div>';
    echo '</main>';

    // disconnect
    $db = null;
}
catch (Exception $e)
{
    // send
    mail('@', 'Netflix page Error: ' . $b_title , $e);
    // show generic error page
    header('location:error.php');
}
?>
<!-- js -->
<script src ="js/jquery-3.3.1.min.js"></script>
<script src="js/scripts.js"></script>
<!-- sorttable script from https://kryogenix.org/code/browser/sorttable/ -->
<script src="js/sorttable.js"></script>

</body>
</html>

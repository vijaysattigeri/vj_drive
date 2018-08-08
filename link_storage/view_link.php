<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->

   


<?php

session_start();
include '../db_connect_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {

    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
    if (!$con) {
        die('Could not connect to database: ' . mysql_error());
    }

    $link_id = $_REQUEST['link_id'];
    $views = $_REQUEST['views'] + 1; //Incrementing view
    $actula_link = $_REQUEST['link'];
    $user_name = $_SESSION['user_name'];
    $user_id = $_SESSION['user_id'];
    $qry = "UPDATE `link_data` SET `views` = '$views' WHERE link_id = '$link_id' AND user_id = '$user_id' AND user_name = '$user_name';";
    $res = mysqli_query($con, $qry);
    mysqli_close($con);
    if ($res) {
        header("location:$actula_link");
    } else {
        echo "<h2 style='color:red;'>Unable to increase the view count in MySQL database..... ;-( </h2>";
    }
} else {
    header("location:../login.php");
}
?>

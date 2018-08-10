<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php

session_start();
include '../db_connect_params.inc';
if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {

    if (isset($_REQUEST['link_id']) && isset($_REQUEST['submit_invalid'])) {

        $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
        if (!$con) {
            die('Could not connect to database: ' . mysql_error());
        }

        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];

        $success_flag = TRUE;
        foreach ($_REQUEST['link_id'] as $id) {
            $qry = "DELETE FROM link_data WHERE link_id='$id' AND user_id = '$user_id' AND user_name = '$user_name';";
            $res = mysqli_query($con, $qry);
            if (!$res) {
                $success_flag = FALSE;
                echo "<h2 style='color:red;'>Error while deleting link entry from MySQL database... ;-( </h2>";
            }
        }
        mysqli_close($con);
        if ($success_flag == TRUE) {
            header("location:index.php");
        }
    } else {
        header("location:index.php");
    }
} else {
    header("location:login.php");
}
?>

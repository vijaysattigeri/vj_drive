<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * */
session_start();

include '../db_connect_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
    $file_id = $_REQUEST['file_id'];
    if ($file_id == "") {
        header("location:index.php");
    } else {
        $file_path = "uploads/";

        $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
        if (!$con) {
            die('Could not connect to database: ' . mysql_error());
        }

        $sel_qry = "select user_id, user_name, stored_name, name, downloads from file_data where file_id='$file_id';";
        $sess_user_id = $_SESSION['user_id'];
        $sess_user_name = $_SESSION['user_name'];

        $result = mysqli_query($con, $sel_qry);
        $download_count = 0;
        $actual_file_name = "";
        $empty_flag = TRUE;


        while ($row = mysqli_fetch_array($result)) {
            $empty_flag = FALSE;
            $owner_id = $row['user_id'];
            $owner_name = $row['user_name'];
            if (($sess_user_id == $owner_id) && ($sess_user_name == $owner_name)) {
                $download_count = $row['downloads'];
                $file_path .= $row['stored_name'];
                $actual_file_name = $row['name'];
                $extension = pathinfo($row['name'], PATHINFO_EXTENSION);
                $download_count++;
                $update_qry = "UPDATE `file_data` SET `downloads` = '$download_count' WHERE `file_data`.`file_id` = '$file_id'";
                mysqli_query($con, $update_qry);

                $file_name = htmlentities($actual_file_name, ENT_QUOTES); // Creation of file name
                $down_file_size = filesize($file_path);
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $file_name);
                header('Content-Transfer-Encoding: binary');
                header("Content-length: $down_file_size");
                // Important statements
                $file = fopen($file_path, 'rb');
                if ($file) {
                    fpassthru($file);
                }
            } else {
                ?>
                <html>
                    <head>
                        <title>File Download</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <script src="../libraries/jquery-3.1.1.min.js"></script>
                        <link href="../libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                        <link href="../libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                        <script src="../libraries/bootstrap/js/bootstrap.js"></script>
                    </head>
                    <body style="padding-top:10px; padding-left: 100px;">
                        <div class="container-fluid">
                            <h2 style = "padding-top: 100px;color:red;">Sorry you don't have ownership on the file you are trying to delete. FILE ID = $file_id. </h2>
                            <br/>
                            <h2>
                                <a href = 'index.php'>Back</a> 
                            </h2>
                        </div>
                    <body>
                    <html>                
                        <?php
                    }
                }
                mysqli_close($con);
                if ($empty_flag == TRUE) {
                    ?>
                    <html>
                        <head>
                            <title>File Download</title>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <script src="../libraries/jquery-3.1.1.min.js"></script>
                            <link href="../libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                            <link href="../libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                            <script src="../libraries/bootstrap/js/bootstrap.js"></script>
                        </head>
                        <body style="padding-top:10px; padding-left: 100px;">
                            <div class="container-fluid">
                                <h2 style = "padding-top: 100px;color:red;">Sorry no file existswith FILE ID = <?php echo $file_id; ?>. </h2>
                                <br/>
                                <h2>
                                    <a href = 'index.php'>Back</a> 
                                </h2>
                            </div>
                        <body>
                        <html>
                            <?php
                        }
                    }
                } else {
                    header("location:../login.php");
                }
                ?>
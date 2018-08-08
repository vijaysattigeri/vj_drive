<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php
session_start();

error_reporting(0); // turn off errors

include '../db_connect_params.inc';
if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
    ?>

    <html>
        <head>
            <title>Delete files</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="../libraries/jquery-3.1.1.min.js"></script>
            <link href="../libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
            <link href="../libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
            <script src="../libraries/bootstrap/js/bootstrap.js"></script>
        </head>
        <body style="padding-top:10px; padding-bottom: 100px;">
            <div id="top_nav_bar_vj">
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="container-fluid" style="background-color:#0b4a91; font-variant-caps:all-petite-caps;">
                        <!--This gives enough padding for navbar elements-->
                        <div class="navbar-header" style="color:#ffffff;">
                            <button style="background-color: #ffffff;" type="button" class="navbar-toggle" data-target="#resize_menu_vj_top" data-toggle="collapse">
                                <!-- To get THREE bars(Icon bars) when we resize the window to smaller size-->
                                <span style="color:#0b4a91;">
                                    <span class="glyphicon glyphicon-menu-hamburger"></span>
                                    <span>Menu</span>
                                </span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse" id="resize_menu_vj_top">
                            <ul class="nav navbar-nav">
                                <li id="list_id_home"><a href="../index.php"><span class="glyphicon glyphicon-home" style="font-size: 20px; color:white;"></span><span style="font-size: medium;color:#ffffff;">&nbsp; HOME </span></a></li>
                            </ul>
                            <ul class="nav navbar-nav">
                                <li id="list_id_file_explorer"><a href="index.php"><span class="glyphicon glyphicon-th-list" style="font-size: 20px; color:white;"></span><span style="font-size: medium;color:#ffffff;">&nbsp; FILE EXPLORER </span></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">                                
                                <li id="list_id_logout"><a href="../logout.php"><span class="glyphicon glyphicon-log-out" style="font-size: 20px; color:white;"></span><span style="font-size:medium;color:#ffffff;">&nbsp; LOGOUT</span></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div> 

            <div class="container" style="padding-top: 100px;">

                <?php
                if (isset($_POST['file_id']) && isset($_POST['submit_invalid'])) {

                    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
                    if (!$con) {
                        die('Could not connect to database: ' . mysql_error());
                    }

                    $sess_user_id = $_SESSION['user_id'];
                    $sess_user_name = $_SESSION['user_name'];
                    $error_flag = TRUE;

                    foreach ($_POST['file_id'] as $id) {
                        $qry1 = "select user_id, user_name, stored_name, name from file_data where file_id='$id'";
                        $result = mysqli_query($con, $qry1);

                        while ($row = mysqli_fetch_array($result)) {
                            $owner_id = $row['user_id'];
                            $owner_name = $row['user_name'];

                            if (($sess_user_id == $owner_id) && ($sess_user_name == $owner_name)) {
                                //delete file from file system.
                                $file_path = "uploads/" . $row['stored_name'];
                                $res_del_file_system = unlink($file_path);
                                $qry2 = "DELETE FROM `file_data` WHERE `file_data`.`file_id` = '$id'";
                                $res_del_db = mysqli_query($con, $qry2);

                                if ((!$res_del_file_system) || ($res_del_db == FALSE)) {
                                    $fail_msg = "<h3 style = 'color:red;'>Unable to delete file = \"" . $row['name'] . "\". FILE ID = $id. </h3>";
                                    echo $fail_msg;
                                } else {
                                    $error_flag = FALSE;
                                }
                            } else {
                                $illegal_access_msg = "<h3 style = 'color:red;'>Sorry you don't have ownership on the file you are trying to delete. FILE ID = $id. </h3>";
                                echo $illegal_access_msg;
                            }
                        }
                    }
                    if ($error_flag == FALSE) {
                        ?>
                        <h2 style = 'color:#0b4a91;'>
                            Files deleted successfully.
                        </h2>
                        <br/>
                        <h2><a href = "index.php"> Back </a></h2>

                        <?php
                    } else {
                        ?>
                        <h2 style = 'color:red'>
                            Something went wrong with delete script!
                        </h2>
                        <br/>
                        <h2><a href = "index.php"> Back </a></h2>
                        <?php
                    }
                    mysqli_close($con);
                } else {
                    header("location:index.php");
                }
            } else {
                header("location:../login.php");
            }
            ?>
        </div>
    </body>
</html>
<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->



<?php
session_start();
include '../db_connect_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {

    if (isset($_POST['link_txt']) && isset($_POST['description']) && isset($_POST['submit_btn'])) {
        error_reporting(0); // Don't display any errors.
        //Connect to database
        $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
        if (!$con) {
            die('Could not connect to database : ' . mysql_error());
        }

        date_default_timezone_set("Asia/Kolkata"); //To set Indian Time zone
        $link_txt = mysqli_real_escape_string($con, $_POST['link_txt']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $user_name = $_SESSION['user_name'];
        $user_id = $_SESSION['user_id'];
        $added_on = date('Y-m-d H:i:s');
        $views = 0;

        $qry = "INSERT INTO `link_data` (`link_id`, `user_id`, `user_name`, `link_txt`, `description`, `added_on`, `views`) VALUES (NULL, '$user_id', '$user_name', '$link_txt', '$description', '$added_on', 0);";
        $res = mysqli_query($con, $qry);
        mysqli_close($con);
        if ($res) {
            header("location:index.php");
        } else {
            ?>
            <html>
                <head>
                    <title>Add link</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <script src="../libraries/jquery-3.1.1.min.js"></script>
                    <link href="../libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                    <link href="../libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                    <script src="../libraries/bootstrap/js/bootstrap.js"></script>
                </head>

                <body>
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
                                    <ul class="nav navbar-nav navbar-right">                                
                                        <li id="list_id_logout"><a href="../logout.php"><span class="glyphicon glyphicon-log-out" style="font-size: 20px; color:white;"></span><span style="font-size:medium;color:#ffffff;">&nbsp; LOGOUT</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>    

                    <div style="padding-top: 100px;"><h2 style="color:red;text-align:center;"> XX: Error while inserting in MySQL :XX </h2> </div>
                </body>
            </html>

            <?php
        }
    } else {
        ?>

        <html>
            <head>
                <title>Add link</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script src="../libraries/jquery-3.1.1.min.js"></script>
                <link href="../libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                <link href="../libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                <script src="../libraries/bootstrap/js/bootstrap.js"></script>
            </head>

            <body> 
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
                                    <li id="list_id_logout"><a href="../index.php"><span class="glyphicon glyphicon-home" style="font-size: 20px; color:white;"></span><span style="font-size: medium;color:#ffffff;">&nbsp; HOME </span></a></li>
                                </ul>
                                <ul class="nav navbar-nav">
                                    <li id="list_id_link_explorer"><a href="index.php"><span class="glyphicon glyphicon-th-list" style="font-size: 20px; color:white;"></span><span style="font-size: medium;color:#ffffff;">&nbsp; LINK EXPLORER </span></a></li>
                                </ul>
                                <ul class="nav navbar-nav navbar-right">                                
                                    <li id="list_id_logout"><a href="../logout.php"><span class="glyphicon glyphicon-log-out" style="font-size: 20px; color:white;"></span><span style="font-size:medium;color:#ffffff;">&nbsp; LOGOUT</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>  

                <div class="container" style="padding-top: 100px;">
                    <form action="" method="post" style="padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border: 0px solid #080808; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                        <h2 style="color:#0b4a91;">Input link details</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Paste / Type link here</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea rows="2" cols="50" name="link_txt" placeholder="Enter link text" required="required" class="form-control" style="padding:20px 20px 20px 20px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">                        
                            <div class="col-md-4">
                                <h4>Enter the link description</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">  
                                    <textarea rows="5" cols="50" name="description" placeholder="Enter the description here" required="required" class="form-control" style="padding:20px 20px 20px 20px;"></textarea>
                                </div>
                            </div>
                        </div>   

                        <div class="form-group">                  
                            <button type="submit" class="btn btn-success" name="submit_btn">
                                <span class="glyphicon glyphicon-send"></span> &nbsp; Submit
                            </button> 
                            <input class="btn btn-warning" style="float:right;" value="RESET" type="reset">
                        </div>
                    </form>           
                </div>
            </body>
        </html>
        <?php
    }
} else {
    header("location:../login.php");
}
?>

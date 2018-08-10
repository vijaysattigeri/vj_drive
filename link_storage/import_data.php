<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->



<html>
    <head>
        <title>Import File</title>
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


        <?php
        session_start();
        include '../db_connect_params.inc';

        if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
            if (isset($_POST['submit_import_file'])) {
                $sess_user_name = $_SESSION['user_name'];
                $sess_user_id = $_SESSION['user_id'];
                $internal_file_name = "process/" . $sess_user_name . ".xml"; // File name we generate for processing. To make file names unique (All user's files are stored in the same directory) I am using their user name as file name.
                //Upload file
                move_uploaded_file($_FILES['file_vj']['tmp_name'], "$internal_file_name");

                $xml_content = file_get_contents($internal_file_name); //read file
                //Parse XML data using PHP built in functions
                $parser_object = xml_parser_create();
                $parsed_data = array();
                $ret_flag = xml_parse_into_struct($parser_object, $xml_content, $parsed_data);
                xml_parser_free($parser_object); // Clear off the memory for parser resource
                if ($ret_flag == 1) {

                    //VIJAY logic to get info efficiently
                    $my_own_array = array();
                    $i = 0;
                    $j = 0;
                    foreach ($parsed_data as $each_rec) {
                        // 3 level deep my leaf data exist. It's confusing, to get the clear picture prin the XML parsed array using print_r() you will get to know.
                        if ($each_rec['level'] == 3) {
                            if ($j > 3) {
                                $i = $i + 1; // row increment.
                                $j = 0;
                            }
                            $my_own_array[$i][$j] = $each_rec['value'];
                            $j = $j + 1; //each field(column)
                        }
                    }

                    //Put into database
                    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
                    if (!$con) {
                        die('Could not connect to database: ' . mysql_error());
                    }
                    foreach ($my_own_array as $each_row) {
                        $link = htmlspecialchars_decode($each_row[0]);
                        $description = htmlspecialchars_decode($each_row[1]);
                        $added_date = htmlspecialchars_decode($each_row[2]);
                        $views = (int) htmlspecialchars_decode($each_row[3]); // type cast to integer

                        $qry = "INSERT INTO `link_data` (`link_id`, `user_id`, `user_name`, `link_txt`, `description`, `added_on`, `views`) VALUES (NULL, '$sess_user_id', '$sess_user_name', '$link', '$description', '$added_date', $views);";
                        $res = mysqli_query($con, $qry);
                    }
                    ?>
                    <div style="padding-left: 100px;padding-top: 100px;">
                        <h2 style="color:#0b4a91;">Successfully imported your data!!!.</h2>            
                    </div>

                    <?php
                    mysqli_close($con);
                } else {
                    ?>
                    <div style="padding-left: 100px;padding-top: 100px;">
                        <h2 style="color:red;">Corrupted file. Import not possible. Please upload valid XML file.</h2>            
                    </div>

                    <?php
                }

                //After processing clean off the file from "process" directory 
                if (file_exists($internal_file_name)) {
                    unlink($internal_file_name);
                }
            } else {
                ?>


                <div class="container" style="padding-top: 100px;">
                    <form action="" method="post" enctype="multipart/form-data" style="padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border: 0px solid #080808; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                        <h2 style="color:#0b4a91;">Browse and select the XML file to be imported.</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-2">
                                <h4>Select the file</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="file" name="file_vj" accept="./*" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div> 

                        <br/>
                        <br/>
                        <br/> 

                        <div class="form-group">                  
                            <button type="submit" class="btn btn-success" name="submit_import_file">
                                <span class="glyphicon glyphicon-send"></span> &nbsp; Submit
                            </button> 
                            <input class="btn btn-warning" style="float:right;" value="RESET" type="reset">
                        </div>
                    </form>           
                </div>

                <?php
            }
        } else {
            header("location:../login.php");
        }
        ?>
    </body>
</html>


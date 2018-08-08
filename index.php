<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php
session_start();
include 'db_connect_params.inc';
?>
<html>

    <head>
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- First INCLUDE JQuery library later include/link bootstrap-->
        <script src="libraries/jquery-3.1.1.min.js"></script>
        <link href="libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
        <link href="libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
        <script src="libraries/bootstrap/js/bootstrap.js"></script>
    </head>

    <body style="padding-top:80px; background-image:url(home_background.jpg); background-size:100%;background-attachment:fixed;">
        <!--Style By Vijay-->

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
                            <li id="list_id_home"><a href="index.php"><span class="glyphicon glyphicon-home" style="font-size: 20px; color:white;"></span><span style="font-size: medium;color:#ffffff;">&nbsp; HOME </span></a></li>
                        </ul>
                        <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) { ?>
                            <ul class="nav navbar-nav navbar-right">                                
                                <li id="list_id_logout"><a href="logout.php"><span class="glyphicon glyphicon-log-out" style="font-size: 20px; color:white;"></span><span style="font-size:medium;color:#ffffff;">&nbsp; LOGOUT</span></a></li>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </div>  

        <div class="container-fluid">  

            <div class="row" style="padding: 50px 50px 50px 50px;">      

                <div class="col-md-5" style="background-color:white;border-radius:20px 20px; box-shadow:0 1px 100px rgb(11, 74, 145);">
                    <div id="file_explorer_div">
                        <br/>
                        <h2 style="text-align:center;"><a href="file_storage/index.php">File Explorer</a></h2>
                        <br/>
                        <br/>
                        <br/>
                        <ul style="text-align: left;list-style: none; font-size: 20px;">
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>Lets you store your files in the server</li>
                            <br />
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>You can download your files anytime, anywhere</li>
                            <br />
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>You can delete your files anytime(It can't be undone)</li>
                            <br/>
                            <br/>
                            <br/>                                
                        </ul>                            
                    </div>
                </div>

                <div class="col-md-2">

                </div>

                <div class="col-md-5" style="background-color:white;border-radius:20px 20px; box-shadow:0 1px 100px rgb(11, 74, 145);">
                    <div id="link_explorer_div">
                        <br />
                        <h2 style="text-align:center;"><a href="link_storage/index.php">URL Explorer</a></h2>
                        <br/>
                        <br/>
                        <br/>
                        <ul style="text-align: left;list-style: none; font-size: 20px;">
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>Lets you store your favorite URL links which are too long to remember</li>
                            <br />
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>You can view and delete the links and associated data</li>
                            <br />
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>You will see most visited and recent links first</li>
                            <br/>
                            <br/>
                            <br/>                                
                        </ul>                            
                    </div>
                </div>

            </div> 

            <div class="row" style="padding: 50px 50px 50px 50px;">      

                <div class="col-md-5" style="background-color:white;border-radius:20px 20px; box-shadow:0 1px 100px rgb(11, 74, 145);">
                    <div id="index_of_div">
                        <br />
                        <h2 style="text-align:center;"><a href="index_of/index.php">Index Of</a></h2>
                        <br/>
                        <br/>
                        <br/>
                        <ul style="text-align: left;list-style: none; font-size: 20px;">
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>Lets anyone upload files in the public directory.</li>
                            <br />
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>Uses standard directory viewing interface.</li>
                            <br />
                            <li><span class="glyphicon glyphicon-arrow-right">&nbsp;</span>Files are READ ONLY, request administrator to delete any file.</li>
                            <br/>
                            <br/>
                            <br/>                                
                        </ul>                            
                    </div>
                </div>

                <div class="col-md-2">

                </div>

                <div class="col-md-5">

                </div>
            </div> 
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <!-- Put admin(my) contact info and source code download link or repository link in this footer -->
        <footer style="background-color: #ffffff;">
            <div style="text-align:center;padding: 5px;">
                <h3>VJ Drive 1.0 </h3>
                <h4>Get source code <a href="index_of/uploads/vj_drive.zip"> here. </a>   &nbsp;  OR visit GitHub repository <a href="https://github.com/vijaythreadtemp/vj_drive.git" target="_blank"> here.</a></h4>
                <h4>Contact author: <a href="mailto:vijay.thread.temp@gmail.com">vijay.thread.temp@gmail.com</a> </h4>
            </div>
        </footer>
    </body>
</html>
<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php
if (isset($_POST['submit_btn']) && ($_FILES['multiple_files_vj']['name'][0] != "")) {
    //Can not check isset($_FILES['multiple_files_vj']['name'][0]), since $_FILES['multiple_files_vj']['name'][0] will return rvalue (NOT lvalue) which will be string literal or numeric data. We can use isset() to only variables(lvalue)

    $multiple_files_name = $_FILES['multiple_files_vj']['name'];
    $multiple_files_size = $_FILES['multiple_files_vj']['size'];
    $multiple_files_temp = $_FILES['multiple_files_vj']['tmp_name'];
    $multiple_files_error = $_FILES['multiple_files_vj']['error'];

    $i = 0;
    foreach ($multiple_files_name as $f_name) {
        if ($f_name != "") {
            move_uploaded_file($multiple_files_temp[$i], "uploads/$f_name");
            $i++;
        }
    }
    ?>

    <html>
        <head>
            <title>Upload files </title>
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
                                <li id="list_id_file_explorer"><a href="uploads/"><span class="glyphicon glyphicon-th-list" style="font-size: 20px; color:white;"></span><span style="font-size: medium;color:#ffffff;">&nbsp; FILE EXPLORER </span></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div style="padding-left:100px;padding-top:100px;">
                <h2 style="color:#0b4a91;">
                    Files have been successfully uploaded to public directory.
                </h2>

            </div>

        </body>
    </html>


    <?php
} else {
    header("location:index.php");
}
?>
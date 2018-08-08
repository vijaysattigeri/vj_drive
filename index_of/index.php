<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<html>
    <head>
        <title>Upload files dialog</title>
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

        <div class="container" style="padding-top: 100px;">
            <form action="upload_script.php" method="post" enctype="multipart/form-data" style="padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border: 0px solid #080808; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                <h2 style="color:#0b4a91;">Browse files and select </h2>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h4>Upload files (Max. 10 files)</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="multiple_files_vj[]" accept="./*" multiple="true" class="form-control" />
                        </div>
                    </div>
                </div> 

                <br/>
                <br/>
                <br/> 

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

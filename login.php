<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php
session_start();
require 'libraries/PHPMailer/PHPMailerAutoload.php';
include 'db_connect_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
    header("location:index.php");
}

$invalid_credentials = ""; // Global scope
if (isset($_POST['login_submit'])) {

// Check for username existence and accordingly set the error-message.
    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
    if (!$con) {
        die('Could not connect to database : ' . mysql_error());
    }

    $read_email_id = mysqli_real_escape_string($con, trim($_POST['email_id']));
    $read_user_password_hash = md5($_POST['user_password']);


    $qry1 = "select user_id from user_accounts where user_name='$read_email_id' AND password='$read_user_password_hash';";
    $res1 = mysqli_query($con, $qry1);
    if ($res1->num_rows == 0) {
        $invalid_credentials = "<span id='invalid_credentials_id' style='display:inline;color:red'><br /> Incorrect login details please try again.</span>";
        mysqli_close($con);
    } else {
        $row1 = mysqli_fetch_assoc($res1);
        $_SESSION['user_name'] = $read_email_id;
        $_SESSION['user_id'] = $row1['user_id'];
        mysqli_close($con);
        header("location:index.php");
    }
}
?>
<!-- Don't put below code in PHP else clause. I need both blocks to be executed. -->
<html>

    <head>
        <title>VJ Drive login </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="libraries/jquery-3.1.1.min.js"></script>
        <link href="libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
        <link href="libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
        <script src="libraries/bootstrap/js/bootstrap.js"></script>

        <script type="text/javascript">

            function dismiss_error_message(span_id) {
                document.getElementById(span_id).style.display = "none";
            }

        </script>
    </head>

    <body style="padding-top:30px; background-image:url(home_background.jpg); background-size:100%;background-attachment:fixed;">
        <div style="margin-top: 90px;">
            <div class="container">
                <!-- action attribute is not specified in form tag, in this case control will flow to the same page.(Current runnin script) -->
                <form method="post" style="max-width:500px;padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                    <h2 style="color:#0b4a91;">Login</h2>
                    <hr/>

                    <div class="form-group">
                        <label>   Email ID <br/> </label>
                        <input type="email" id="email_id" name="email_id" maxlength="95" class="form-control" placeholder="Enter Email ID here" required="required" onclick="dismiss_error_message('invalid_credentials_id');" />
                    </div>

                    <div class="form-group">
                        <label>   Password <br/> </label>
                        <input type="password" id="user_password" name="user_password" maxlength="95" class="form-control" placeholder="Enter password here" required="required" onclick="dismiss_error_message('invalid_credentials_id');" />
                    </div>
                    <a href="forgot_password.php" style = "float:right;"> Forgot password? </a>
                    <br/>
                    <?php
                    if (isset($invalid_credentials)) {
                        echo $invalid_credentials;
                    }
                    ?>

                    <br />
                    <br />
                    <br />
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="login_submit">
                            <span class="glyphicon glyphicon-log-in" style="font-size:20px;"></span> &nbsp; Login
                        </button>
                        <a style="float:right;" class="btn btn-primary"  href="register.php"><span class="glyphicon glyphicon-plus-sign" style="font-size:20px;"></span> &nbsp; Create a new account</a>
                    </div>

                </form>
            </div>
        </div>
    </body>

</html>
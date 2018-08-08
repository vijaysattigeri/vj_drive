<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php
session_start();
include 'db_connect_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
    header("location:index.php");
} else if (isset($_SESSION['reset_user_name']) && isset($_SESSION['reset_user_id'])) {
    if (isset($_POST['reset_otp_check_sub'])) {

        $form_otp = $_POST['otp'];
        $form_password = $_POST['user_password'];
        $sess_reset_user_name = $_SESSION['reset_user_name'];
        $sess_user_id = $_SESSION['reset_user_id'];

        // Check for username existence and accordingly set the error-message.
        $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
        if (!$con) {
            die('Could not connect to database : ' . mysql_error());
        }
        $form_password_hash = md5($form_password);


        $qry1 = "select otp from user_accounts where user_name='$sess_reset_user_name' AND user_id=$sess_user_id;";
        $res1 = mysqli_query($con, $qry1);
        $row1 = mysqli_fetch_assoc($res1);
        $db_otp = $row1['otp'];

        if ($db_otp == $form_otp) {
            //Update password
            $qry2 = "UPDATE user_accounts SET password='$form_password_hash', otp=0 WHERE user_id=$sess_user_id AND user_name='$sess_reset_user_name';";
            $res2 = mysqli_query($con, $qry2);

            mysqli_close($con);

            //Clear all sessioin data (See logout.php file for more info)
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), "", time() - 3600, "/");
            }
            $_SESSION = array(); //clear session from globals
            session_destroy(); //clear session from disk
            ?>

            <html>
                <head>
                    <title>Password Reset </title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <script src="libraries/jquery-3.1.1.min.js"></script>
                    <link href="libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                    <link href="libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                    <script src="libraries/bootstrap/js/bootstrap.js"></script>
                </head>

                <body>
                    <div style="padding-left:100px;padding-top:100px;">
                        <h3 style="color:#009900;";> 
                            Password has been updated successfully.
                        </h3>
                        <h3>
                            <a href="index.php"> Click here to go Home page </a>
                        </h3>
                        <div>
                            </body>
                            </html>
                            <?php
                        } else {
                            mysqli_close($con);
                            ?>
                            <html>
                                <head>
                                    <title>Password Reset </title>
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <script src="libraries/jquery-3.1.1.min.js"></script>
                                    <link href="libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                                    <link href="libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                                    <script src="libraries/bootstrap/js/bootstrap.js"></script>
                                </head>

                                <body>
                                    <div style="padding-left:100px;padding-top:100px;">
                                        <h3 style="color:red;";> 
                                            Incorrect OTP. Please enter Recent OTP sent to your email.
                                        </h3>
                                        <h3>
                                            <a href="reset_password.php"> Back </a>
                                        </h3>
                                        <div>
                                            </body>
                                            </html>


                                            <?php
                                        }
                                    } else {
                                        ?>

                                        <html>
                                            <head>
                                                <title>Password Reset </title>
                                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                <script src="libraries/jquery-3.1.1.min.js"></script>
                                                <link href="libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
                                                <link href="libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
                                                <script src="libraries/bootstrap/js/bootstrap.js"></script>

                                                <script type="text/javascript">
                                                    function validate_input() {
                                                        var user_password = document.getElementById('user_password').value;
                                                        var confirm_password = document.getElementById('confirm_password').value;
                                                        var reg_exp_email = /^[_.@0-9a-z]*$/i; // dots and @ symbol are allowed.               
                                                        var error_flag = false;
                                                        if (user_password.search(reg_exp_email) != 0) {
                                                            error_flag = true;
                                                            document.getElementById('user_password_error').style.display = "inline";
                                                        }
                                                        if (user_password != confirm_password) {
                                                            error_flag = true;
                                                            document.getElementById('confirm_password_error').style.display = "inline";
                                                        }
                                                        if (error_flag == true) {
                                                            return false;
                                                            //Invalid input is given.
                                                        } else {
                                                            return true;
                                                            // Valid input is given.
                                                        }
                                                    }

                                                    function dismiss_error_message(span_id) {
                                                        document.getElementById(span_id).style.display = "none";
                                                    }

                                                </script>
                                            </head>

                                            <body style="padding-top:30px; background-image:url(home_background.jpg); background-size:100%;background-attachment:fixed;">
                                                <div style="margin-top: 90px;">
                                                    <div class="container">
                                                        <!-- action attribute is not specified in form tag, in this case control will flow to the same page.(Current runnin script) -->
                                                        <form method="post" onsubmit="return validate_input();" style="max-width:500px;padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                                                            <h2 style="color:#0b4a91;">Reset Password</h2>
                                                            <hr/>

                                                            <div class="form-group">
                                                                <label> OTP <br/> </label>
                                                                <input type="text" id="otp_id" name="otp" maxlength="95" class="form-control" placeholder="Enter OTP here" required="required" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label>   Password <br/> </label>
                                                                <input type="password" id="user_password" name="user_password" maxlength="95" class="form-control" placeholder="Enter password here" required="required" onclick="dismiss_error_message('user_password_error');" />
                                                                <span id="user_password_error" style="display:none;color:red">Invalid password. Only underscore(_) dot(.) @ numbers[0-9] and alphabets are allowed.</span>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>   Confirm password <br/> </label>
                                                                <input type="password" id="confirm_password" name="confirm_password" maxlength="95" class="form-control" placeholder="Re-enter password here" required="required" onclick="dismiss_error_message('confirm_password_error');" />
                                                                <span id="confirm_password_error" style="display:none;color:red">Password DOES NOT match to above typed one.</span>
                                                            </div>

                                                            <br />
                                                            <br />
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary" name="reset_otp_check_sub">
                                                                    <span class="glyphicon glyphicon-floppy-disk" style="font-size:20px;"></span> &nbsp; Submit
                                                                </button>
                                                                <a style="float:right;" class="btn btn-primary"  href="login.php"><span class="glyphicon glyphicon-log-in" style="font-size:20px;"></span> &nbsp; Login Instead </a>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </body>
                                        </html>

                                        <?php
                                    }
                                } else {
                                    header("location:index.php");
                                }
                                ?>
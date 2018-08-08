<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php
session_start();
require 'libraries/PHPMailer/PHPMailerAutoload.php';
include 'db_connect_params.inc';
include 'email_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
    header("location:index.php");
}

$email_exist_message = ""; // Global scope
if (isset($_POST['register_submit'])) {

// Check for username existence and accordingly set the error-message.
    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
    if (!$con) {
        die('Could not connect to database : ' . mysql_error());
    }

    $read_email_id = mysqli_real_escape_string($con, trim($_POST['email_id']));
    $read_user_password_hash = md5($_POST['user_password']);

    date_default_timezone_set("Asia/Kolkata");
    $account_created_date = date('Y-m-d H:i:s');

    $qry1 = "select user_id from user_accounts where user_name='$read_email_id';";
    $res1 = mysqli_query($con, $qry1);
    if ($res1->num_rows != 0) {
        $email_exist_message = "<span id='email_id_exists' style='display:inline;color:red'><br /> Email already exists. Please choose another one.</span>";
        mysqli_close($con);
    } else {
        $qry2 = "INSERT INTO `user_accounts` (`user_id`, `user_name`, `password`, `otp`, `created_on`) VALUES (NULL, '$read_email_id', '$read_user_password_hash', 0, '$account_created_date');";
        $res2 = mysqli_query($con, $qry2);
        if (!$res2) {
            echo "<h1  style='color:red'>Error in inserting user account details. Script is going to EXIT.<br> Details : " . mysqli_error($con) . "</h1>";
            mysqli_close($con);
            exit(2);
        }

        $qry3 = "select user_id from user_accounts where user_name='$read_email_id';";
        $res3 = mysqli_query($con, $qry1);
        $row3 = mysqli_fetch_assoc($res3);

        $_SESSION['user_name'] = $read_email_id;
        $_SESSION['user_id'] = $row3['user_id'];
        mysqli_close($con);

        //Trivial: Send welcome email
        $msg_sub = "Greetings from VJ Drive";
        $msg_body = "<h3 style='color:#0b4a91;'>Hi $read_email_id, Welcome to  VJ Drive. Thanks for registering with us.</h3>";
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $admin_email_user_name;
        $mail->Password = $admin_email_password;
        $mail->setFrom($admin_email_user_name);
        $mail->addAddress($read_email_id);
        $mail->isHTML(TRUE); // To send the HTML formatted text.
        $mail->Subject = $msg_sub;
        $mail->Body = $msg_body;
        $mail->send();
        // Don't care even if the above email sending fails, it's just a greeting message!
        header("location:index.php");
    }
}
?>
<!-- Don't put below code in PHP else clause. I need both blocks to be executed. -->
<html>

    <head>
        <title>VJ Drive registration </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="libraries/jquery-3.1.1.min.js"></script>
        <link href="libraries/bootstrap/css/bootstrap-theme.css" rel="stylesheet" />
        <link href="libraries/bootstrap/css/bootstrap.css" rel="stylesheet" />
        <script src="libraries/bootstrap/js/bootstrap.js"></script>

        <script type="text/javascript">
            function validate_input() {
                var email_id = document.getElementById('email_id').value;
                var user_password = document.getElementById('user_password').value;
                var confirm_password = document.getElementById('confirm_password').value;

                var reg_exp_email = /^[_.@0-9a-z]*$/i; // dots and @ symbol are allowed.               
                var error_flag = false;
                if (email_id.search(reg_exp_email) != 0) {
                    error_flag = true;
                    document.getElementById('email_id_error').style.display = "inline";
                }
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

            //To dismiss user name (Email) related errors as it takes two parameters
            function dismiss_error_message_email_exists(span_id1, span_id2) {
                document.getElementById(span_id1).style.display = "none";
                document.getElementById(span_id2).style.display = "none";
            }

        </script>
    </head>

    <body style="padding-top:30px; background-image:url(home_background.jpg); background-size:100%;background-attachment:fixed;">
        <div style="margin-top: 90px;">
            <div class="container">
                <!-- action attribute is not specified in form tag, in this case control will flow to the same page.(Current runnin script) -->
                <form method="post" onsubmit="return validate_input();" style="max-width:500px;padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                    <h2 style="color:#0b4a91;">Sign up</h2>
                    <hr/>

                    <div class="form-group">
                        <label>   Email ID <br/> </label>
                        <input type="email" id="email_id" name="email_id" maxlength="95" class="form-control" placeholder="Enter Email ID here" required="required" onclick="dismiss_error_message_email_exists('email_id_error', 'email_id_exists');" />
                        <span id="email_id_error" style="display:none;color:red">Invalid Email-ID. Only underscore(_) dot(.) @ numbers[0-9] and alphabets are allowed.</span>
                        <?php
                        if (isset($email_exist_message)) {
                            echo $email_exist_message;
                        }
                        ?>
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

                    <div>
                        <br/>
                        <p> By clicking <b>Create Account </b> you agree <a href="Mozilla_MPL2_0.txt" target="_blank"> Mozilla MPL 2.0 </a> terms and conditions.</p> 
                    </div>                  

                    <br />
                    <br />
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="register_submit">
                            <span class="glyphicon glyphicon-plus-sign" style="font-size:20px;"></span> &nbsp; Create Account
                        </button>
                        <a style="float:right;" class="btn btn-primary"  href="login.php"><span class="glyphicon glyphicon-log-in" style="font-size:20px;"></span> &nbsp; Login Instead </a>
                    </div>

                </form>
            </div>
        </div>
    </body>

</html>
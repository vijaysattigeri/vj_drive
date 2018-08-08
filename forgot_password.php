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

$no_email_id = ""; // Global scope
if (isset($_POST['get_otp_submit'])) {

// Check for username existence and accordingly set the error-message.
    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
    if (!$con) {
        die('Could not connect to database : ' . mysql_error());
    }

    $read_email_id = mysqli_real_escape_string($con, trim($_POST['email_id']));

    $qry1 = "select user_id from user_accounts where user_name='$read_email_id';";
    $res1 = mysqli_query($con, $qry1);
    if ($res1->num_rows == 0) {
        $no_email_id = "<span id='no_email_id' style='display:inline;color:red'><br /> This email ID is NOT found in our database!</span>";
        mysqli_close($con);
    } else {
        $row1 = mysqli_fetch_assoc($res1);
        $reset_user_id = $row1['user_id'];
        $_SESSION['reset_user_name'] = $read_email_id;
        $_SESSION['reset_user_id'] = $reset_user_id;

        //Generate OTP and insert it into database and mail it.
        $otp = rand(0, 65000);
        $qry2 = "UPDATE `user_accounts` SET `otp` = $otp WHERE `user_accounts`.`user_id` = $reset_user_id;";
        $res2 = mysqli_query($con, $qry2);
        mysqli_close($con);

        //mailing OTP
        $msg_sub = "VJ Drive: OTP for forgot password action.";
        $msg_body = "<h3 style='color:#0b4a91;'>Hi $read_email_id, your OTP is : $otp </h3>";
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
        //end mailing OTP

        header("location:reset_password.php");
    }
}
?>
<!-- Don't put below code in PHP else clause. I need both blocks to be executed. -->
<html>

    <head>
        <title>VJ Drive forgot password helper </title>
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
                <form method="post" style="max-width:500px;padding:19px 29px 29px;margin: 0 auto;background-color:#f2f2f2; border-radius: 5px;box-shadow: 0 1px 70px rgb(0, 0, 0);font-family: Tahoma, Geneva, sans-serif;font-weight: lighter;">
                    <h2 style="color:#0b4a91;">Forgot password helper</h2>
                    <hr/>

                    <div class="form-group">
                        <label>   Email ID <br/> </label>
                        <input type="email" id="email_id" name="email_id" maxlength="95" class="form-control" placeholder="Enter Email ID here" required="required" onclick="dismiss_error_message('no_email_id');" />
                    </div>
                    <br/>
                    <?php
                    if (isset($no_email_id)) {
                        echo $no_email_id;
                    }
                    ?>
                    <br />
                    <br />
                    <br />
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="get_otp_submit">
                            <span class="glyphicon glyphicon-send" style="font-size:20px;"></span> &nbsp; Get OTP
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </body>

</html>
<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->


<?php

session_start();
include '../db_connect_params.inc';
if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {
    if (isset($_POST['submit_btn']) && ($_FILES['multiple_files_vj']['name'][0] != "") && isset($_POST['note'])) {
        //Can not check isset($_FILES['multiple_files_vj']['name'][0]), since $_FILES['multiple_files_vj']['name'][0] will return rvalue (NOT lvalue) which will be string literal or numeric data. We can use isset() to only variables(lvalue)

        $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
        if (!$con) {
            die('Could not connect to database : ' . mysql_error());
        }
        $multiple_files_name = $_FILES['multiple_files_vj']['name'];
        $multiple_files_size = $_FILES['multiple_files_vj']['size'];
        $multiple_files_temp = $_FILES['multiple_files_vj']['tmp_name'];
        $multiple_files_error = $_FILES['multiple_files_vj']['error'];
        $note = $_REQUEST['note'];
        $user_name = $_SESSION['user_name'];
        $user_id = $_SESSION['user_id'];

        //Error checking
        $error_flag = 0;
        if ($multiple_files_name[0] != "") {
            $j = 0;
            foreach ($multiple_files_name as $at_name) {
                if ($multiple_files_error[$j] != 0) {
                    echo"<html><head><title>Upload error</title><script type='text/javascript'>function time_load(){  setTimeout(redirect, 5000);} function redirect() { window.location.href = 'index.php'; } </script></head><body onload='time_load()'><h1 style='color:red'>Error occured in uploading files. Please check the size and other parameters.<br/>Redirecting wait...</h1></body></html>";
                    $error_flag = 1;
                    mysqli_close($con);
                    exit(3);
                }
                $j++;
            }
        }

        if ($error_flag == 0) {     // only if NO ERROR found
            $i = 0;
            foreach ($multiple_files_name as $f_name) {
                if ($f_name != "") {
                    date_default_timezone_set("Asia/Kolkata"); //To set Indian Time zone
                    $dt = date('Y-m-d H:i:s');
                    $timestamp = time();
                    $extension = pathinfo($f_name, PATHINFO_EXTENSION);
                    $j = $i + 1;
                    if (strcasecmp($extension, "php") == 0) {
                        $extension = "txt_php";
                    }
                    $file_name_to_store = "file_" . $timestamp . "_" . $j . "_res." . $extension;
                    $actual_name = mysqli_real_escape_string($con, $f_name);
                    $note = mysqli_real_escape_string($con, $note);
                    $qry = "INSERT INTO `file_data` (`file_id`, `user_id`, `user_name`, `stored_name`, `name`, `note`, `upload_date`, `downloads`) VALUES (NULL, '$user_id', '$user_name', '$file_name_to_store', '$actual_name', '$note', '$dt', '0');";
                    $res = mysqli_query($con, $qry);
                    if ($res) {
                        move_uploaded_file($multiple_files_temp[$i], "uploads/$file_name_to_store");
                    } else {
                        echo '<br/><h2 style="color:red;text-align:center;"> XX: File upload error :XX </h2>';
                    }
                    $i++;
                }
            }
        }
        mysqli_close($con);
        header("location:index.php");
    } else {
        header("location:upload_media.php");
    }
} else {
    header("location:../login.php");
}
?>

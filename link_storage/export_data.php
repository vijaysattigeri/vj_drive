<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * */

session_start();
include '../db_connect_params.inc';

if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) {

    $sess_user_name = $_SESSION['user_name'];
    $sess_user_id = $_SESSION['user_id'];
    date_default_timezone_set("Asia/Kolkata"); //To set Indian Time zone
    $current_date = date('Y-m-d H:i:s');

    $out_file = $sess_user_name . ".txt";
    $fh = fopen($out_file, "w");
    fprintf($fh, "\n\n<!-- \n\tThis is comment.\n\tUser : $sess_user_name \n\tCreator: VJ-DRIVE Application\n\tDate created(IST): $current_date \n\tLanguage: XML\n\tUse XML Processor to extract this info. \n-->\n\n\n");

    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
    if (!$con) {
        die('Could not connect to database: ' . mysql_error());
    }

    $qry = "select * from link_data where user_id='$sess_user_id' AND user_name='$sess_user_name' order by views desc, added_on desc";
    $result = mysqli_query($con, $qry);
    while ($row = mysqli_fetch_array($result)) {
        $db_actual_link = "<vj_xml_actual_link>\n\t" . $row['link_txt'] . "\n</vj_xml_actual_link>\n";
        $db_description = "<vj_xml_description>\n\t" . $row['description'] . "\n</vj_xml_description>\n";
        $db_added_on = "<vj_xml_added_on>\n\t" . $row['added_on'] . "\n</vj_xml_added_on>\n";
        $db_views = "<vj_xml_views>\n\t" . $row['views'] . "\n</vj_xml_views>\n\n\n";
        $data_str = $db_actual_link . "\n" . $db_description . "\n" . $db_added_on . "\n" . $db_views . "\n";
        fprintf($fh, $data_str);
    }
    fclose($fh);
    mysqli_close($con);

    $out_file_size = filesize($out_file); // file size in bytes
    //Download script
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $out_file);
    header('Content-Transfer-Encoding: binary');
    header("Content-length: $out_file_size");

    // This data is NOT transferred to screen as we have changed headers in above lines to send as OCTET STREAM with binary data encoding (Default is ASCII)
    $file_handle = fopen($out_file, 'rb');
    if ($file_handle) {
        fpassthru($file_handle);
    }
    fclose($file_handle); // close after read
    //clean off file to avoid consuming space in directory
    if (file_exists($out_file)) {
        unlink($out_file);
    }
} else {
    header("location:../login.php");
}
?>

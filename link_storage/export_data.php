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

    $out_file = $sess_user_name . ".xml";
    $fh = fopen($out_file, "w");
    fprintf($fh, "\n\n<!-- \n\tThis is comment.\n\tUser : $sess_user_name \n\tCreator: VJ-DRIVE Application\n\tDate created(IST): $current_date \n\tLanguage: XML\n\tUse XML Processor to extract this info. \n-->\n\n\n");

    // Create root
    fprintf($fh, "<vj_drive_link_storage>\n");
    $con = mysqli_connect($database_host, $database_user, $database_password, $database_name);
    if (!$con) {
        die('Could not connect to database: ' . mysql_error());
    }

    $qry = "select * from link_data where user_id='$sess_user_id' AND user_name='$sess_user_name' order by views desc, added_on desc";
    $result = mysqli_query($con, $qry);
    while ($row = mysqli_fetch_array($result)) {
        $link_txt = htmlspecialchars($row['link_txt'], ENT_QUOTES);
        $description = htmlspecialchars($row['description'], ENT_QUOTES);
        $added_on = htmlspecialchars($row['added_on'], ENT_QUOTES);
        $views = htmlspecialchars($row['views'], ENT_QUOTES);

        fprintf($fh, "\t<each_row>\n");
        $db_actual_link = "\t\t<vj_xml_actual_link>\n\t\t\t" . $link_txt . "\n\t\t</vj_xml_actual_link>\n";
        $db_description = "\t\t<vj_xml_description>\n\t\t\t" . $description . "\n\t\t</vj_xml_description>\n";
        $db_added_on = "\t\t<vj_xml_added_on>\n\t\t\t" . $added_on . "\n\t\t</vj_xml_added_on>\n";
        $db_views = "\t\t<vj_xml_views>\n\t\t\t" . $views . "\n\t\t</vj_xml_views>\n";
        $data_str = $db_actual_link . $db_description . $db_added_on . $db_views;
        fprintf($fh, $data_str);
        fprintf($fh, "\t</each_row>\n");
    }
    fprintf($fh, "</vj_drive_link_storage>");
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

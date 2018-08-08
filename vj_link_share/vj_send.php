<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->

   

<?php

include 'link_storage.txt';
$log_file = "log_data.vj";
date_default_timezone_set("Asia/Kolkata"); //To set Indian Time zone
$dt = date('Y-m-d H:i:s');
if (!file_exists($log_file)) {
    $fh = fopen($log_file, "w");
    $cnt = 1;
    $data_str = $dt . "\t" . $cnt . "\n";
    fprintf($fh, $data_str);
    fclose($fh);
} else {
    $fh = fopen($log_file, "r");
    $read_data = fscanf($fh, "%s\t%s\t%d\n");
    fclose($fh);
    $cnt = $read_data[2] + 1; // view count incrementing. At this position(2) in the array count will be stored.

    $data_str = $dt . "\t" . $cnt . "\n";
    $fh = fopen($log_file, "w");
    fprintf($fh, $data_str);
    fclose($fh);
}
header("location:$vj_target_link");
?>
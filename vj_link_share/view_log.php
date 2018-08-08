<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->




<html>
    <head>
        <title> Link view log </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        include 'link_storage.txt';
        $log_file = "log_data.vj";
        if (file_exists($log_file)) {
            $fh = fopen($log_file, "r");
            $read_data = fscanf($fh, "%s\t%s\t%d\n");
            fclose($fh);
            $last_view_date = $read_data[0];
            $last_vew_time = $read_data[1];
            $view_count = $read_data[2];
            $str = "<div style='padding-left:100px;padding-top:100px;'><h2 style='color:red;'>Hi Vijay log for the link &nbsp;&nbsp;&nbsp; <a href='$vj_target_link'>$vj_target_link</a> &nbsp;&nbsp;&nbsp;is as follows : - </h2>";
            $str .= "<br/><table align='center' border='5' cellpadding='10'><tr align='left'><th>Last view</th><th>View count</th></tr><tr><td align='left'>$last_view_date &nbsp; $last_vew_time</td><td align='center'>$view_count</td></tr></table></div>";
            echo "$str";
        } else {
            echo "<div style='padding-left:100px;padding-top:100px;'><h2 style='color:red;'>Sorry log file does not exist...!!!</h2></div>";
        }
        ?>
    </body>
</html>
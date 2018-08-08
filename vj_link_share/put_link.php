<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->




<html>
    <head>
        <title> Input the link here </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        if (isset($_POST['input_link_sub'])) {
            $link_text = $_POST['link_text'];
            $data = "<?php    \$vj_target_link='$link_text';    ?>";
            $target_file_name = "link_storage.txt";
            $fh = fopen($target_file_name, "w");
            fprintf($fh, $data);
            fclose($fh);

            $log_file = "log_data.vj";
            // delete log file for fresh link.
            if (file_exists($log_file)) {
                unlink($log_file);
            }
            ?>
            <div style="padding-left:100px;padding-top:100px;">
                <h2 style="color:#0b4a91;">
                    Link updated successfully....

                </h2>
                <h3>
                    <a href='view_log.php'>View Log</a>
                </h3>

            </div>


            <?php
        } else {
            ?>
            <form action="" method="post">
                <div style="text-align:center;padding-top:100px;">
                    <h3>Input the link here/paste link : </h3>
                    <input type="url" name="link_text" size="50" placeholder="Paste/type link here" />
                    <br/>
                    <br/>
                    <input type="submit" name="input_link_sub" value="Update Link" />
                </div>
            </form>  
            <?php
        }
        ?>
    </body>
</html>

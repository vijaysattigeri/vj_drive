<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->



<htm>
    <head>
        <title> Delete a file </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div style="padding-left:100px;padding-top:100px;">

            <?php
            if (isset($_POST['delete_submit']) && isset($_POST['file_name']) && isset($_POST['passcode'])) {
                $file_name = "uploads/";
                $file_name = $file_name . $_POST['file_name'];
                $passcode = trim($_POST['passcode']);
                if ($passcode == "<PUT_SOME_PASSCODE_HERE_TO_GET_ADMIN_RIGHTS>") {
                    if (file_exists($file_name)) {
                        unlink($file_name);
                        ?>
                        <h2 style="color:#0b4a91;"> file <i>"<?php echo $_POST['file_name']; ?>"</i> deleted successfully! </h2>
                        <h2><a href="index.php"> File Explorer </a></h2>
                        <?php
                    } else {
                        ?>
                        <h2 style="color:red;"> file <i>"<?php echo $_POST['file_name']; ?>"</i> DOES NOT exist on the server! </h2>
                        <h2><a href="index.php"> File Explorer </a></h2>
                        <?php
                    }
                } else {
                    ?>
                    <h2 style="color:red;"> Wrong Passcode! You don't have  privilege to perform this action!!! </h2>
                    <h2><a href="index.php"> File Explorer </a></h2>
                    <?php
                }
            } else {
                ?>

                <form action="" method="post">
                    <h3>
                        Enter file name to be deleted (Do NOT add link / full path).
                    </h3>
                    <input type="text" name="file_name" placeholder="Enter file name here" size="35"/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <h3>
                        Enter passcode here to prove you have got privilege.
                    </h3>
                    <input type="text" name="passcode" placeholder="Enter passcode here" size="35"/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <input type="submit" value="DELETE" name="delete_submit" />
                </form>

                <?php
            }
            ?>

        </div>
    </body>
</htm>
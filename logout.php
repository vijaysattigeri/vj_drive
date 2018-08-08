<!-- This Source Code Form is subject to the terms of the Mozilla Public
   - License, v. 2.0. If a copy of the MPL was not distributed with this
   - file, You can obtain one at http://mozilla.org/MPL/2.0/. -->

<?php

session_start();

// Details: http://php.net/manual/en/function.session-destroy.php
//Clear the session information from cookie in case it has.
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), "", time() - 3600, "/");
}

//clear session from globals
$_SESSION = array();

//clear session from disk
session_destroy();

//Redirect to home
header("location:index.php");
?>
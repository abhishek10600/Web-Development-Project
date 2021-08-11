<?php
    session_start();
    echo "You are being logged out....please wait";
    session_destroy();
    header("Location: /forum")


?>
<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "wediscuss";

    $conn = mysqli_connect($servername,$username,$password,$database);

    if(!$conn)
    {
        die("There was an issue!");
    }

?>
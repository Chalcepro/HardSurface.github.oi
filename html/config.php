<?php


    $server = "localhost";
    $username = "root";
    $password = "";
    $datab = "OniBodeBest";

    $conn = mysqli_connect($server, $username, $password, $datab);

    if (!$conn) {
        die("Unable to connect to the server " .mysqli_connect_error());
    }

<?php

    session_start();

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "gym";

    $connection = mysqli_connect($servername, $db_username, $db_password, $db_name);

    if (!$connection) {
        die("Neuspesna konekcija");
    }
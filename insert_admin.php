<?php

require_once 'connection.php';

$username = 'admin2';
$password = 'admin';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admins(username, password) VALUES (?, ?)";
$run = $connection -> prepare($sql);
$run -> bind_param("ss", $username, $hashed_password);

if ($run -> execute()) {
    echo "Podaci su ubaceni u bazu";
} else {
    echo "Podaci nisu ubaceni u bazu";
}
<?php

    require_once 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO trainers (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)";
        $run = $connection -> prepare($sql);
        $run -> bind_param("ssss", $first_name, $last_name, $email, $phone);
        $run -> execute();

        $_SESSION['success_message'] = "Trainer successfully added!";
        header('location: admin_page.php');
        exit();
    }
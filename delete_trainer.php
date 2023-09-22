<?php

    require_once 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $trainer_id = $_POST['trainer_id'];

        $sql = "DELETE FROM trainers WHERE trainer_id = ?";
        $run = $connection -> prepare($sql);
        $run -> bind_param("i", $trainer_id);
        $message = "";

        if ($run -> execute()) {
            $message = "trainer deleted";
        } else {
            $message = "Something wrong";
        }

        $_SESSION['success_message'] = $message;
        header('location: admin_page.php');
        exit;
    }
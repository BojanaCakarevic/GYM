<?php

    require_once 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $member_id = $_POST['member_id'];

        $sql = "DELETE FROM members WHERE member_id = ?";
        $run = $connection -> prepare($sql);
        $run -> bind_param("i", $member_id);
        $message = "";

        if ($run -> execute()) {
            $message = "Member deleted";
        } else {
            $message = "Something wrong";
        }

        $_SESSION['success_message'] = $message;
        header('location: admin_page.php');
        exit;
    }
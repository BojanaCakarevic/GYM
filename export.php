<?php

    require_once 'connection.php';
    if (isset($_GET['what'])) {
        if ($_GET['what'] == 'members') {
            $sql = "SELECT * FROM members";
            $csv_cols = [
                "member_id",
                "first_name",	
                "last_name",
                "email",	
                "phone",	
                "photo_path",
                "access_card_pdf_path",	
                "training_plan_id",	
                "trainer_id",	
                "created_at"];
        } else if ($_GET['what'] == 'trainers') {
            $sql = "SELECT * FROM trainers";
            $csv_cols = [
                "trainer_id",
                "first_name",	
                "last_name",
                "email",	
                "phone",	
                "created_at"];
        } else {
            echo "Wrong!";
            die();
        }

    $run = $connection -> query($sql);
    $results = $run -> fetch_all(MYSQLI_ASSOC);
    $output = fopen('php://output', 'w');

    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename=' . $_GET['what'] . ".csv");
    fputcsv($output, $csv_cols);

    foreach($results as $result) {
        fputcsv($output, $result);
    }
    fclose($output);
    }
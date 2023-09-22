<?php 

require_once 'connection.php';
require_once 'fpdf/fpdf.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $photo_path = $_POST['photo_path'];
    var_dump($photo_path);
    $training_plan_id = $_POST['training_plan_id'];
    $trainer_id = $_POST['trainer'];
    $access_card_pdf_path = "";

    $sql = "INSERT INTO members
        (first_name, last_name, email, phone, photo_path, training_plan_id, trainer_id, access_card_pdf_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $run = $connection -> prepare($sql);
    $run -> bind_param("sssssiis", $first_name, $last_name, $email, $phone, $photo_path, $training_plan_id, $trainer_id, $access_card_pdf_path);
    $run -> execute();

    // insert_id je id unetog korisnika, to proverimo sledecim kodom
    // var_dump($connection);
    // die();

    // na ovaj nacin u novu varijablu smestamo procitani id
    $member_id = $connection -> insert_id;
    $pdf = new FPDF();
    $pdf -> AddPage();
    $pdf -> SetFont('Arial', 'B', 16);
    $pdf -> Cell (40, 10, 'Access Card');
    $pdf -> Ln();
    $pdf -> Cell(40, 10, 'Member ID: ' . $member_id);
    $pdf -> Ln();
    $pdf -> Cell(40, 10, 'Name: ' . $first_name . " " . $last_name);
    $pdf -> Ln();
    $pdf -> Cell(40, 10, 'Email: ' . $email);
    $pdf -> Ln();
    $file_name = 'access_cards/access_card_' . $member_id . '.pdf';
    $pdf -> Output('F', $file_name); 

    var_dump($photo_path);
    $sql = "UPDATE members SET access_card_pdf_path = '$file_name' WHERE member_id = $member_id";
    $connection -> query($sql);

    $_SESSION['success_message'] = 'Member successfully added!';
    header('location: admin_page.php');
    exit();
}

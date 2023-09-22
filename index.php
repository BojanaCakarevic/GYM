<?php

    require_once 'connection.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT admin_id, password FROM admins WHERE username = ?";

        $run = $connection -> prepare($sql);
        $run -> bind_param("s", $username);
        $run -> execute();

        $results = $run -> get_result();
    

        if ($results -> num_rows == 1) {
            $admin = $results -> fetch_assoc();

            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $connection -> close();
                header('location: admin_page.php');
            } else {
                $_SESSION['error'] = "Invalid password";
                $connection -> close();
                header('location: index.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid username";
            $connection -> close();
            header('location: index.php');
            exit();
        }

    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/index.css">
 </head>

    <body>
        <form action = "" method = "POST" class = "start">
            <div class="mb-3">
                ADMIN LOGIN
            </div>
            <div class="mb-3">
                 <label for="username" class="form-label">Username</label>
                 <input type = "text" name = "username" autocomplete="username">        
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type = "password" name = "password">
            </div>
                <input type = "submit" value = "Login">
        </form>
    </body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $userDetails = "$username|$email|$password\n";
    file_put_contents('users.txt', $userDetails, FILE_APPEND | LOCK_EX);

    header('Location: login.php');
    exit;
}
?>

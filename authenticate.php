<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($users as $user) {
        list($username, $storedEmail, $storedPassword) = explode('|', $user);
        
        if ($email === $storedEmail && password_verify($password, $storedPassword)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = ($email === 'admin@example.com') ? 'admin' : 'user';

            header('Location: dashboard.php');
            exit;
        }
    }

    // If authentication failed
    header('Location: login.php');
    exit;
}
?>

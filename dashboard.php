<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

echo '<h2>Welcome, ' . $_SESSION['username'] . '!</h2>';
echo 'Role: ' . $_SESSION['role'];

// Logout link
echo '<p><a href="logout.php">Logout</a></p>';

// Redirect based on role
if ($_SESSION['role'] === 'admin') {
    echo '<p><a href="role_management.php">Role Management</a></p>';
} else {
    echo '<p>User Dashboard</p>';
}
?>

<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Logout link
echo '<p><a href="logout.php">Logout</a></p>';

// Read users from file
$users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create new role
    if (isset($_POST['create_role'])) {
        $username = $_POST['username'];
        $newRole = $_POST['new_role'];

        foreach ($users as &$user) {
            list($storedUsername, $email, $password, $role) = explode('|', $user);

            if ($username === $storedUsername) {
                $user = "$storedUsername|$email|$password|$newRole";
                break;
            }
        }

        // Save updated users to file
        file_put_contents('users.txt', implode("\n", $users));
    }

    // Edit existing role
    if (isset($_POST['edit_role'])) {
        $editUsername = $_POST['edit_username'];
        $editedRole = $_POST['edited_role'];

        foreach ($users as &$user) {
            list($storedUsername, $email, $password, $role) = explode('|', $user);

            if ($editUsername === $storedUsername) {
                $user = "$storedUsername|$email|$password|$editedRole";
                break;
            }
        }

        // Save updated users to file
        file_put_contents('users.txt', implode("\n", $users));
    }

    // Delete role
    if (isset($_POST['delete_role'])) {
        $deleteUsername = $_POST['delete_username'];

        // Remove user from the array
        $users = array_filter($users, function($user) use ($deleteUsername) {
            return explode('|', $user)[0] !== $deleteUsername;
        });

        // Save updated users to file
        file_put_contents('users.txt', implode("\n", $users));
    }
}



// Read users from file
$users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Display user data in a table
echo '<table border="1">';
echo '<tr><th>Username</th><th>Email</th><th>Role</th></tr>';
foreach ($users as $user) {
    list($username, $email, $password, $role) = explode('|', $user);
    echo "<tr><td>$username</td><td>$email</td><td>$role</td></tr>";
}
echo '</table>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Role Management</title>
</head>
<body>
    <h2>Role Management</h2>

    <!-- Create Role Form -->
    <form action="" method="post">
        <h3>Create Role</h3>
        Username: <input type="text" name="username" required>
        New Role: <input type="text" name="new_role" required>
        <input type="submit" name="create_role" value="Create Role">
    </form>

    <!-- Edit Role Form -->
    <form action="" method="post">
        <h3>Edit Role</h3>
        Username: <input type="text" name="edit_username" required>
        Edited Role: <input type="text" name="edited_role" required>
        <input type="submit" name="edit_role" value="Edit Role">
    </form>

    <!-- Delete Role Form -->
    <form action="" method="post">
        <h3>Delete Role</h3>
        Username: <input type="text" name="delete_username" required>
        <input type="submit" name="delete_role" value="Delete Role">
    </form>
</body>
</html>

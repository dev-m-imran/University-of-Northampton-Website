<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require '../database.php';

// Checking if the user is superadmin
$isSuperadmin = isset($_SESSION['is_superadmin']) && $_SESSION['is_superadmin'] === 1;
?>
<!doctype html>
<html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="../uon.css" />
    </head>
    <body>
        <?php include '../navigation.php'; ?>
        <main>
            <h1>Admin Dashboard</h1>
            <ul>
                <?php if ($isSuperadmin): ?>
                    <li><a href="/admin/users.php">Manage Users</a></li>
                <?php endif; ?>
                <li><a href="/admin/subjects.php">Manage Subject Areas</a></li>
                <li><a href="/admin/courses.php">Manage Courses</a></li>
                <li><a href="/admin/modules.php">Manage Modules</a></li>
                <li><a href="/admin/enquiries.php">Manage Enquiries</a></li>
            </ul>
        </main>
    </body>
</html>
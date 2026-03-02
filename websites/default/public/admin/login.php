<?php
session_start();
require '../database.php';

// Handling login of the user
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    // in case of matching user name and password
    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_superadmin'] = (int) $user['is_superadmin'];

        header('Location: dashboard.php');
        

        exit;
    }
    
    $error = 'Invalid username or password.';
}
?>
<?php
$pageTitle = 'Admin Login';
require '../partials/header.php';
require '../navigation.php';
?>
<section></section>
<main>
    <?php if ($error): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required />
        <label>Password</label>
        <input type="password" name="password" required />
        <input type="submit" value="Login" />
    </form>
</main>
<?php
require '../partials/aside.php';
require '../partials/footer.php';
?>
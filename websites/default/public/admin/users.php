<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require '../database.php';

// for superadmin to access the page
$isSuperadmin = isset($_SESSION['is_superadmin']) && $_SESSION['is_superadmin'] === 1;
if (!$isSuperadmin) {
    header('Location: dashboard.php');
    exit;
}

$error = null;
$formUsername = '';
$formIsSuperadmin = false;
$formEditId = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('SELECT is_superadmin FROM users WHERE user_id = ?');
        $stmt->execute([$_POST['user_id']]);
        $isSuperadmin = (int) $stmt->fetchColumn();
        if ($isSuperadmin !== 1) {
            $stmt = $pdo->prepare('DELETE FROM users WHERE user_id = ?');
            $stmt->execute([$_POST['user_id']]);
        }
    } else {
        $formUsername = trim($_POST['username']);
        $formIsSuperadmin = isset($_POST['is_superadmin']);
        $formEditId = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if ($formEditId) {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? AND user_id <> ?');
            $stmt->execute([$formUsername, $formEditId]);
            $usernameTaken = (int) $stmt->fetchColumn() > 0;
            if ($usernameTaken) {
                $error = 'That username already exists. Please choose another.';
            } else {
                $stmt = $pdo->prepare('UPDATE users SET username = ?, password_hash = ? WHERE user_id = ?');
                $stmt->execute([$formUsername, $hash, $formEditId]);
            }
        } else {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
            $stmt->execute([$formUsername]);
            $usernameTaken = (int) $stmt->fetchColumn() > 0;
            if ($usernameTaken) {
                $error = 'That username already exists. Please choose another.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, is_superadmin) VALUES (?, ?, ?)');
                $stmt->execute([$formUsername, $hash, $formIsSuperadmin ? 1 : 0]);
            }
        }
    }
    if (!$error) {
    header('Location: users.php');
    exit;
    }
}

$editId = $formEditId ?? (isset($_GET['edit']) ? $_GET['edit'] : null);
if ($editId) {
    if ($formEditId) {
        $editUser = [
            'username' => $formUsername,
            'is_superadmin' => $formIsSuperadmin ? 1 : 0,
        ];
    } else {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$editId]);
    $editUser = $stmt->fetch();
    }
}

$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll();
?>
<!doctype html>
<html>
    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="../uon.css" />
    </head>
    <body>
        <?php include '../navigation.php'; ?>
        <main>
            <h1>Manage Users</h1>
            <?php if ($error): ?>
                <p style="color:#b00020;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post">
                <?php if ($editId): ?>
                    <input type="hidden" name="user_id" value="<?php echo $editId; ?>" />
                <?php endif; ?>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($editId ? $editUser['username'] : $formUsername); ?>" required />
                <label>Password</label>
                <input type="password" name="password" required />
                <label>Superadmin</label>
                <input type="checkbox" name="is_superadmin" <?php echo ($editId ? $editUser['is_superadmin'] : $formIsSuperadmin) ? 'checked' : ''; ?> />
                <input type="submit" value="Save" />
            </form>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li>
                        <?php echo htmlspecialchars($user['username']); ?> (<?php echo $user['is_superadmin'] ? 'Superadmin' : 'Normal'; ?>)
                        <a href="?edit=<?php echo $user['user_id']; ?>">Edit</a>
                        <?php if (!$user['is_superadmin']): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>" />
                                <input type="hidden" name="delete" value="1" />
                                <input type="submit" value="Delete" />
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
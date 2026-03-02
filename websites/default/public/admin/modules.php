<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require '../database.php';

// Deleting module
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('DELETE FROM modules WHERE module_id = ?');
        $stmt->execute([$_POST['module_id']]);
    } else {
        // Updating existing module
        if (isset($_POST['module_id'])) {
            $stmt = $pdo->prepare('UPDATE modules SET module_code = ?, title = ?, description = ? WHERE module_id = ?');
            $stmt->execute([$_POST['module_code'], $_POST['title'], $_POST['description'], $_POST['module_id']]);
            // Inserting new module
        } else {
            $stmt = $pdo->prepare('INSERT INTO modules (module_code, title, description) VALUES (?, ?, ?)');
            $stmt->execute([$_POST['module_code'], $_POST['title'], $_POST['description']]);
        }
    }
    header('Location: modules.php');
    exit;
}

$editId = isset($_GET['edit']) ? $_GET['edit'] : null;
// Loading module data for editing
if ($editId) {
    $stmt = $pdo->prepare('SELECT * FROM modules WHERE module_id = ?');
    $stmt->execute([$editId]);
    $editModule = $stmt->fetch();
}

$stmt = $pdo->query('SELECT * FROM modules ORDER BY module_code');
$modules = $stmt->fetchAll();
?>
<!doctype html>
<html>
    <head>
        <title>Manage Modules</title>
        <link rel="stylesheet" href="../uon.css" />
    </head>
    <body>
        <?php include '../navigation.php'; ?>
        <main>
            <h1>Manage Modules</h1>
            <form method="post">
                <?php if ($editId): ?>
                    <input type="hidden" name="module_id" value="<?php echo $editId; ?>" />
                <?php endif; ?>
                <label>Module Code</label>
                <input type="text" name="module_code" value="<?php echo $editId ? htmlspecialchars($editModule['module_code']) : ''; ?>" required />
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $editId ? htmlspecialchars($editModule['title']) : ''; ?>" required />
                <label>Description</label>
                <textarea name="description" required><?php echo $editId ? htmlspecialchars($editModule['description']) : ''; ?></textarea>
                <input type="submit" value="Save" />
            </form>
            <ul>
                <?php foreach ($modules as $module): ?>
                    <li>
                        <?php echo htmlspecialchars($module['module_code'] . ' - ' . $module['title']); ?>
                        <a href="?edit=<?php echo $module['module_id']; ?>">Edit</a>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>" />
                            <input type="hidden" name="delete" value="1" />
                            <input type="submit" value="Delete" />
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
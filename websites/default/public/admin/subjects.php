<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require '../database.php';

$error = null;
// deleting subject area in case no course is attached to it
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM courses WHERE subject_area_id = ?');
        $stmt->execute([$_POST['subject_area_id']]);
        $hasCourses = (int) $stmt->fetchColumn() > 0;
        if ($hasCourses) {
            $error = 'Cannot delete this subject area because courses are linked to it.';
        } else {
            $stmt = $pdo->prepare('DELETE FROM subject_areas WHERE subject_area_id = ?');
            $stmt->execute([$_POST['subject_area_id']]);
        }
    } else {
        // Update existing subject area
        if (isset($_POST['subject_area_id'])) {
            $stmt = $pdo->prepare('UPDATE subject_areas SET name = ? WHERE subject_area_id = ?');
            $stmt->execute([$_POST['name'], $_POST['subject_area_id']]);
            // Inserting new subject area
        } else {
            $stmt = $pdo->prepare('INSERT INTO subject_areas (name) VALUES (?)');
            $stmt->execute([$_POST['name']]);
        }
    }
    if (!$error) {
        header('Location: subjects.php');
        exit;
    }
}

$editId = isset($_GET['edit']) ? $_GET['edit'] : null;
if ($editId) {
    $stmt = $pdo->prepare('SELECT * FROM subject_areas WHERE subject_area_id = ?');
    $stmt->execute([$editId]);
    $editSubject = $stmt->fetch();
}

$stmt = $pdo->query('SELECT * FROM subject_areas ORDER BY name');
$subjects = $stmt->fetchAll();
?>
<!doctype html>
<html>
    <head>
        <title>Manage Subject Areas</title>
        <link rel="stylesheet" href="../uon.css" />
    </head>
    <body>
        <?php include '../navigation.php'; ?>
        <main>
            <h1>Manage Subject Areas</h1>
            <?php if ($error): ?>
                <p style="color:#b00020;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post">
                <?php if ($editId): ?>
                    <input type="hidden" name="subject_area_id" value="<?php echo $editId; ?>" />
                <?php endif; ?>
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $editId ? htmlspecialchars($editSubject['name']) : ''; ?>" required />
                <input type="submit" value="Save" />
            </form>
            <ul>
                <?php foreach ($subjects as $subject): ?>
                    <li>
                        <?php echo htmlspecialchars($subject['name']); ?>
                        <a href="?edit=<?php echo $subject['subject_area_id']; ?>">Edit</a>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="subject_area_id" value="<?php echo $subject['subject_area_id']; ?>" />
                            <input type="hidden" name="delete" value="1" />
                            <input type="submit" value="Delete" />
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
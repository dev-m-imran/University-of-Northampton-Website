<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Deleting courses using sql query
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('DELETE FROM courses WHERE course_id = ?');
        $stmt->execute([$_POST['course_id']]);
    } else {
        $duration = $_POST['duration_years'] * 12;
        $part_time = isset($_POST['part_time']) ? 1 : 0;
        // Updating existing courses
        if (isset($_POST['course_id'])) {
            $stmt = $pdo->prepare('UPDATE courses SET subject_area_id = ?, title = ?, duration_months = ?, course_type = ?, description = ?, part_time = ? WHERE course_id = ?');
            $stmt->execute([$_POST['subject_area_id'], $_POST['title'], $duration, $_POST['course_type'], $_POST['description'], $part_time, $_POST['course_id']]);
            $courseId = $_POST['course_id'];
            // Inserting new courses
        } else {
            $stmt = $pdo->prepare('INSERT INTO courses (subject_area_id, title, duration_months, course_type, description, part_time) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$_POST['subject_area_id'], $_POST['title'], $duration, $_POST['course_type'], $_POST['description'], $part_time]);
            $courseId = $pdo->lastInsertId();
        }
        $stmt = $pdo->prepare('DELETE FROM course_modules WHERE course_id = ?');
        $stmt->execute([$courseId]);
        // Adding selected module
        if (isset($_POST['modules'])) {
            foreach ($_POST['modules'] as $moduleId) {
                $stmt = $pdo->prepare('INSERT INTO course_modules (course_id, module_id) VALUES (?, ?)');
                $stmt->execute([$courseId, $moduleId]);
            }
        }
    }
    header('Location: courses.php');
    exit;
}

$editId = isset($_GET['edit']) ? $_GET['edit'] : null;
$editModules = [];

if ($editId) {
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE course_id = ?');
    $stmt->execute([$editId]);
    $editCourse = $stmt->fetch();
    $editCourse['duration_years'] = $editCourse['duration_months'] / 12;

    $stmt = $pdo->prepare('SELECT module_id FROM course_modules WHERE course_id = ?');
    $stmt->execute([$editId]);
    $editModules = array_column($stmt->fetchAll(), 'module_id');
}

$stmt = $pdo->query('SELECT * FROM courses ORDER BY title');
$courses = $stmt->fetchAll();

$subjects = $pdo->query('SELECT * FROM subject_areas ORDER BY name')->fetchAll();
$modules = $pdo->query('SELECT * FROM modules ORDER BY module_code')->fetchAll();
?>
<!doctype html>
<html>
    <head>
        <title>Manage Courses</title>
        <link rel="stylesheet" href="../uon.css" />
    </head>
    <body>
        <?php include '../navigation.php'; ?>
        <main>
            <h1>Manage Courses</h1>
            <form method="post">
                <?php if ($editId): ?>
                    <input type="hidden" name="course_id" value="<?php echo $editId; ?>" />
                <?php endif; ?>
                <label>Subject Area</label>
                <select name="subject_area_id" required>
                    <?php foreach ($subjects as $sub): ?>
                        <option value="<?php echo $sub['subject_area_id']; ?>" <?php echo $editId && $editCourse['subject_area_id'] == $sub['subject_area_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($sub['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $editId ? htmlspecialchars($editCourse['title']) : ''; ?>" required />
                <label>Duration (years)</label>
                <input type="number" name="duration_years" value="<?php echo $editId ? $editCourse['duration_years'] : ''; ?>" required />
                <label>Type</label>
                <input type="text" name="course_type" value="<?php echo $editId ? htmlspecialchars($editCourse['course_type']) : ''; ?>" required />
                <label>Description</label>
                <textarea name="description" required><?php echo $editId ? htmlspecialchars($editCourse['description']) : ''; ?></textarea>
                <label>Part Time</label>
                <input type="checkbox" name="part_time" <?php echo $editId && $editCourse['part_time'] ? 'checked' : ''; ?> />
                <label>Modules</label>
                <select name="modules[]" multiple>
                    <?php foreach ($modules as $mod): ?>
                        <option value="<?php echo $mod['module_id']; ?>" <?php echo in_array($mod['module_id'], $editModules) ? 'selected' : ''; ?>><?php echo htmlspecialchars($mod['module_code'] . ' - ' . $mod['title']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Save" />
            </form>
            <ul>
                <?php foreach ($courses as $course): ?>
                    <li>
                        <?php echo htmlspecialchars($course['title']); ?>
                        <a href="?edit=<?php echo $course['course_id']; ?>">Edit</a>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>" />
                            <input type="hidden" name="delete" value="1" />
                            <input type="submit" value="Delete" />
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
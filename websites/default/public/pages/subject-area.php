<?php
$id = $_GET['id'];
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
if ($page < 1) {
    $page = 1;
}
$perPage = 10;
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare('SELECT name FROM subject_areas WHERE subject_area_id = ?');
$stmt->execute([$id]);
$subject = $stmt->fetch()['name'];

$limit = (int) $perPage;
$start = (int) $offset;
$stmt = $pdo->prepare("SELECT * FROM courses WHERE subject_area_id = ? LIMIT $limit OFFSET $start");
$stmt->execute([$id]);
$courses = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM courses WHERE subject_area_id = ?');
$stmt->execute([$id]);
$total = $stmt->fetchColumn();
$pages = ceil($total / $perPage);
?>
<main>
    <h1><?php echo htmlspecialchars($subject); ?></h1>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <h2><?php echo htmlspecialchars($course['title']); ?></h2>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($course['course_type']); ?></p>
                <p><strong>Duration:</strong> <?php echo $course['duration_months'] / 12; ?> years</p>
                <p><strong>Can be completed part time?</strong> <?php echo $course['part_time'] ? 'Yes' : 'No'; ?></p>
                <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                <h3>Modules</h3>
                <ul>
                    <?php
                    $stmt = $pdo->prepare('SELECT m.* FROM modules m JOIN course_modules cm ON m.module_id = cm.module_id WHERE cm.course_id = ?');
                    $stmt->execute([$course['course_id']]);
                    foreach ($stmt->fetchAll() as $module) {
                        echo '<li><h4>' . htmlspecialchars($module['module_code'] . ' - ' . $module['title']) . '</h4><p>' . nl2br(htmlspecialchars($module['description'])) . '</p></li>';
                    }
                    ?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
    <div>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="/index.php?page=subject-area&id=<?php echo $id; ?>&page_num=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</main>
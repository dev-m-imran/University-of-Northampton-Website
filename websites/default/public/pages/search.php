<?php
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
if ($page < 1) {
    $page = 1;
}
$perPage = 10;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];
if (isset($_GET['subject_area_id']) && $_GET['subject_area_id']) {
    $where[] = 'subject_area_id = ?';
    $params[] = $_GET['subject_area_id'];
}
if (isset($_GET['course_type']) && $_GET['course_type']) {
    $where[] = 'course_type = ?';
    $params[] = $_GET['course_type'];
}
if (isset($_GET['min_duration']) && $_GET['min_duration']) {
    $where[] = 'duration_months / 12 >= ?';
    $params[] = $_GET['min_duration'];
}
if (isset($_GET['max_duration']) && $_GET['max_duration']) {
    $where[] = 'duration_months / 12 <= ?';
    $params[] = $_GET['max_duration'];
}
if (isset($_GET['part_time']) && $_GET['part_time'] == '1') {
    $where[] = 'part_time = 1';
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$limit = (int) $perPage;
$start = (int) $offset;
$stmt = $pdo->prepare("SELECT * FROM courses $whereSql LIMIT $limit OFFSET $start");
$stmt->execute($params);
$courses = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM courses $whereSql");
$stmt->execute($params);
$total = $stmt->fetchColumn();
$pages = ceil($total / $perPage);
?>
<main>
    <h1>Search Courses</h1>
    <form method="get">
        <input type="hidden" name="page" value="search" />
        <label>Subject Area</label>
        <select name="subject_area_id">
            <option value="">Any</option>
            <?php
            $stmt = $pdo->query('SELECT * FROM subject_areas ORDER BY name');
            while ($row = $stmt->fetch()) {
                echo '<option value="' . $row['subject_area_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
            }
            ?>
        </select>
        <label>Type</label>
        <input type="text" name="course_type" />
        <label>Min Duration (years)</label>
        <input type="number" name="min_duration" />
        <label>Max Duration (years)</label>
        <input type="number" name="max_duration" />
        <label>Part Time</label>
        <input type="checkbox" name="part_time" value="1" />
        <input type="submit" value="Search" />
    </form>
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
        <?php
        $query = $_GET;
        $query['page'] = 'search';
        for ($i = 1; $i <= $pages; $i++):
            $query['page_num'] = $i;
        ?>
            <a href="/index.php?<?php echo http_build_query($query); ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</main>
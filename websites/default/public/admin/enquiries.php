<?php
//  Admin can manage enquiries like to view & mark enquiries as responded
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require '../database.php';

// this is for marking enquiry as responded
if (isset($_GET['respond'])) {
    $stmt = $pdo->prepare('UPDATE enquiries SET responded_at = NOW(), responded_by_user_id = ? WHERE enquiry_id = ?');
    $stmt->execute([$_SESSION['user_id'], $_GET['respond']]);
    header('Location: enquiries.php');
    exit;
}

// this is for showing pending and responsed enquiries, if responded and by who
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'pending';
$where = $tab == 'pending' ? 'responded_at IS NULL' : 'responded_at IS NOT NULL';

$stmt = $pdo->prepare("SELECT e.*, u.username FROM enquiries e LEFT JOIN users u ON e.responded_by_user_id = u.user_id WHERE $where ORDER BY created_at DESC");
$stmt->execute();
$enquiries = $stmt->fetchAll();
?>
<!doctype html>
<html>
    <head>
        <title>Manage Enquiries</title>
        <link rel="stylesheet" href="../uon.css" />
    </head>
    <body>
        <?php include '../navigation.php'; ?>
        <main>
            <h1>Manage Enquiries</h1>
            <a href="?tab=pending">Pending</a> | <a href="?tab=responded">Responded</a>
            <ul>
                <?php foreach ($enquiries as $enq): ?>
                    <li>
                        <p>Name: <?php echo htmlspecialchars($enq['name']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($enq['email']); ?></p>
                        <p>Phone: <?php echo htmlspecialchars($enq['phone']); ?></p>
                        <p>Course ID: <?php echo $enq['course_id']; ?></p>
                        <p>Message: <?php echo nl2br(htmlspecialchars($enq['message'])); ?></p>
                        <p>Created: <?php echo $enq['created_at']; ?></p>
                        <?php if ($enq['responded_at']): ?>
                            <p>Responded: <?php echo $enq['responded_at']; ?> by <?php echo htmlspecialchars($enq['username']); ?></p>
                        <?php else: ?>
                            <a href="?respond=<?php echo $enq['enquiry_id']; ?>">Mark as Responded</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </body>
</html>
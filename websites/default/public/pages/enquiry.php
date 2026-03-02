<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare('INSERT INTO enquiries (name, email, phone, course_id, message) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['course_id'], $_POST['message']]);
    header('Location: /index.php?page=enquiry&success=1');
    exit;
}
?>
<main>
    <h1>Make an enquiry</h1>
    <?php if (isset($_GET['success'])) echo '<p>Enquiry submitted!</p>'; ?>
    <form method="post">
        <label>Your name</label>
        <input type="text" name="name" required />
        <label>Email address</label>
        <input type="email" name="email" required />
        <label>Phone number</label>
        <input type="text" name="phone" />
        <label>Which course are you enquiring about?</label>
        <select name="course_id">
            <?php
            $stmt = $pdo->query('SELECT course_id, title FROM courses ORDER BY title');
            while ($row = $stmt->fetch()) {
                echo '<option value="' . $row['course_id'] . '">' . htmlspecialchars($row['title']) . '</option>';
            }
            ?>
        </select>
        <label>What do you want to ask?</label>
        <textarea name="message" required></textarea>
        <input type="submit" />
    </form>
</main>
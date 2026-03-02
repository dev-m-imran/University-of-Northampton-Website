<header>
    <img src="/logo.jpg" alt="logo" />
    <ul>
        <li><a href="/index.php">Home</a></li>
        <li>Subject Areas
            <ul>
                <?php

                $stmt = $pdo->query('SELECT * FROM subject_areas ORDER BY name');
                while ($row = $stmt->fetch()) {
                    echo '<li><a href="/index.php?page=subject-area&id=' . $row['subject_area_id'] . '">' . htmlspecialchars($row['name']) . '</a></li>';
                }
                ?>
            </ul>
        </li>
        <li><a href="/index.php?page=enquiry">Make an enquiry</a></li>
        <li><a href="/index.php?page=search">Search</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="/admin/dashboard.php">Admin</a></li>
            <li><a href="/admin/logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="/admin/login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</header>
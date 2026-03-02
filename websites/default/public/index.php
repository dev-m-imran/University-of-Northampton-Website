<?php
session_start();
ob_start();
require 'database.php';

$routes = [
    'home' => 'home.php',
    'subject-area' => 'subject-area.php',
    'search' => 'search.php',
    'enquiry' => 'enquiry.php',
];

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
if (!isset($routes[$page])) {
    $page = 'home';
}

$pageTitle = 'University of Northampton';
if ($page === 'search') {
    $pageTitle = 'University of Northampton - Search';
} elseif ($page === 'enquiry') {
    $pageTitle = 'University of Northampton';
}

require 'partials/header.php';
require 'navigation.php';
?>
<section></section>
<?php
require 'pages/' . $routes[$page];
require 'partials/aside.php';
require 'partials/footer.php';
ob_end_flush();
?>

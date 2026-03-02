<?php
$isAdminPath = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false);
$cssPath = $isAdminPath ? '../uon.css' : 'uon.css';
?>
<!doctype html>
<html>
    <head>
        <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'University of Northampton'; ?></title>
        <link rel="stylesheet" href="<?php echo $cssPath; ?>" />
    </head>
    <body>
<?php
$server = 'mysql';
$username = 'student';
$password = 'student';
// The name of the schema we created earlier in MySQL workbench
$schema = 'uon';
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
?>
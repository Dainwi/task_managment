<?php
define('BASE_URL', 'http://localhost/todo');
define('APP_NAME', 'Task Managment');

$host = 'localhost';
$dbname = 'task_managment';
$username = 'root';
$password = '';

try {
    $conn = mysqli_connect($host, $username, $password, $dbname);
} catch (\Throwable $th) {
    throw $th;
}
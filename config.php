<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "support_db";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}
?>
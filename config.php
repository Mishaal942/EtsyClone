<?php
$host = "localhost";
$user = "unzfutgwrtkyb";
$password = "zxqqgfz2ugxg";
$dbname = "dbcwvv3be0miqt";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}
?>

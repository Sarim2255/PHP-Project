<?php
// db.php - DB connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "cartify_store";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>

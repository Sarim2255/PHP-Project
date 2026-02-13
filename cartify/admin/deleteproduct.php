<?php
session_start();
include "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: displayproduct.php");
    exit;
}

$id = intval($_GET['id']);

// fetch image path before delete
$imgQ = mysqli_query($conn, "SELECT image FROM products WHERE id = $id LIMIT 1");
if ($imgQ && mysqli_num_rows($imgQ) > 0) {
    $img = mysqli_fetch_assoc($imgQ)['image'];

    // delete image file if exists
    $path = "../prod_img/" . $img;
    if (!empty($img) && file_exists($path)) {
        unlink($path);
    }
}

// delete product
mysqli_query($conn, "DELETE FROM products WHERE id = $id");

header("Location: displayproduct.php?msg=deleted");
exit;

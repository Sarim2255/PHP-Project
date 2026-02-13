<?php
session_start();
include "db.php";
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status'=>0,'msg'=>'Not logged in']); exit;
}

$uid = intval($_SESSION['user_id']);
$action = $_POST['action'] ?? ($_GET['action'] ?? '');
$pid = intval($_POST['product_id'] ?? ($_GET['id'] ?? 0));

if ($action === 'add' || isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    // support both AJAX add (POST) and direct link (GET)
    $check = mysqli_query($conn, "SELECT id FROM wishlist WHERE user_id=$uid AND product_id=$pid");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO wishlist (user_id, product_id) VALUES ($uid, $pid)");
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') echo json_encode(['status'=>1,'msg'=>'Added']); else header("Location: wishlist.php");
    exit;
}

if ($action === 'remove' || (isset($_GET['remove']) && $_SERVER['REQUEST_METHOD'] === 'GET')) {
    mysqli_query($conn, "DELETE FROM wishlist WHERE user_id=$uid AND product_id=$pid");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') echo json_encode(['status'=>1,'msg'=>'Removed']); else header("Location: wishlist.php");
    exit;
}

echo json_encode(['status'=>0,'msg'=>'Invalid action']);

<?php
session_start();
include "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $order_id = intval($_POST['order_id'] ?? 0);
    $status   = mysqli_real_escape_string($conn, $_POST['status'] ?? '');

    // allowed statuses
    $allowed = ["Pending","Processing","Shipped","Out for Delivery","Delivered","Cancelled"];

    if ($order_id > 0 && in_array($status, $allowed)) {

        mysqli_query(
            $conn,
            "UPDATE payments SET status='$status' WHERE order_id = $order_id"
        );

        header("Location: vieworders.php?msg=status_updated");
        exit;
    }

    header("Location: vieworders.php?msg=invalid");
    exit;
}

header("Location: vieworders.php");
exit;

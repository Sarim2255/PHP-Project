<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['cart'])) { header("Location: cart.php"); exit; }

$uid = intval($_SESSION['user_id']);
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? 'cod');

foreach ($_SESSION['cart'] as $pid => $qty) {
    $pid = intval($pid);
    $qty = max(1, intval($qty));
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$pid LIMIT 1");
    if (!$res || mysqli_num_rows($res) == 0) continue;
    $prod = mysqli_fetch_assoc($res);
    $line_total = $prod['price'] * $qty;

    // insert single_order
    mysqli_query($conn, "INSERT INTO single_order (user_id, product_id, total_amount, quantity) VALUES ('$uid', '$pid', '$line_total', '$qty')");
    $order_id = mysqli_insert_id($conn);

    // insert payment
    mysqli_query($conn, "INSERT INTO payments (order_id, user_id, total_amount, payment_method, status) VALUES ('$order_id', '$uid', '$line_total', '".mysqli_real_escape_string($conn,$payment_method)."', 'Pending')");

    // reduce stock
    mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id = $pid");
}

// clear cart
unset($_SESSION['cart']);

// redirect to my orders
header("Location: myorders.php?msg=placed");
exit;

<?php
session_start();
include "db.php";
if (empty($_SESSION['cart'])) { header("Location: cart.php"); exit; }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$uid = intval($_SESSION['user_id']);
$order_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($order_id) {
  $q = mysqli_query($conn, "SELECT payments.*, so.product_id, p.name AS product_name FROM payments LEFT JOIN single_order so ON payments.order_id = so.id LEFT JOIN products p ON so.product_id = p.id WHERE payments.order_id = $order_id LIMIT 1");
} else {
  $q = mysqli_query($conn, "SELECT payments.*, so.product_id, p.name AS product_name FROM payments LEFT JOIN single_order so ON payments.order_id = so.id LEFT JOIN products p ON so.product_id = p.id WHERE payments.user_id = $uid ORDER BY payments.created_at DESC LIMIT 1");
}

if (!$q || mysqli_num_rows($q) == 0) {
  include "header.php"; echo "<div class='container'><div class='card'>No order found.</div></div>"; include "footer.php"; exit;
}
$o = mysqli_fetch_assoc($q);
include "header.php";
?>
<div class="container">
  <h2>Order Confirmation</h2>
  <div class="card">
    <p><strong>Order ID:</strong> <?= htmlspecialchars($o['order_id']) ?></p>
    <p><strong>Product:</strong> <?= htmlspecialchars($o['product_name'] ?? '—') ?></p>
    <p><strong>Amount:</strong> ₹<?= number_format($o['total_amount'],2) ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($o['payment_method']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($o['status'] ?? 'Pending') ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($o['created_at']) ?></p>
    <div style="margin-top:12px;">
      <a class="btn" href="index.php">Continue Shopping</a>
      <a class="btn" href="myorders.php">View All Orders</a>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>

<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$uid = intval($_SESSION['user_id']);

$res = mysqli_query($conn, "
  SELECT payments.*, so.product_id, p.name AS product_name
  FROM payments
  LEFT JOIN single_order so ON payments.order_id = so.id
  LEFT JOIN products p ON so.product_id = p.id
  WHERE payments.user_id = $uid
  ORDER BY payments.created_at DESC
");

include "header.php";
?>
<div class="container">
  <h2>My Orders</h2>
  <?php if(isset($_GET['msg']) && $_GET['msg'] == 'placed'): ?>
    <div style="background:#e6ffef;padding:10px;border-radius:8px;margin-bottom:12px;">Order placed successfully.</div>
  <?php endif; ?>

  <div class="card">
    <table class="table">
      <thead><tr><th>Order ID</th><th>Product</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($res)): ?>
          <tr>
            <td><?= htmlspecialchars($row['order_id']) ?></td>
            <td><?= htmlspecialchars($row['product_name'] ?? '—') ?></td>
            <td>₹<?= number_format($row['total_amount'],2) ?></td>
            <td><?= htmlspecialchars($row['payment_method']) ?></td>
            <td><?= htmlspecialchars($row['status'] ?? 'Pending') ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include "footer.php"; ?>

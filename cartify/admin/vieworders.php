<?php
session_start();
include "../db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== "admin") { header("Location:../index.php"); exit(); }

$sql = "SELECT p.*, u.name AS user_name, u.email AS user_email 
        FROM payments p 
        JOIN users u ON p.user_id = u.id 
        ORDER BY p.order_id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Orders</title>
<link rel="stylesheet" href="../assets/theme.css">
<style>
.admin-layout{ display:flex; min-height:100vh; }
.sidebar{ width:220px; background:linear-gradient(180deg,#0f172a,#06B6D4); color:#fff; padding:18px; position:fixed; height:100%; }
.sidebar a{ color:#e8f5ff; display:block; padding:8px 10px; margin-bottom:8px; border-radius:8px; text-decoration:none; }
.main{ margin-left:220px; padding:18px; }
.card{ padding:16px; background:#fff; border-radius:12px; border:1px solid #eef6ff; }
.table{ width:100%; border-collapse:collapse; }
.table th,.table td{ padding:10px; border-bottom:1px solid #ddd; }
.status-select{ padding:6px; border-radius:6px; border:1px solid #eef6ff; }
.update-btn{ padding:6px 10px; background:linear-gradient(90deg,#4F46E5,#06B6D4); color:#fff; border:none; border-radius:6px; cursor:pointer; }
</style>
</head>
<body>

<div class="admin-layout">

  <aside class="sidebar">
    <h2>Cartify Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="displayproduct.php">View Products</a>
    <a href="vieworders.php">View Orders</a>
    <a href="../logout.php">Logout</a>
  </aside>

  <main class="main">
    <h2>All Orders</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg']=="status_updated"): ?>
      <div style="background:#e6ffef;padding:8px;border-radius:8px;margin-bottom:10px;">Status updated</div>
    <?php endif; ?>

    <div class="card" style="margin-top:12px;">
      <div style="overflow-x:auto;">
        <table class="table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>User</th>
              <th>Email</th>
              <th>Amount</th>
              <th>Method</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>

          <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $row['order_id'] ?></td>
              <td><?= htmlspecialchars($row['user_name']) ?></td>
              <td><?= htmlspecialchars($row['user_email']) ?></td>
              <td>₹<?= number_format($row['total_amount'],2) ?></td>
              <td><?= ucfirst(htmlspecialchars($row['payment_method'])) ?></td>

              <td>
                <form method="post" action="update_order_status.php" style="display:flex;gap:8px;align-items:center;">
                  <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                  <select name="status" class="status-select">
                    <?php
                      $statuses = ["Pending","Processing","Shipped","Out for Delivery","Delivered","Cancelled"];
                      foreach($statuses as $s){
                          $sel = ($row['status']==$s) ? "selected" : "";
                          echo "<option value='$s' $sel>$s</option>";
                      }
                    ?>
                  </select>
                  <button class="update-btn" type="submit">Update</button>
                </form>
              </td>

            </tr>
          <?php endwhile; ?>

          </tbody>
        </table>
      </div>
    </div>

  </main>

</div>

</body>
</html>

<?php
session_start();
include "../db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') { header("Location: ../index.php"); exit; }

$sql = "SELECT * FROM products ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>View Products - Admin</title>
<link rel="stylesheet" href="../assets/theme.css">
<style>
.admin-layout{ display:flex; min-height:100vh; }
.sidebar{ width:220px; background:linear-gradient(180deg,#0f172a,#06B6D4); color:#fff; padding:18px; position:fixed; height:100%; }
.sidebar a{ color:#e8f5ff; display:block; padding:8px 10px; margin-bottom:8px; text-decoration:none; border-radius:8px; }
.main{ margin-left:220px; padding:18px; }
.card{ background:#fff; padding:18px; border-radius:12px; }
.table{ width:100%; border-collapse:collapse; }
.table-img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
}

.table th, .table td{ padding:10px; border-bottom:1px solid #ddd; }
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
    <h2>All Products</h2>

    <div class="card" style="margin-top:16px;">
      <div style="overflow-x:auto;">
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Image</th>
              <th>Category</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($res)): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td>₹<?= number_format($row['price'],2) ?></td>
              <td><?= intval($row['stock']) ?></td>
              <td><img src="../prod_img/<?= htmlspecialchars($row['image']) ?>" style="width:80px;height:60px;object-fit:cover;border-radius:6px;"></td>
              <td><?= htmlspecialchars($row['category_name']) ?></td>
              <td><a class="btn" href="updateproduct.php?id=<?= $row['id'] ?>">Update</a></td>
              <td>
                <a class="btn" href="deleteproduct.php?id=<?= $row['id'] ?>" 
                onclick="return confirm('Delete this product?')">Delete</a>
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

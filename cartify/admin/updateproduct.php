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
$prod = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id LIMIT 1"));
$cats = mysqli_query($conn, "SELECT * FROM categories");

if (!$prod) {
    header("Location: displayproduct.php");
    exit;
}

if (isset($_POST['update'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $cat   = mysqli_real_escape_string($conn, $_POST['category_name']);

    // image update
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../prod_img/" . $img);
    } else {
        $img = $prod['image'];
    }

    mysqli_query(
        $conn,
        "UPDATE products 
         SET name='$name', description='$desc', price='$price', stock='$stock',
             category_name='$cat', image='$img'
         WHERE id=$id"
    );

    header("Location: displayproduct.php?msg=updated");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Edit Product</title>
<link rel="stylesheet" href="../assets/theme.css">
<style>
.admin-layout{ display:flex; min-height:100vh; }
.sidebar{
  width:220px;background:linear-gradient(180deg,#0f172a,#06B6D4);
  color:#fff;padding:18px;position:fixed;height:100%;
}
.sidebar a{
  color:#e8f5ff;display:block;padding:8px 10px;margin-bottom:8px;
  text-decoration:none;border-radius:8px;
}
.main{ margin-left:220px; padding:20px; }
.card{ background:#fff;padding:20px;border-radius:12px;max-width:900px; }
.card input, .card select, .card textarea{
  width:100%;padding:10px;margin-top:6px;border:1px solid #ccc;border-radius:8px;
}
</style>
</head>
<body>

<div class="admin-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h2>Cartify Admin</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="displayproduct.php">View Products</a>
    <a href="vieworders.php">View Orders</a>
    <a href="../logout.php">Logout</a>
  </aside>

  <!-- MAIN -->
  <main class="main">
    <h2>Edit Product</h2>

    <div class="card">
      <form method="post" enctype="multipart/form-data">

        <label>Product Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($prod['name']) ?>" required>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= $prod['price'] ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?= $prod['stock'] ?>" required>

        <label>Category</label>
        <select name="category_name">
          <?php while($c = mysqli_fetch_assoc($cats)): ?>
            <option <?= ($c['name'] == $prod['category_name']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['name']) ?>
            </option>
          <?php endwhile; ?>
        </select>

        <label>Current Image</label><br>
        <img src="../prod_img/<?= htmlspecialchars($prod['image']) ?>"
             style="width:160px;height:120px;object-fit:cover;border-radius:8px;"><br>

        <label style="margin-top:10px;">Replace Image</label>
        <input type="file" name="image">

        <label>Description</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($prod['description']) ?></textarea>

        <button class="btn" name="update" type="submit" style="margin-top:12px;">Update Product</button>

      </form>
    </div>

  </main>

</div>

</body>
</html>

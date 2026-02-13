<?php
session_start();
include "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

$msg = '';
$cats = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = mysqli_real_escape_string($conn, $_POST['category_name']);

    $image = $_FILES['image']['name'] ?? '';

    if ($image !== "") {
        $tmp = $_FILES['image']['tmp_name'];
        $target = "../prod_img/" . basename($image);
        move_uploaded_file($tmp, $target);
    }

    $sql = "INSERT INTO products (name,description,price,stock,image,category_name)
            VALUES ('$name','$desc','$price','$stock','$image','$category')";

    $msg = mysqli_query($conn, $sql) ? "Product added successfully!" : "Error: ".$conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Add Product - Admin</title>
<link rel="stylesheet" href="../assets/theme.css">

<style>
/* Admin UI Consistency */
.admin-layout {
    display: flex;
    min-height: 100vh;
    background: #f4f6fb;
}

.sidebar {
    width: 220px;
    background: linear-gradient(180deg, #0f172a, #06B6D4);
    color: #fff;
    padding: 22px 16px;
    position: fixed;
    top:0;
    bottom:0;
    left:0;
    overflow-y:auto;
}

.sidebar h2 {
    margin: 0 0 14px;
    font-size: 20px;
    font-weight: 700;
}

.sidebar a {
    display: block;
    padding: 10px 12px;
    color: #e8f5ff;
    text-decoration: none;
    margin-bottom: 8px;
    border-radius: 8px;
    font-weight: 600;
}

.sidebar a:hover, .sidebar a.active {
    background: rgba(255,255,255,0.08);
    transform: translateX(4px);
}

/* Main Area */
.main {
    margin-left: 220px;
    padding: 24px;
}

.card {
    background: #fff;
    padding: 22px;
    border-radius: 14px;
    max-width: 750px;
    border: 1px solid #e7eef7;
    box-shadow: 0 6px 20px rgba(2,6,23,0.04);
}

.card label {
    font-weight: 600;
    color: #334155;
    margin-top: 12px;
    display: block;
}

.card input,
.card select,
.card textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #d0d7e2;
    margin-top: 6px;
    font-size: 14px;
    background: #f8fafc;
}

.card input:focus,
.card textarea:focus,
.card select:focus {
    border-color: #06B6D4;
    box-shadow: 0 0 0 2px rgba(6,182,212,0.25);
    outline: none;
}

/* Button */
.btn {
    margin-top: 18px;
    padding: 12px 18px;
    background: linear-gradient(90deg,#06B6D4,#4F46E5);
    border: none;
    border-radius: 10px;
    font-weight: 700;
    color: #fff;
    cursor: pointer;
}

.btn:hover {
    opacity: 0.92;
}

/* Responsive */
@media(max-width:800px){
    .sidebar {
        display: none;
    }
    .main {
        margin-left: 0;
        padding: 16px;
    }
}
</style>
</head>

<body>
<div class="admin-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Cartify Admin</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="addproduct.php" class="active">Add Product</a>
        <a href="displayproduct.php">View Products</a>
        <a href="vieworders.php">View Orders</a>
        <a href="../logout.php">Logout</a>
    </aside>

    <!-- Main -->
    <main class="main">
        
        <h2>Add Product</h2>

        <?php if ($msg): ?>
        <div style="background:#e6ffef;padding:12px;border-radius:8px;margin-bottom:16px;">
            <?= htmlspecialchars($msg) ?>
        </div>
        <?php endif; ?>

        <div class="card">
            <form method="post" enctype="multipart/form-data">

                <label>Product Name</label>
                <input type="text" name="name" required>

                <label>Price (₹)</label>
                <input type="number" step="0.01" name="price" required>

                <label>Stock</label>
                <input type="number" name="stock" required>

                <label>Category</label>
                <select name="category_name" required>
                    <?php while($c = mysqli_fetch_assoc($cats)): ?>
                        <option><?= htmlspecialchars($c['name']) ?></option>
                    <?php endwhile; ?>
                </select>

                <label>Product Image</label>
                <input type="file" name="image">

                <label>Description</label>
                <textarea name="description" rows="4"></textarea>

                <button name="submit" class="btn">Save Product</button>

            </form>
        </div>
    </main>
</div>
</body>
</html>

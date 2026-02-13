<?php
session_start();
include "db.php";

/* CATEGORY FILTER */
$filter_category = $_GET['category_name'] ?? '';

if ($filter_category !== '') {
    $fc = mysqli_real_escape_string($conn, $filter_category);
    $sql = "SELECT * FROM products WHERE category_name='$fc' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cartify | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/theme.css">
</head>
<body>

<?php include "header.php"; ?>

<div class="container">

    <!-- PAGE TITLE -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
        <?php if ($filter_category): ?>
            <h2 style="font-weight:800;">
                Category: <?= htmlspecialchars($filter_category) ?>
            </h2>
            <a href="index.php" class="btn">Clear Filter</a>
        <?php else: ?>
            <h2 style="font-weight:800;">Latest Products</h2>
        <?php endif; ?>
    </div>

    <!-- PRODUCT GRID -->
    <div class="product-grid">

        <?php while($row = mysqli_fetch_assoc($result)): ?>

            <div class="product-card">

                <!-- IMAGE -->
                <img
                    src="prod_img/<?= htmlspecialchars($row['image']) ?>"
                    alt="<?= htmlspecialchars($row['name']) ?>"
                    loading="lazy"
                >

                <!-- INFO -->
                <div class="product-info">

                    <div class="product-title">
                        <?= htmlspecialchars($row['name']) ?>
                    </div>

                    <div class="product-category">
                        <?= htmlspecialchars($row['category_name']) ?>
                    </div>

                    <div class="product-price">
                        ₹<?= number_format($row['price'], 2) ?>
                    </div>

                    <!-- ACTIONS -->
                    <div class="card-bottom">

                        <!-- ADD TO CART -->
                        <form method="post" action="cart.php" style="margin:0;">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="product_id" value="<?= (int)$row['id'] ?>">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn-small">
                                Add to Cart
                            </button>
                        </form>

                        <!-- VIEW -->
                        <a href="product.php?id=<?= (int)$row['id'] ?>" class="btn-small">
                            View
                        </a>

                        <!-- WISHLIST -->
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="wishlist_action.php?id=<?= (int)$row['id'] ?>" class="wishlist-btn" title="Add to wishlist">
                                ♥
                            </a>
                        <?php else: ?>
                            <button class="wishlist-btn" title="Login required" onclick="alert('Please login to use wishlist')">
                                ♥
                            </button>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include "footer.php"; ?>

</body>
</html>

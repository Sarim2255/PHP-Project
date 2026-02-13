<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once "db.php";

/* Fetch categories */
$cats = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");

/* Cart count */
$cart_count = 0;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $q) {
        $cart_count += (int)$q;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cartify</title>
<link rel="stylesheet" href="assets/theme.css?v=5">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="amazon-header">

    <!-- LOGO -->
    <div class="header-logo">
        <a href="index.php">Cartify</a>
    </div>

    <!-- SEARCH BAR -->
    <form class="header-search" method="get" action="index.php">
        <input 
            type="text" 
            name="search" 
            placeholder="Search for products, brands and more"
            autocomplete="off"
        >
        <button type="submit" aria-label="Search">
            🔍
        </button>
    </form>

    <!-- RIGHT MENU -->
    <div class="header-right">
        <?php if (isset($_SESSION['user_id'])): ?>

            <a href="dashboard.php" class="header-link">
                Hello, <?= htmlspecialchars($_SESSION['user_name']) ?>
            </a>

            <a href="wishlist.php" class="header-link">
                ❤️ Wishlist
            </a>

            <a href="cart.php" class="header-cart">
                🛒 Cart
                <span class="cart-count"><?= $cart_count ?></span>
            </a>

            <a href="logout.php" class="header-link">
                Logout
            </a>

        <?php else: ?>

            <a href="login.php" class="header-link">
                Login
            </a>

            <a href="register.php" class="header-signup">
                Sign Up
            </a>

        <?php endif; ?>
    </div>

</header>

<!-- ================= CATEGORY STRIP ================= -->
<nav class="category-strip">
    <a href="index.php" class="cat-link">All</a>

    <?php while ($c = mysqli_fetch_assoc($cats)): ?>
        <a 
            href="index.php?category_name=<?= urlencode($c['name']) ?>" 
            class="cat-link"
        >
            <?= htmlspecialchars($c['name']) ?>
        </a>
    <?php endwhile; ?>
</nav>

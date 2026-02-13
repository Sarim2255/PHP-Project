<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$uid = intval($_SESSION['user_id']);

if (isset($_GET['remove'])) {
    $rid = intval($_GET['remove']);
    mysqli_query($conn, "DELETE FROM wishlist WHERE user_id=$uid AND product_id=$rid");
    header("Location: wishlist.php"); exit;
}

$q = mysqli_query($conn, "SELECT w.*, p.* FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = $uid ORDER BY w.created_at DESC");
include "header.php";
?>
<div class="container">
  <h2>My Wishlist</h2>
  <?php if (mysqli_num_rows($q) == 0): ?>
    <div class="card">Your wishlist is empty.</div>
  <?php else: ?>
    <div class="grid grid-4">
      <?php while($p = mysqli_fetch_assoc($q)): ?>
        <div class="product-card card">
          <img src="prod_img/<?= htmlspecialchars($p['image']) ?>" alt="">
          <div class="product-meta">
            <div class="product-title"><?= htmlspecialchars($p['name']) ?></div>
            <div class="product-price">₹<?= number_format($p['price'],2) ?></div>
            <div style="margin-top:10px;display:flex;gap:8px;">
              <form method="post" action="cart.php" style="margin:0;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="qty" value="1">
                <button class="btn" type="submit">Add to Cart</button>
              </form>
              <a class="btn" href="wishlist.php?remove=<?= $p['id'] ?>">Remove</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>
</div>
<?php include "footer.php"; ?>

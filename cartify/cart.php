<?php
session_start();
include "db.php";

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

$action = $_POST['action'] ?? $_GET['action'] ?? null;

if ($action === 'add' && isset($_POST['product_id'])) {
    $pid = intval($_POST['product_id']);
    $qty = max(1, intval($_POST['qty'] ?? 1));
    if (isset($_SESSION['cart'][$pid])) $_SESSION['cart'][$pid] += $qty;
    else $_SESSION['cart'][$pid] = $qty;
    header("Location: cart.php"); exit;
}

if ($action === 'update' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $pid => $q) {
        $pid = intval($pid); $q = max(0,intval($q));
        if ($q <= 0) unset($_SESSION['cart'][$pid]);
        else $_SESSION['cart'][$pid] = $q;
    }
    header("Location: cart.php"); exit;
}

if ($action === 'remove' && isset($_GET['id'])) {
    $pid = intval($_GET['id']);
    unset($_SESSION['cart'][$pid]);
    header("Location: cart.php"); exit;
}

include "header.php";
?>
<div class="container">
  <h2>Your Cart</h2>

  <?php if (empty($_SESSION['cart'])): ?>
    <div class="card">Your cart is empty. <a href="index.php" class="btn">Shop Now</a></div>
  <?php else: ?>
    <?php
      $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
      $rows = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
      $products = [];
      while($r = mysqli_fetch_assoc($rows)) $products[$r['id']] = $r;
      $subtotal = 0;
    ?>
    <form method="post" action="cart.php">
      <input type="hidden" name="action" value="update">
      <div class="card">
        <?php foreach($_SESSION['cart'] as $pid => $qty):
            if (!isset($products[$pid])) continue;
            $prod = $products[$pid];
            $line = $prod['price'] * $qty;
            $subtotal += $line;
        ?>
          <div class="cart-item">
            <img src="prod_img/<?= htmlspecialchars($prod['image']) ?>" alt="">
            <div style="flex:1;">
              <div style="font-weight:800;"><?= htmlspecialchars($prod['name']) ?></div>
              <div style="color:var(--muted); margin-top:6px;">₹<?= number_format($prod['price'],2) ?> × <?= intval($qty) ?> = <strong>₹<?= number_format($line,2) ?></strong></div>
              <div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
                <input type="number" name="qty[<?= $pid ?>]" value="<?= $qty ?>" min="0" style="width:80px;padding:8px;border-radius:8px;border:1px solid #eef6ff;">
                <a class="btn" href="cart.php?action=remove&id=<?= $pid ?>">Remove</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
          <div>
            <button class="btn" type="submit">Update Cart</button>
            <a class="btn" href="index.php">Continue Shopping</a>
          </div>
          <div style="width:320px;">
            <div class="card" style="padding:14px;">
              <div style="font-weight:800;">Order Summary</div>
              <div style="margin-top:8px;">Subtotal: <strong>₹<?= number_format($subtotal,2) ?></strong></div>
              <div style="margin-top:12px;">
                <a class="btn" href="checkout.php">Proceed to Checkout</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  <?php endif; ?>
</div>
<?php include "footer.php"; ?>

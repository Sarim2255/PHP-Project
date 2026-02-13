<?php
session_start();
include "db.php";
if (isset($_GET['product_id']) && isset($_GET['qty'])) {
    // quick buy flow
    $pid = intval($_GET['product_id']);
    $qty = max(1, intval($_GET['qty']));
    $_SESSION['cart'] = []; // clear previous for single buy
    $_SESSION['cart'][$pid] = $qty;
}

if (empty($_SESSION['cart'])) { header("Location: cart.php"); exit; }
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
$rows = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
$products = [];
$subtotal = 0;
while($r = mysqli_fetch_assoc($rows)){
  $products[$r['id']] = $r;
  $subtotal += $r['price'] * $_SESSION['cart'][$r['id']];
}
include "header.php";
?>
<div class="container">
  <h2>Checkout</h2>

  <div style="display:grid; grid-template-columns:1fr 360px; gap:20px;">
    <div>
      <div class="card">
        <h3>Shipping Details</h3>
        <?php
          $uid = intval($_SESSION['user_id']);
          $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$uid LIMIT 1"));
        ?>
        <p><strong><?= htmlspecialchars($user['name']) ?></strong></p>
        <p><?= nl2br(htmlspecialchars($user['address'])) ?></p>
        <p><?= htmlspecialchars($user['phone']) ?></p>
      </div>

      <div class="card" style="margin-top:12px;">
        <h3>Items</h3>
        <?php foreach($_SESSION['cart'] as $pid => $qty):
            $prod = $products[$pid];
        ?>
          <div style="display:flex; gap:12px; margin-bottom:8px;">
            <img src="prod_img/<?= htmlspecialchars($prod['image']) ?>" style="width:80px;height:70px;object-fit:cover;border-radius:8px;">
            <div>
              <div style="font-weight:800;"><?= htmlspecialchars($prod['name']) ?></div>
              <div style="color:var(--muted);">Qty: <?= intval($qty) ?> × ₹<?= number_format($prod['price'],2) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div>
      <div class="card">
        <div style="font-weight:800; font-size:18px;">Order Summary</div>
        <div style="margin-top:8px;">Subtotal: <strong>₹<?= number_format($subtotal,2) ?></strong></div>

        <form action="place_order.php" method="post" style="margin-top:12px;">
          <input type="hidden" name="payment_method" value="cod">
          <button class="btn" type="submit" name="place_order">Place Order (Cash on Delivery)</button>
        </form>

        <div style="margin-top:14px; text-align:center;">
          <button class="btn" disabled>Pay Online (Coming Soon)</button>
          <!-- <div style="font-size:13px;color:var(--muted); margin-top:6px;">You can enable online payment after API keys.</div> -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>

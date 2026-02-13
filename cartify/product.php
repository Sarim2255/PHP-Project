<?php
session_start();
include "db.php";

$id = intval($_GET['id'] ?? 0);
$q = mysqli_query($conn, "SELECT * FROM products WHERE id = $id LIMIT 1");

if (!$q || mysqli_num_rows($q) === 0) {
    include "header.php";
    echo "<div class='container'><div class='card'>Product not found.</div></div>";
    include "footer.php";
    exit;
}

$p = mysqli_fetch_assoc($q);
include "header.php";
?>

<div class="container">

    <div class="card" style="padding:28px;">

        <div class="product-detail">

            <!-- IMAGE SECTION -->
            <div>
                <img
                    src="prod_img/<?= htmlspecialchars($p['image']) ?>"
                    alt="<?= htmlspecialchars($p['name']) ?>"
                    style="
                        width:100%;
                        max-height:500px;
                        object-fit:contain;
                        background:#f3f4f6;
                    "
                >
            </div>

            <!-- DETAILS SECTION -->
            <div>

                <h1 class="detail-title">
                    <?= htmlspecialchars($p['name']) ?>
                </h1>

                <div class="detail-price" style="margin-bottom:10px;">
                    ₹<?= number_format($p['price'], 2) ?>
                </div>

                <div style="margin-bottom:14px;color:var(--muted);font-size:14px;">
                    Category:
                    <strong><?= htmlspecialchars($p['category_name']) ?></strong>
                </div>

                <?php if ($p['stock'] > 0): ?>
                    <span class="stock-badge">
                        In Stock (<?= intval($p['stock']) ?> available)
                    </span>
                <?php else: ?>
                    <span style="color:#dc2626;font-weight:800;">
                        Out of Stock
                    </span>
                <?php endif; ?>

                <p style="margin-top:18px;line-height:1.6;color:var(--muted);">
                    <?= nl2br(htmlspecialchars($p['description'])) ?>
                </p>

                <!-- ACTIONS -->
                <form
                    method="post"
                    action="cart.php"
                    style="margin-top:24px;display:flex;gap:12px;align-items:center;flex-wrap:wrap;"
                >
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">

                    <input
                        type="number"
                        name="qty"
                        value="1"
                        min="1"
                        max="<?= intval($p['stock']) ?>"
                        style="
                            width:90px;
                            padding:10px;
                            border-radius:10px;
                            border:1px solid #e5e7eb;
                        "
                        <?= $p['stock'] <= 0 ? 'disabled' : '' ?>
                    >

                    <button
                        type="submit"
                        class="btn-small"
                        <?= $p['stock'] <= 0 ? 'disabled' : '' ?>
                    >
                        Add to Cart
                    </button>

                    <a
                        href="checkout.php?product_id=<?= (int)$p['id'] ?>&qty=1"
                        class="btn-small"
                        style="background:#f59e0b;border-color:#f59e0b;"
                    >
                        Buy Now
                    </a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a
                            href="wishlist_action.php?id=<?= (int)$p['id'] ?>"
                            class="wishlist-btn"
                            title="Add to Wishlist"
                        >
                            ♥
                        </a>
                    <?php endif; ?>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include "footer.php"; ?>

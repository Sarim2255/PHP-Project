<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid = intval($_SESSION['user_id']);
$username = htmlspecialchars($_SESSION['user_name']);

// total orders
$total_orders = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM payments WHERE user_id=$uid")
)['total'];

// recent orders
$recent = mysqli_query($conn, "
    SELECT payments.*, so.product_id, p.name AS product_name
    FROM payments
    LEFT JOIN single_order so ON payments.order_id = so.id
    LEFT JOIN products p ON so.product_id = p.id
    WHERE payments.user_id = $uid
    ORDER BY payments.created_at DESC
    LIMIT 5
");

include "header.php";
?>

<div class="container">

    <h2 style="font-weight:800;">Welcome, <?= $username ?></h2>

    <!-- QUICK STATS -->
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:18px; margin-top:22px;">

        <!-- Total Orders -->
        <div class="card" style="padding:18px;">
            <div style="font-size:13px; color:var(--muted);">Total Orders</div>
            <div style="font-size:30px; font-weight:800; margin-top:6px;">
                <?= intval($total_orders) ?>
            </div>
        </div>

        <!-- Email -->
        <div class="card" style="padding:18px;">
            <div style="font-size:13px; color:var(--muted);">Account Email</div>
            <div style="font-size:16px; margin-top:6px;">
                <?= htmlspecialchars($_SESSION['user_email'] ?? "—") ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card" style="padding:18px;">
            <div style="font-size:13px; color:var(--muted);">Quick Actions</div>
            <div style="margin-top:10px; display:flex; flex-wrap:wrap; gap:10px;">
                <a class="btn" href="cart.php">🛒 Cart</a>
                <a class="btn" href="myorders.php">📦 My Orders</a>
                <a class="btn" href="profile.php">👤 Profile</a>
            </div>
        </div>

    </div>

    <!-- RECENT ORDERS -->
    <div style="margin-top:34px;">
        <h3 style="font-weight:800; margin-bottom:12px;">Recent Orders</h3>

        <div class="card" style="padding:18px;">

            <?php if (mysqli_num_rows($recent) == 0): ?>

                <p style="color:var(--muted);">No recent orders.</p>

            <?php else: ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($r = mysqli_fetch_assoc($recent)): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['order_id']) ?></td>
                                <td><?= htmlspecialchars($r['product_name'] ?? '—') ?></td>
                                <td>₹<?= number_format($r['total_amount'],2) ?></td>
                                <td><?= htmlspecialchars(ucfirst($r['payment_method'])) ?></td>
                                <td><?= htmlspecialchars($r['status'] ?? 'Pending') ?></td>
                                <td><?= htmlspecialchars($r['created_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php include "footer.php"; ?>

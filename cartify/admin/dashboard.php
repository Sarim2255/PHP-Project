<?php
session_start();
include "../db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

/* Fetch metrics safely */
function fetch_one($conn, $sql, $field = 'c') {
    $res = mysqli_query($conn, $sql);
    if (!$res) return 0;
    $row = mysqli_fetch_assoc($res);
    return isset($row[$field]) ? $row[$field] : 0;
}

$total_products  = intval(fetch_one($conn, "SELECT COUNT(*) AS c FROM products"));
$orders_today    = intval(fetch_one($conn, "SELECT COUNT(*) AS c FROM payments WHERE DATE(created_at) = CURDATE()"));
$pending_orders  = intval(fetch_one($conn, "SELECT COUNT(*) AS c FROM payments WHERE status = 'Pending'"));
$revenue_today   = floatval(fetch_one($conn, "SELECT IFNULL(SUM(total_amount),0) AS s FROM payments WHERE DATE(created_at)=CURDATE()", 's'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Dashboard - Cartify</title>
<link rel="stylesheet" href="../assets/theme.css">
<style>
/* small page-specific tweaks (keeps consistency with theme.css) */
.admin-layout{ display:flex; min-height:100vh; background:#f4f6fb; }
.sidebar{ width:220px; background:linear-gradient(180deg,#0f172a,#06B6D4); color:#fff; padding:22px 16px; position:fixed; height:100%; box-shadow: 0 6px 20px rgba(2,6,23,0.06); }
.sidebar h2{ font-size:20px; margin:0 0 12px; color:#fff; }
.sidebar a{ color:#e8f5ff; display:block; padding:10px 12px; margin-bottom:8px; text-decoration:none; border-radius:8px; font-weight:600; }
.sidebar a:hover, .sidebar a.active{ background: rgba(255,255,255,0.08); transform: translateX(4px); }
.main{ margin-left:220px; padding:22px; width:100%; box-sizing:border-box; }
.header-row{ display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:18px; }
.page-title{ font-size:22px; font-weight:800; color:#0f172a; }
.kpi-grid{ display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-top:12px; }
.kpi{ background:#fff; padding:18px; border-radius:12px; box-shadow:0 6px 18px rgba(2,6,23,0.04); border:1px solid #eef2f8; }
.kpi .label{ color:var(--muted); font-size:13px; margin-bottom:8px; }
.kpi .value{ font-size:22px; font-weight:800; color:#111827; }
.kpi .meta{ margin-top:8px; font-size:13px; color:#64748b; }
.quick-actions{ display:flex; gap:10px; flex-wrap:wrap; }
.btn { padding:8px 12px; border-radius:10px; border:none; cursor:pointer; font-weight:700; }
.btn.primary { background: linear-gradient(90deg,#06B6D4,#4F46E5); color:#fff; }
.btn.ghost { background: #fff; border:1px solid #e6eef8; color:#0f172a; }
@media(max-width:800px){
  .header-row{ flex-direction:column; align-items:flex-start; gap:8px; }
  .main{ padding:14px; margin-left:0; }
  .sidebar{ display:none; position:static; width:100%; height:auto; }
}
</style>
</head>
<body>
<div class="admin-layout">

  <aside class="sidebar" aria-label="Admin sidebar">
    <h2>Cartify Admin</h2>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="addproduct.php">Add Product</a>
    <a href="displayproduct.php">View Products</a>
    <a href="vieworders.php">View Orders</a>
    <a href="../logout.php">Logout</a>
  </aside>

  <main class="main">
    <div class="header-row">
      <div>
        <div class="page-title">Dashboard Overview</div>
        <div style="color:var(--muted); margin-top:6px;">Quick snapshot of store activity</div>
      </div>

      <div class="quick-actions">
        <button class="btn primary" onclick="location.href='addproduct.php'">+ Add Product</button>
        <button class="btn ghost" onclick="location.href='displayproduct.php'">Manage Products</button>
        <button class="btn ghost" onclick="location.href='vieworders.php'">View Orders</button>
      </div>
    </div>

    <div class="kpi-grid" role="region" aria-label="Key performance indicators">
      <div class="kpi" aria-live="polite">
        <div class="label">Total Products</div>
        <div class="value"><?= htmlspecialchars(number_format($total_products)) ?></div>
        <div class="meta">Active items in catalog</div>
      </div>

      <div class="kpi" aria-live="polite">
        <div class="label">Orders Today</div>
        <div class="value"><?= htmlspecialchars(number_format($orders_today)) ?></div>
        <div class="meta">Placed in last 24 hours</div>
      </div>

      <div class="kpi" aria-live="polite">
        <div class="label">Pending Orders</div>
        <div class="value"><?= htmlspecialchars(number_format($pending_orders)) ?></div>
        <div class="meta">Need processing</div>
      </div>

      <div class="kpi" aria-live="polite">
        <div class="label">Revenue (Today)</div>
        <div class="value">₹<?= htmlspecialchars(number_format($revenue_today, 2)) ?></div>
        <div class="meta">Total gross sales (estimated)</div>
      </div>
    </div>

    <!-- optional area for charts or additional panels -->
    <section style="margin-top:22px;">
      <div style="display:flex; gap:16px; flex-wrap:wrap;">
        <div class="card" style="flex:1; min-width:300px; padding:16px; border-radius:12px; background:#fff; border:1px solid #eef6ff;">
          <div style="font-weight:700;margin-bottom:8px;">Recent Activity</div>
          <div style="color:#475569;font-size:14px;">No recent alerts.</div>
        </div>

        <div class="card" style="width:320px; padding:16px; border-radius:12px; background:#fff; border:1px solid #eef6ff;">
          <div style="font-weight:700;margin-bottom:8px;">Quick Tips</div>
          <ul style="margin:0;padding-left:18px;color:#475569;font-size:14px;">
            <li>Keep stock updated to avoid oversell.</li>
            <li>Review pending orders regularly.</li>
            <li>Use consistent product images for a professional look.</li>
          </ul>
        </div>
      </div>
    </section>

  </main>
</div>
</body>
</html>

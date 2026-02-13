<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
$uid = intval($_SESSION['user_id']);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $profile_img = null;
    if (!empty($_FILES['profile_img']['name'])) {
        $uploadDir = __DIR__ . '/uploads/profile/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $ext = pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION);
        $filename = 'user_'.$uid.'_'.time().'.'.$ext;
        $target = $uploadDir.$filename;
        if (move_uploaded_file($_FILES['profile_img']['tmp_name'], $target)) {
            $profile_img = 'uploads/profile/'.$filename;
        }
    }

    if ($profile_img) {
        $sql = "UPDATE users SET name='$name', phone='$phone', address='$address', profile_img='".mysqli_real_escape_string($conn,$profile_img)."' WHERE id=$uid";
    } else {
        $sql = "UPDATE users SET name='$name', phone='$phone', address='$address' WHERE id=$uid";
    }

    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_name'] = $name;
        $msg = "Profile updated.";
    } else $msg = "Error: ".$conn->error;
}

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$uid LIMIT 1"));
include "header.php";
?>
<div class="container">
  <h2>Profile</h2>
  <?php if($msg): ?><div style="background:#e6ffef;padding:8px;border-radius:8px;margin-bottom:8px;"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <div style="display:grid; grid-template-columns:240px 1fr; gap:18px;">
    <div class="card" style="text-align:center;">
      <img src="<?= htmlspecialchars($user['profile_img'] ?: 'uploads/profile/default.png') ?>" style="width:140px;height:140px;border-radius:50%;object-fit:cover;">
      <h3 style="margin-top:8px;"><?= htmlspecialchars($user['name']) ?></h3>
      <p style="color:var(--muted);"><?= htmlspecialchars($user['email']) ?></p>
    </div>
    <div class="card">
      <form method="post" enctype="multipart/form-data">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <label style="margin-top:8px;">Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
        <label style="margin-top:8px;">Address</label>
        <textarea name="address"><?= htmlspecialchars($user['address']) ?></textarea>
        <label style="margin-top:8px;">Profile Image</label>
        <input type="file" name="profile_img" accept="image/*">
        <div style="margin-top:12px;">
          <button class="btn" type="submit" name="update_profile">Save Changes</button>
          <a class="btn" href="dashboard.php">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>

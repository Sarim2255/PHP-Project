<?php
session_start();
include "db.php";

$error = "";

if (isset($_POST['submit'])) {

    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");

    if ($q && mysqli_num_rows($q) > 0) {

        $user = mysqli_fetch_assoc($q);

        // Plain-text password check (use hashing in production)
        if ($user['password'] === $password) {

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;

        } else {
            $error = "Incorrect password.";
        }

    } else {
        $error = "Email not registered.";
    }
}

include "header.php";
?>

<div class="auth-wrapper">

    <div class="auth-card">

        <h2>Sign In</h2>

        <?php if ($error): ?>
            <div style="
                background:#ffefef;
                padding:12px;
                border-radius:10px;
                color:#b12704;
                font-weight:700;
                margin-bottom:18px;
                text-align:center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="login.php">

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <div class="auth-actions">
                <button type="submit" name="submit" class="btn btn-primary">
                    Login
                </button>

                <a href="register.php" class="btn btn-outline">
                    Create Account
                </a>
            </div>

        </form>

    </div>

</div>

<?php include "footer.php"; ?>

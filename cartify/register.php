<?php
session_start();
include "db.php";

$error = "";
$success = "";

if (isset($_POST['submit'])) {

    $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $phone    = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address  = mysqli_real_escape_string($conn, trim($_POST['address']));
    $role     = "user";

    $exists = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' LIMIT 1");

    if ($exists && mysqli_num_rows($exists) > 0) {
        $error = "Email already registered.";
    } else {
        $ins = mysqli_query($conn, "
            INSERT INTO users (name,email,password,phone,address,role)
            VALUES ('$name','$email','$password','$phone','$address','$role')
        ");

        if ($ins) {
            $success = "Account created successfully. Please login.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}

include "header.php";
?>

<div class="auth-wrapper">

    <div class="auth-card auth-wide">

        <h2>Create your Cartify account</h2>
        <p class="auth-subtitle">Fast checkout, wishlist & order tracking</p>

        <?php if ($success): ?>
            <div class="auth-alert success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="auth-alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="register.php">

            <div class="auth-grid">
                <div>
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>

                <div>
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <div class="auth-grid">
                <div>
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div>
                    <label>Phone Number</label>
                    <input type="text" name="phone" required>
                </div>
            </div>

            <div>
                <label>Address</label>
                <textarea name="address" rows="3"></textarea>
            </div>

            <div class="auth-actions">
                <button type="submit" name="submit" class="btn btn-primary">
                    Create Account
                </button>

                <a href="login.php" class="btn btn-outline">
                    Already have an account?
                </a>
            </div>

        </form>

        <div class="auth-footer">
            By creating an account, you agree to Cartify’s Terms & Privacy Policy.
        </div>

    </div>

</div>

<?php include "footer.php"; ?>

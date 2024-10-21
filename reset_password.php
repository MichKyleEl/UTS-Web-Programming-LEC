<?php
// reset_password.php
require 'database/config.php'; // config for database connection

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($token) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the token exists
        $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE reset_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update the user's password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("UPDATE tb_user SET user_password = :password, reset_token = NULL WHERE reset_token = :token");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            $success = "Your password has been successfully updated.";
        } else {
            $error = "Invalid token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require 'features/head.php'; ?>
</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.php" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="" />
                                    <span class="d-none d-lg-block">ERS</span>
                                </a>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                                        <p class="text-center small">Enter the reset token sent to your email and your new password</p>
                                    </div>

                                    <!-- Display errors -->
                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endif; ?>

                                    <!-- Display success message -->
                                    <?php if (!empty($success)): ?>
                                        <div class="alert alert-success"><?php echo $success; ?></div>
                                    <?php endif; ?>

                                    <form class="row g-3 needs-validation" action="reset_password.php" method="post" novalidate>
                                        <div class="col-12">
                                            <label for="token" class="form-label">Token</label>
                                            <input type="text" name="token" class="form-control" id="token" required />
                                            <div class="invalid-feedback">Please enter the reset token.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" name="new_password" class="form-control" id="new_password" required />
                                            <div class="invalid-feedback">Please enter your new password.</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required />
                                            <div class="invalid-feedback">Please confirm your new password.</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">
                                                <a href="login.php">Back to Login</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a href="#">Group 5</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php require 'features/js.php'; ?>
</body>

</html>
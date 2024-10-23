<?php
$pagename = "Login";
$urlname = "login.php";
require 'database/config.php'; // config for database connection
require 'authentication.php'; // authentication to manage sessions, etc.
require 'features/head.php';

// Initialize variables
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Please fill out both fields.";
    } else {
        // Check if the email exists in the database
        $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['role'] == 'admin') {
                // No hashing for admin password, just plain text comparison
                if ($password === $user['user_password']) {
                    // Credentials are correct for admin, set session variables
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_email'] = $user['user_email'];
                    $_SESSION['user_foto'] = $user['foto'];
                    $_SESSION['user_id'] = $user['user_id'];

                    // Redirect to admin dashboard
                    header("Location: admin.php");
                    exit();
                } else {
                    $error = "Invalid email or password for admin.";
                }
            } else {
                // For regular users, use hashed password verification
                if (password_verify($password, $user['user_password'])) {
                    // Credentials are correct for regular users, set session variables
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_email'] = $user['user_email'];
                    $_SESSION['user_foto'] = $user['foto'];
                    $_SESSION['user_id'] = $user['user_id'];

                    // Redirect to user dashboard
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Invalid email or password for user.";
                }
            }
        } else {
            $error = "No account found with this email.";
        }
    }
}
?>

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
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    <p class="text-center small">Enter your email & password to login</p>
                                </div>

                                <!-- Display errors -->
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>

                                <form class="row g-3 needs-validation" action="login.php" method="post" novalidate>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="email" class="form-control" id="email" required />
                                            <div class="invalid-feedback">Please enter your email.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" required />
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small">
                                            <a href="forgot_password.php">Forgot Password?</a>
                                        </p>
                                        <p class="small mb-0">
                                            Don't have account? <a href="signup.php">Create an account</a>
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
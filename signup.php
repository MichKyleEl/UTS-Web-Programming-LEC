<?php
$pagename = "Signup";
$urlname = "signup.php";
require 'database/config.php'; // config for database connection
require 'authentication.php';
require 'features/head.php';

// Initialize variables
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill out all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if the email already exists in the database
        $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $error = "This email is already registered.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user data into the database
            $stmt = $pdo->prepare("INSERT INTO tb_user (user_name, user_email, user_password, role) VALUES (:name, :email, :password, 'user')");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            if ($stmt->execute()) {
                // Account creation success
                $success = "Account created successfully! You can now <a href = 'login.php'>log in</a>.";
            } else {
                $error = "Error creating account. Please try again.";
            }
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
                                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                    <p class="text-center small">Enter your personal details to create account</p>
                                </div>

                                <!-- Display errors or success message -->
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php elseif (!empty($success)): ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php endif; ?>

                                <form class="row g-3 needs-validation" action="signup.php" method="post" novalidate>
                                    <div class="col-12">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input type="text" name="name" class="form-control" id="name" value="" required />
                                        <div class="invalid-feedback">Please, enter your name!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label">Your Email</label>
                                        <input type="email" name="email" class="form-control" id="email" value="" required />
                                        <div class="invalid-feedback">Please enter a valid Email address!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" required />
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                    </div>

                                    <div class="col-12">
                                        <p class="small mb-0">Already have an account? <a href="login.php">Login</a></p>
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
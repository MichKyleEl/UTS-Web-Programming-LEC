<?php
// forgot_password.php
require 'database/config.php'; // config for database connection

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $error = "Please enter your email.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT * FROM tb_user WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate unique token
            $token = bin2hex(random_bytes(50));

            // Save token to the database
            $stmt = $pdo->prepare("UPDATE tb_user SET reset_token = :token WHERE user_email = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Call the JavaScript function to send the email using EmailJS
            echo "
             <script src='https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js'></script>
            <script>
                function sendMail() {
                    (function(){
                      emailjs.init('3JzybJpzfkfHOkS_A'); // Account Public Key
                    })();
                    var params = {
                        to: '$email',
                        token: '$token'
                    };
                    var serviceID = 'service_zlpoq9h'; // Email Service ID
                    var templateID = 'template_sprclqg'; // Email Template ID
                    emailjs.send(serviceID, templateID, params)
                    .then(function(res) {
                        console.log('A password reset token has been sent to your email.');
                    }).catch(function(err) {
                        console.error('Failed to send email', err);
                    });
                }
                sendMail();
            </script>";

            $success = "A password reset token has been sent to your email.
            <a href = 'reset_password.php'>Reset Password here</a>";
        } else {
            $error = "No account found with that email.";
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
                                        <h5 class="card-title text-center pb-0 fs-4">Forgot Password</h5>
                                        <p class="text-center small">Enter your email to receive a password reset token</p>
                                    </div>

                                    <!-- Display errors -->
                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endif; ?>

                                    <!-- Display success message -->
                                    <?php if (!empty($success)): ?>
                                        <div class="alert alert-success"><?php echo $success; ?></div>
                                    <?php endif; ?>

                                    <form class="row g-3 needs-validation" action="forgot_password.php" method="post" novalidate>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" required />
                                            <div class="invalid-feedback">Please enter your email.</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Send Reset Token</button>
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
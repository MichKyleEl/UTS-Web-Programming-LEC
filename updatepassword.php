<?php
session_start();
require 'database/config.php';

$id = $_SESSION['user_id']; 

$current_password = $_POST['password'];
$new_password = $_POST['newpassword'];

$query = "SELECT user_password FROM tb_user WHERE user_id = :id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    if (password_verify($current_password, $user['user_password'])) {
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_query = "UPDATE tb_user SET user_password = :new_password WHERE user_id = :id";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->bindParam(':new_password', $hashed_new_password);
        $update_stmt->bindParam(':id', $id);

        if ($update_stmt->execute()) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Password changed successfully.'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error updating password.'];
        }
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Current password is incorrect.'];
    }
} else {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'User not found.'];
}

header('Location: index.php');
exit();
?>

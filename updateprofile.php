<?php
session_start();
require 'database/config.php';

$foto = isset($_POST['foto']) ? $_POST['foto'] : null;
$name = $_POST['name'];
$email = $_POST['email'];
$id = $_POST['hiddenID'];

$email_check_query = "SELECT user_id FROM tb_user WHERE user_email = :email AND user_id != :id";
$email_check_stmt = $pdo->prepare($email_check_query);
$email_check_stmt->bindParam(':email', $email);
$email_check_stmt->bindParam(':id', $id);
$email_check_stmt->execute();
$email_exists = $email_check_stmt->fetch(PDO::FETCH_ASSOC);

if ($email_exists) {
    $_SESSION['alert'] = ['type' => 'danger', 'message' => 'This email is already in use by another account. Please use a different email.'];
    header('Location: index.php');
    exit();
}

$select_query = "SELECT foto FROM tb_user WHERE user_id = :id";
$select_stmt = $pdo->prepare($select_query);
$select_stmt->bindParam(':id', $id);
$select_stmt->execute();
$current_user = $select_stmt->fetch(PDO::FETCH_ASSOC);

if ($current_user) {
    $current_foto = $current_user['foto'];
}

if (isset($_FILES['foto']['name']) && !empty($_FILES['foto']['name'])) {
    $filename = $_FILES['foto']['name'];
    $temp_file = $_FILES['foto']['tmp_name'];
    $upload_dir = 'uploads/profile/';

    if (move_uploaded_file($temp_file, $upload_dir . $filename)) {
        if (!empty($current_foto) && file_exists($upload_dir . $current_foto)) {
            unlink($upload_dir . $current_foto);
        }
        $foto = $filename;
    } else {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => 'File upload failed.'];
        header('Location: index.php');
        exit();
    }

    $update_query = "UPDATE tb_user SET user_name = :name, user_email = :email, foto = :foto WHERE user_id = :id";
    $stmt = $pdo->prepare($update_query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':id', $id);
} else {
    $update_query = "UPDATE tb_user SET user_name = :name, user_email = :email WHERE user_id = :id";
    $stmt = $pdo->prepare($update_query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
}

if ($stmt->execute()) {
    $select_query = "SELECT user_name, user_email, foto FROM tb_user WHERE user_id = :id";
    $select_stmt = $pdo->prepare($select_query);
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();

    $user = $select_stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['user_email'] = $user['user_email'];
    $_SESSION['user_foto'] = $user['foto'];

    $_SESSION['alert'] = ['type' => 'success', 'message' => 'Profile updated successfully.'];
} else {
    $errorInfo = $stmt->errorInfo();
    $_SESSION['alert'] = ['type' => 'danger', 'message' => "Error: " . $errorInfo[2]];
}

header('Location: index.php');
exit();
?>
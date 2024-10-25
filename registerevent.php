<?php
require 'database/config.php';
require 'authentication.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['event_id'])) {
    $eventID = $_GET['event_id'];
    $userId = $_SESSION['user_id'];

    $registerQuery = $pdo->prepare("INSERT INTO tb_registration (user_id, event_id, registration_date, status) 
        VALUES (:user_id, :event_id, NOW(), 'registered')");

    try {
        $registerQuery->execute([
            ':user_id' => $userId,
            ':event_id' => $eventID
        ]);

        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Event has been registered.'];
        header("Location: event.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Error: " . $e->getMessage()];
    }
} else {
    echo "Invalid request.";
}

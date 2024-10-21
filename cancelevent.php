<?php
require 'database/config.php';
require 'authentication.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['event_id'])) {
    $eventID = $_GET['event_id'];
    $userId = $_SESSION['user_id'];

    $cancelQuery = $pdo->prepare("DELETE FROM tb_registration WHERE user_id = :user_id AND event_id = :event_id");
    
    try {
        $cancelQuery->execute([
            ':user_id' => $userId,
            ':event_id' => $eventID
        ]);
        
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Event has been cancelled.'];
        header("Location: event.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Error: " . $e->getMessage()];
    }
} else {
    echo "Invalid request.";
}
?>

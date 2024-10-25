<?php
require 'database/config.php';
require 'authentication.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['event_id'])) {
    $eventID = $_GET['event_id'];
    $source = $_GET['source'];
    $userId = $_SESSION['user_id'];

    $cancelQuery = $pdo->prepare("UPDATE tb_registration 
        SET status = 'canceled', registration_date = NOW() 
        WHERE user_id = :user_id AND event_id = :event_id");
    
    try {
        $cancelQuery->execute([
            ':user_id' => $userId,
            ':event_id' => $eventID
        ]);
        
        $_SESSION['alert'] = ['type' => 'success', 'message' => 'Event has been cancelled.'];
        if ($source === 'event') {
            header("Location: event.php");
        } elseif ($source === 'eventreg') {
            header("Location: eventregistration.php");
        } else {
            header("Location: event.php"); // Default redirect if source is unknown
        }
        exit();
    } catch (PDOException $e) {
        $_SESSION['alert'] = ['type' => 'danger', 'message' => "Error: " . $e->getMessage()];
    }
} else {
    echo "Invalid request.";
}
?>

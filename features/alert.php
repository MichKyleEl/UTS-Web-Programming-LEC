<?php
if (isset($_SESSION['alert'])) {
    $alertType = $_SESSION['alert']['type'];
    $alertMessage = $_SESSION['alert']['message'];
    
    echo '<div class="alert alert-' . $alertType . ' alert-dismissible fade show" role="alert">';
    echo '<i class="bi ' . ($alertType === 'success' ? 'bi-check-circle' : 'bi-exclamation-octagon') . ' me-1"></i>';
    echo htmlspecialchars($alertMessage);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';

    unset($_SESSION['alert']);
}
?>
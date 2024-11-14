<?php
require_once 'includes/db.php';

// Log function for debugging
function console_log($message) {
    error_log("[Delete Lead] " . $message);
}

try {
    // Validate input
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception('Invalid lead ID');
    }

    $leadId = (int)$_POST['id'];
    console_log("Attempting to delete lead ID: " . $leadId);

    // Create database connection
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM leads WHERE id = ?");
    $result = $stmt->execute([$leadId]);

    if ($result) {
        console_log("Lead deleted successfully");
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to delete lead');
    }

} catch (Exception $e) {
    console_log("Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 
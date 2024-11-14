<?php
require_once 'includes/db.php';

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('Invalid lead ID');
    }

    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("
        SELECT l.*, d.title as department_name 
        FROM leads l 
        JOIN departments d ON l.department_id = d.id 
        WHERE l.id = ?
    ");
    
    $stmt->execute([$_GET['id']]);
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$lead) {
        throw new Exception('Lead not found');
    }
    
    echo json_encode($lead);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 
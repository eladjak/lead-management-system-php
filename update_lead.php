<?php
require_once 'includes/db.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id']) || !is_numeric($data['id'])) {
        throw new Exception('Invalid lead ID');
    }

    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("
        UPDATE leads 
        SET first_name = ?, 
            last_name = ?, 
            email = ?, 
            phone = ?, 
            department_id = ?, 
            content = ? 
        WHERE id = ?
    ");
    
    $result = $stmt->execute([
        $data['firstName'],
        $data['lastName'],
        $data['email'],
        $data['phone'],
        $data['department'],
        $data['content'],
        $data['id']
    ]);

    if (!$result) {
        throw new Exception('Failed to update lead');
    }
    
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 
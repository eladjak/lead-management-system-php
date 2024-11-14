<?php
require_once 'includes/db.php';

header('Content-Type: application/json');

try {
    // Validate input
    $required_fields = ['firstName', 'lastName', 'email', 'phone', 'department', 'content'];
    $data = json_decode(file_get_contents('php://input'), true);
    
    foreach ($required_fields as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Validate email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format");
    }

    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("INSERT INTO leads (first_name, last_name, email, phone, department_id, content) VALUES (?, ?, ?, ?, ?, ?)");
    
    $result = $stmt->execute([
        $data['firstName'],
        $data['lastName'],
        $data['email'],
        $data['phone'],
        $data['department'],
        $data['content']
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Failed to save lead");
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 
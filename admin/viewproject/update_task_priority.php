<?php
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = isset($_POST['taskId']) ? (int)$_POST['taskId'] : 0;
    $priority = isset($_POST['priority']) ? $_POST['priority'] : '';

    if ($taskId === 0 || empty($priority)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
        exit;
    }

    $sql = "UPDATE todos SET priority = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $priority, $taskId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update task priority.']);
    }

    $stmt->close();
}
?>

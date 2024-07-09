<?php
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = isset($_POST['taskId']) ? (int)$_POST['taskId'] : 0;

    if ($taskId === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid task ID.']);
        exit;
    }

    $sql = "DELETE FROM todos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $taskId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete task.']);
    }

    $stmt->close();
}
?>

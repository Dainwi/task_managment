<?php
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = isset($_POST['taskId']) ? (int)$_POST['taskId'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($taskId === 0 || empty($status)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
        exit;
    }

    $sql = "UPDATE todos SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $taskId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed']);
    }

    $stmt->close();
}
?>

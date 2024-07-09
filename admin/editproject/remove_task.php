<?php
session_start();
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $taskId = $_POST['id'];

        // Sanitize the task ID
        $taskId = mysqli_real_escape_string($conn, $taskId);

        // Create the SQL query to delete the task
        $sql = "DELETE FROM todos WHERE id = $taskId";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo 'success';
        } else {
            http_response_code(500);
            echo 'Failed to remove task';
        }

        // Close the connection
        mysqli_close($conn);
    } else {
        http_response_code(400);
        echo 'Invalid task ID';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?>

?>
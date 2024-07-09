<?php
session_start();
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $projectId = $_POST['id'];

        // Sanitize the project ID
        $projectId = mysqli_real_escape_string($conn, $projectId);

        // Begin transaction
        mysqli_begin_transaction($conn);

        try {
            // Delete related todos
            $sql_todos = "DELETE FROM todos WHERE project_id = $projectId";
            if (!mysqli_query($conn, $sql_todos)) {
                throw new Exception('Failed to remove todos');
            }

            // Delete the project
            $sql_project = "DELETE FROM projects WHERE id = $projectId";
            if (!mysqli_query($conn, $sql_project)) {
                throw new Exception('Failed to remove project');
            }

            // Commit transaction
            mysqli_commit($conn);
            echo 'success';
        } catch (Exception $e) {
            // Rollback transaction in case of error
            mysqli_rollback($conn);
            http_response_code(500);
            echo $e->getMessage();
        }

        // Close the connection
        mysqli_close($conn);
    } else {
        http_response_code(400);
        echo 'Invalid project ID';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?>

<?php
include "../../config/config.php";
include "../../config/constant.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectId = $_POST['project_id'];
    $name = $_POST['name'];
    $tasks = $_POST['tasks'];

    // Update project details
    $sql = "UPDATE projects SET name = '$name', updated_at = NOW() WHERE id = $projectId";
    if ($conn->query($sql) === TRUE) {
        // Update tasks
        foreach ($tasks as $task) {
            $taskId = $task['id'];
            $taskTitle = $task['title'];

            if ($taskId == 'new') {
                $sql_task = "INSERT INTO todos (project_id, title, description, status, created_at, updated_at) VALUES ('$projectId', '$taskTitle', '', 'pending', NOW(), NOW())";
            } else {
                $sql_task = "UPDATE todos SET title = '$taskTitle', updated_at = NOW() WHERE id = $taskId";
            }
            $conn->query($sql_task);
        }

        // echo "successful";
        header("Location: " . BASE_URL."/admin/dashboard");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}



?>

<?php
include "../../config/config.php";
include "../../config/constant.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $tasks = $_POST['tasks'];

    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Project name is required']);
        exit;
    }

    // Insert project into the projects table
    $sql = "INSERT INTO projects (name, description, user_id, created_at, updated_at) VALUES ('$name', '', 1, NOW(), NOW())";
    if ($conn->query($sql) === TRUE) {
        $project_id = $conn->insert_id;

        // Insert tasks into the todos table
        foreach ($tasks as $task) {
            $task_title = $task['title'];
            $sql_task = "INSERT INTO todos (project_id, title, description, status, created_at, updated_at) VALUES ('$project_id', '$task_title', '', 'pending', NOW(), NOW())";
            $conn->query($sql_task);
        }

        echo json_encode(['status' => 'success', 'message' => 'Project and tasks created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
    }
}
?>

<?php
include "../../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    // $description = $_POST['description'];
    $tasks = $_POST['tasks'];

    // Insert project into the projects table
    $sql = "INSERT INTO projects (name, description, user_id, created_at, updated_at) VALUES ('$name', '', 1, NOW(), NOW())";
    if ($conn->query($sql) === TRUE) {
        $project_id = $conn->insert_id;

        // Insert tasks into the todos table
        foreach ($tasks as $task) {
            $task_title = $task['title'];
            // $task_description = $task['description'];
            $sql_task = "INSERT INTO todos (project_id, title, description, status, created_at, updated_at) VALUES ('$project_id', '$task_title', '', 'pending', NOW(), NOW())";
            $conn->query($sql_task);
        }

        echo "New project and tasks created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
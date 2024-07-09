<?php
session_start();
include '../includes/header.php';
include '../../config/config.php';

if (isset($_GET['id'])) {
    $projectId = $_GET['id'];

    // Sanitize the project ID
    $projectId = mysqli_real_escape_string($conn, $projectId);

    // Fetch project details
    $sql = "SELECT * FROM projects WHERE id = $projectId";
    $result = mysqli_query($conn, $sql);
    $project = mysqli_fetch_assoc($result);

    // Fetch project tasks
    $sql_tasks = "SELECT * FROM todos WHERE project_id = $projectId";
    $result_tasks = mysqli_query($conn, $sql_tasks);
    $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);
}
?>
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
        <!-- Navbar -->
        <?php include "../includes/navbar.php"; ?>
        <!-- ./Navbar -->

        <!-- Sidebar -->
        <?php include "../includes/sidebar.php"; ?>
        <!-- ./Sidebar -->
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
            <div class="h-full ml-14 mt-24 mb-10 md:ml-64">
                <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h1 class="text-3xl font-bold mb-4">Edit Project</h1>
                    <form id="project-form" method="POST" action="update_project.php">
                        <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="project-title">
                                    Project Title
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="project-title" name="name" type="text" placeholder="Enter project title" value="<?php echo $project['name']; ?>">
                            </div>
                        </div>
                        <div id="task-list" class="mt-6">
                            <?php foreach ($tasks as $index => $task) : ?>
                                <div class="flex justify-between mb-4">
                                    <input type="hidden" name="tasks[<?php echo $index; ?>][id]" value="<?php echo $task['id']; ?>">
                                    <input type="text" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" name="tasks[<?php echo $index; ?>][title]" value="<?php echo $task['title']; ?>" placeholder="Enter task <?php echo $index + 1; ?>">
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-task-btn" data-task-id="<?php echo $task['id']; ?>">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" id="add-task-btn">Add Task</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Update Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var taskCount = <?php echo count($tasks); ?>;
        $('#add-task-btn').on('click', function(e) {
            e.preventDefault();
            taskCount++;
            $('#task-list').append(
                '<div class="flex justify-between mb-4">' +
                '<input type="hidden" name="tasks[' + taskCount + '][id]" value="new">' +
                '<input type="text" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" name="tasks[' + taskCount + '][title]" placeholder="Enter task ' + taskCount + '">' +
                '<button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-task-btn">Remove</button>' +
                '</div>'
            );
        });

        $(document).on('click', '.remove-task-btn', function(e) {
    e.preventDefault();
    
    const taskId = $(this).data('task-id');
    const $taskElement = $(this).parent();
    
    $.ajax({
        url: 'remove_task.php', // PHP script to handle the deletion
        type: 'POST',
        data: { id: taskId },
        success: function(response) {
            // On success, remove the task element from the DOM
            if (response === 'success') {
                $taskElement.remove();
                window.location.reload();
            } else {
                console.error('Failed to remove task:', response);
            }
        },
        error: function(xhr, status, error) {
            // Handle any errors here
            console.error('Failed to remove task:', error);
        }
    });
});



    });
</script>
<?php include "../includes/footer.php"; ?>
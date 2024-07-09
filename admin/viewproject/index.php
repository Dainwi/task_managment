<?php
session_start();
include '../includes/header.php';
include '../../config/config.php';

$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId === 0) {
    die('Invalid project ID.');
}

// Fetch project details
$sql_project = "SELECT * FROM projects WHERE id = $projectId";
$result_project = mysqli_query($conn, $sql_project);
$project = mysqli_fetch_assoc($result_project);

if (!$project) {
    die('Project not found.');
}

// Fetch project tasks
$sql_tasks = "SELECT * FROM todos WHERE project_id = $projectId";
$result_tasks = mysqli_query($conn, $sql_tasks);
$count = 1;
?>
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
        <!-- Navbar -->
        <?php include "../includes/navbar.php" ?>
        <!-- ./Navbar -->

        <!-- Sidebar -->
        <?php include "../includes/sidebar.php" ?>
        <!-- ./Sidebar -->

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64 p-2">
            <div class="container sm:mx-auto mt-14">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h1 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($project['name']); ?></h1>
                    <p class="mb-4"><?php echo htmlspecialchars($project['description']); ?></p>

                    <h2 class="text-xl font-bold mb-4">Tasks</h2>
                    <ul id="task-list">
                        <?php while ($task = mysqli_fetch_assoc($result_tasks)) : ?>
                            <li class="flex lg:justify-between lg:items-center mb-2 flex-wrap task-item">
                                <div class="w-9 h-9 rounded-full flex-shrink-0  my-2 mr-3 flex items-center justify-center">
                                    <span class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-500 bg-red-50 rounded-full">
                                        <?php echo $count; ?>
                                    </span>
                                </div>
                                <span class="flex-grow task-info">
                                    <?php echo htmlspecialchars($task['title']); ?>
                                </span>
                                <div class="task-controls">
                                    <select class="task-status p-2 rounded bg-gray-200 dark:bg-gray-600 dark:text-white mx-3 p-2" data-task-id="<?php echo $task['id']; ?>">
                                        <option value="pending" <?php if ($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                        <option value="ongoing" <?php if ($task['status'] == 'ongoing') echo 'selected'; ?>>Ongoing</option>
                                        <option value="completed" <?php if ($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                    </select>
                                    <select class="task-priority p-2 rounded bg-gray-200 dark:bg-gray-600 dark:text-white mx-3 p-2" data-task-id="<?php echo $task['id']; ?>">
                                        <option value="low" <?php if ($task['priority'] == 'low') echo 'selected'; ?>>Low</option>
                                        <option value="medium" <?php if ($task['priority'] == 'medium') echo 'selected'; ?>>Medium</option>
                                        <option value="high" <?php if ($task['priority'] == 'high') echo 'selected'; ?>>High</option>
                                    </select>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2 delete-task" data-task-id="<?php echo $task['id']; ?>">Delete</button>
                                </div>
                            </li>
                        <?php $count++;
                        endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 500px) {
        .task-controls {
            display: flex;
            flex-direction: column;
        }

        .task-status,
        .task-priority,
        .delete-task {
            margin-bottom: 10px;
        }
    }
</style>

<script src="<?php echo BASE_URL ?>/assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('.task-status').on('change', function() {
            var taskId = $(this).data('task-id');
            var newStatus = $(this).val();
            $.ajax({
                url: 'update_task_status.php',
                type: 'POST',
                data: {
                    taskId: taskId,
                    status: newStatus
                },
                success: function(response) {
                    location.reload();
                }
            });
        });

        $('.task-priority').on('change', function() {
            var taskId = $(this).data('task-id');
            var newPriority = $(this).val();
            $.ajax({
                url: 'update_task_priority.php',
                type: 'POST',
                data: {
                    taskId: taskId,
                    priority: newPriority
                },
                success: function(response) {
                    location.reload();
                }
            });
        });

        $('.delete-task').on('click', function() {
            if (!confirm('Are you sure you want to delete this task?')) {
                return;
            }
            var taskId = $(this).data('task-id');
            $.ajax({
                url: 'delete_task.php',
                type: 'POST',
                data: {
                    taskId: taskId
                },
                success: function(response) {
                    location.reload();
                }
            });
        });
    });
</script>
<?php include '../includes/footer.php'; ?>
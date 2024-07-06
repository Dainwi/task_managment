<?php
session_start();
include '../includes/header.php';
include '../../config/config.php';
$userId = $_SESSION['user_id'];

// Sanitize the user ID
$userId = mysqli_real_escape_string($conn, $userId);

$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
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
                    <h1 class="text-3xl font-bold mb-4">Project Management Website</h1>
                    <form id="project-form" method="POST" action="add_project.php">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="project-title">
                                    Project Title
                                </label>
                                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="project-title" name="name" type="text" placeholder="Enter project title">
                            </div>
                        </div>
                        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" id="add-task-btn">Add Task</button>
                        <div id="task-list" class="mt-6">
                            <!-- Task list will be displayed here -->
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Create Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var taskCount = 0;
        $('#add-task-btn').on('click', function(e) {
            e.preventDefault();
            taskCount++;
            $('#task-list').append(
                '<div class="flex justify-between mb-4">' +
                '<input type="text" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" name="tasks[' + taskCount + '][title]" placeholder="Enter task ' + taskCount + '">' +
                '<button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-task-btn">Remove</button>' +
                '</div>'
            );
        });

        $(document).on('click', '.remove-task-btn', function(e) {
            e.preventDefault();
            $(this).parent().remove();
        });
    });
</script>
<?php include "../includes/footer.php"; ?>

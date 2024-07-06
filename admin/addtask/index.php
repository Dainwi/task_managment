<?php
session_start();
include '../includes/header.php';
// include '../includes/navbar.php';
// include '../includes/sidebar.php';
?>
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
        <!-- Navbar -->
        <?php include "../includes/navbar.php" ?>
        <!-- ./Navbar -->

        <!-- Sidebar -->
        <?php include "../includes/sidebar.php" ?>
        <!-- ./Sidebar -->

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64">
            <div class="grid grid-cols-1 lg:grid-cols-2 p-4 gap-4">
            


                <div class="relative flex flex-col min-w-0 mb-4 lg:mb-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                    <div class="rounded-t mb-0 px-0 border-0">
                        <div id="projectForm" class=" px-4 py-2">
                            <form id="projectForm" method="POST">
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 dark:text-gray-50 text-sm font-bold mb-2">Project Name</label>
                                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 dark:bg-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                                <!-- <div class="mb-4">
                                    <label for="description" class="block text-gray-700 dark:text-gray-50 text-sm font-bold mb-2">Description</label>
                                    <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                </div> -->
                                <div id="tasks">
                                    <div class="flex flex-wrap items-center px-4 py-2">
                                        <div class="relative w-full max-w-full flex-grow flex-1">
                                            <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Add Task</h3>
                                        </div>
                                        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                                            <button id="addTaskBtn" class="bg-blue-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Add Task</button>
                                        </div>
                                    </div>

                                    <div class="task mb-4">
                                        <label for="task_title_1" class="block text-gray-700 dark:text-gray-50 text-sm font-bold mb-2">Task</label>
                                        <input type="text" id="task_title_1" name="task_title[]" class="shadow appearance-none border rounded w-full py-2 px-3 dark:bg-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                                        <!-- <button class="removeTaskBtn bg-red-500 hover:bg-red-700 text-white  py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2" type="button">Remove Task</button> -->

                                        <button class="removeTaskBtn bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="12" width="12" viewBox="0 0 448 512">
                                                <path fill="#ffffff" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                                <!-- <button id="addTaskBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">Add Task</button> -->
                                <div class="flex items-center justify-between mt-4">
                                    <button id="submitProject" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
<script src="<?php echo BASE_URL ?>/assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {
        let taskCount = 1;

        $("#addTaskBtn").click(function() {
            taskCount++;
            $("#tasks").append(`
                    <div class="task mb-4">
                        <label for="task_title_${taskCount}" class="block text-gray-700 dark:text-gray-50 text-sm font-bold mb-2">Task Title</label>
                        <input type="text" id="task_title_${taskCount}" name="task_title[]" class="shadow appearance-none border rounded w-full py-2 px-3 dark:bg-gray-700 dark:text-white leading-tight focus:outline-none focus:shadow-outline">
                        
                       
                        <button class="removeTaskBtn bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="12" width="12" viewBox="0 0 448 512"><path fill="#ffffff" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                    </button>
                    </div>
                `);
        });

        $(document).on('click', '.removeTaskBtn', function() {
            $(this).closest('.task').remove();
        });

        $("#submitProject").click(function() {
            var name = $("#name").val();
            var description = $("#description").val();
            var tasks = [];
            $(".task").each(function() {
                var title = $(this).find("input[name='task_title[]']").val();
                var description = $(this).find("textarea[name='task_description[]']").val();
                tasks.push({
                    title: title,
                    description: description
                });
            });

            $.ajax({
                url: 'add_project.php',
                type: 'POST',
                data: {
                    name: name,
                    description: description,
                    tasks: tasks
                },
                success: function(response) {
                    alert(response);
                    // $("#projectList").append('<li class="flex px-4"><div class="w-9 h-9 rounded-full flex-shrink-0 bg-indigo-500 my-2 mr-3"><svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36"><path d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z"></path></svg></div><div class="flex-grow flex items-center border-b border-gray-100 dark:border-gray-400 text-sm text-gray-600 dark:text-gray-100 py-2"><div class="flex-grow flex justify-between items-center"><div class="self-center"><a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100" href="#0" style="outline: none;">' + name + '</a></div></div></div></li>');
                    window.location.reload();
                }
            });
        });
    });
</script>
<?php include '../includes/footer.php'; ?>
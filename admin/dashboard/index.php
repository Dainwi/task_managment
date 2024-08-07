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

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64 p-2">
            <div class="container sm:mx-auto mt-14">
                <!-- Project -->
                <div class="relative flex flex-col min-w-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                    <div class="rounded-t mb-0 px-0 border-0">
                        <div class="flex flex-wrap items-center px-4 py-2">
                            <div class="relative w-full max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Projects</h3>
                            </div>
                            <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                                <a href="<?php echo BASE_URL ?> /admin/addproject" target="_self" rel="noopener noreferrer">
                                    <button id="addProjectBtn" class="bg-blue-500 dark:bg-gray-100 text-white active:bg-blue-600 dark:text-gray-800 dark:active:text-gray-700 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">Add Project</button>
                                </a>
                            </div>
                        </div>

                        <div class="block w-full">
                            <ul id="projectList" class="my-1">
                                <!-- Project items will be added here dynamically -->


                                <?php
                                include "../../config/config.php";


                                // Fetch projects
                                $sql = "SELECT id, name, description FROM projects";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $count = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li class="flex px-4">
                                                <div class="w-9 h-9 rounded-full flex-shrink-0  my-2 mr-3 flex items-center justify-center">
                                                    <span class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-500 bg-red-50 rounded-full">
                                                        ' . $count . '
                                                    </span>
                                                </div>
                                                <div class="flex-grow flex items-center border-b border-gray-100 dark:border-gray-400 text-sm text-gray-600 dark:text-gray-100 py-2">
                                                    <div class="flex-grow flex justify-between items-center">
                                                        <div class="self-center flex-grow flex justify-between items-center">
                                                            <a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100" href="' . BASE_URL . '/admin/viewproject?id=' . $row["id"] . '" style="outline: none;">' . $row["name"] . '</a>
                                                            <div class="mt-1 sm:mt-0 sm:flex sm:justify-between">
                                                                <div class="mt-1 sm:mt-0 sm:flex">
                                                                    <a href="' . BASE_URL . '/admin/editproject?id=' . $row["id"] . '" target="_self" rel="noopener noreferrer">
                                                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" height="12" width="12" viewBox="0 0 512 512">
                                                                                <path fill="#ffffff" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                                                            </svg>
                                                                        </button>
                                                                    </a>
                                                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteProject(' . $row["id"] . ')">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="12" width="12" viewBox="0 0 448 512">
                                                                            <path fill="#ffffff" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </li>';
                                        $count++;
                                    }
                                } else {
                                    echo "<li class='text-center text-xl my-5'>No projects found <br> Please add Project to see here </li>";
                                }


                                $conn->close();
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ./Project -->



            </div>
        </div>




    </div>
</div>

<script src="<?php echo BASE_URL ?>/assets/js/jquery.js"></script>
<script>
    function deleteProject(projectId) {
        if (confirm('Are you sure you want to delete this project and all its tasks?')) {
            $.ajax({
                url: 'remove_project.php',
                type: 'POST',
                data: {
                    id: projectId
                },
                success: function(response) {
                    if (response === 'success') {

                        $('button[onclick="deleteProject(' + projectId + ')"]').closest('li').remove();
                    } else {
                        console.error('Failed to remove project:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to remove project:', error);
                }
            });
        }
    }
</script>


<?php include '../includes/footer.php'; ?>
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
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li class="flex px-4">
                                                <div class="w-9 h-9 rounded-full flex-shrink-0 bg-indigo-500 my-2 mr-3">
                                                    <svg class="w-9 h-9 fill-current text-indigo-50" viewBox="0 0 36 36">
                                                        <path d="M18 10c-4.4 0-8 3.1-8 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L18.9 22H18c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-grow flex items-center border-b border-gray-100 dark:border-gray-400 text-sm text-gray-600 dark:text-gray-100 py-2">
                                                    <div class="flex-grow flex justify-between items-center">
                                                        <div class="self-center flex-grow flex justify-between items-center">
                                                            <a class="font-medium text-gray-800 hover:text-gray-900 dark:text-gray-50 dark:hover:text-gray-100" href="#0" style="outline: none;">' . $row["name"] . '</a>
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
                                    }
                                } else {
                                    echo "<li>No projects found</li>";
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

</script>
<?php include '../includes/footer.php'; ?>
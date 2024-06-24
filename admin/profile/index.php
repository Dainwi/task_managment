<?php 
// include '../../includes/header.php';
include '../../includes/navbar.php';
include '../../includes/sidebar.php'; 
?>

<!-- Profile update -->

<div x-data="setup()" :class="{ 'dark': isDark }">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
        <div class="h-full">

            <div class="border-b-2 block md:flex">

                <div class="w-full md:w-2/5 p-4 sm:p-6 lg:p-8 bg-white shadow-md">
                    <div class="flex justify-between">
                        <span class="text-xl font-semibold block">Admin Profile</span>
                        <a href="#" class="-mt-2 text-md font-bold text-white bg-gray-700 rounded-full px-5 py-2 hover:bg-gray-800">Edit</a>
                    </div>

                    <span class="text-gray-600">This information is secret so be careful</span>
                    <div class="w-full p-8 mx-2 flex justify-center">
                        <img id="showImage" class="max-w-xs w-32 items-center border" src="https://images.unsplash.com/photo-1477118476589-bff2c5c4cfbb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=200&q=200" alt="">
                    </div>
                </div>

                <div class="w-full md:w-3/5 p-8 bg-white lg:ml-4 shadow-md">
                    <div class="rounded  shadow p-6">
                        <div class="pb-6">
                            <label for="name" class="font-semibold text-gray-700 block pb-1">Name</label>
                            <div class="flex">
                                <input disabled id="username" class="border-1  rounded-r px-4 py-2 w-full" type="text" value="Jane Name" />
                            </div>
                        </div>
                        <div class="pb-4">
                            <label for="about" class="font-semibold text-gray-700 block pb-1">Email</label>
                            <input disabled id="email" class="border-1  rounded-r px-4 py-2 w-full" type="email" value="example@example.com" />
                            <span class="text-gray-600 pt-4 block opacity-70">Personal login information of your account</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>
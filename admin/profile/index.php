<?php
session_start();
include '../includes/header.php';
// include '../includes/navbar.php';
// include '../includes/sidebar.php';
?>
<?php
include '../../config/config.php';
$userId = $_SESSION['user_id'];

// Sanitize the user ID
$userId = mysqli_real_escape_string($conn, $userId);

$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<!-- Profile update -->
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
          <!-- Navbar -->
          <?php include "../includes/navbar.php" ?>
        <!-- ./Navbar -->

        <!-- Sidebar -->
        <?php include "../includes/sidebar.php" ?>
        <!-- ./Sidebar -->
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">
            <div class="h-full ml-14 mt-24 mb-10 md:ml-64">
                <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6">Edit Profile</h2>
                    <form action="update_profile.php" method="POST" class="space-y-6" enctype="multipart/form-data">
                        <!-- Add CSRF token for security -->
                        <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->

                        <div class="flex flex-col">
                            <label for="name" class="text-sm font-medium">Name</label>
                            <input type="text" id="name" name="name" class="mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" value="<?php echo htmlspecialchars($user['name']); ?>">
                        </div>
                        <div class="flex flex-col">
                            <label for="email" class="text-sm font-medium">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        <div class="flex flex-col">
                            <label for="password" class="text-sm font-medium">New Password</label>
                            <input type="password" id="password" name="password" class="mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="flex flex-col">
                            <label for="old_password" class="text-sm font-medium">Password</label>
                            <input type="password" id="old_password" name="old_password" class="mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="flex flex-col">
                            <label for="profile_picture" class="text-sm font-medium">Profile Picture</label>
                            <input type="file" id="profile_picture" name="profile_picture" class="mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" accept="image/*" onchange="previewImage(event)">
                            <img id="profile_picture_preview" src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture Preview" class="mt-4 w-32 h-32 object-cover rounded-full">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ./Profile Edit Form -->
</div>
<script src="<?php echo BASE_URL ?>/assets/js/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'update_profile.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                    window.location.reload();
                },
                error: function() {
                    alert('Error updating profile');
                    window.location.reload();
                }
            });
        });

        // Image preview
        $('#profile_picture').change(function() {
            var file = this.files[0];
            if (file.size <= 1048576) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile_picture_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            } else {
                alert('Profile picture must be 1MB or less');
                $(this).val(''); // Clear the input
            }
        });
    });
</script>
<?php include '../includes/footer.php'; ?>
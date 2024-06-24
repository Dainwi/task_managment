<!-- <script src="../assets/js/alpine.min.js"></script> -->
<script src="<?php echo BASE_URL ?>/assets/js/alpine.min.js"></script>
<script>
    const setup = () => {
        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }
            return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
        }

        const setTheme = (value) => {
            window.localStorage.setItem('dark', value)
        }

        return {
            loading: true,
            isDark: getTheme(),
            toggleTheme() {
                this.isDark = !this.isDark
                setTheme(this.isDark)
            },
        }
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const profilePictureInput = document.getElementById('profile_picture');
        const profilePicturePreview = document.getElementById('profile_picture_preview');

        profilePictureInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePicturePreview.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
</body>

</html>
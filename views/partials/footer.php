<script>
    function showErrorModal(messages) {
        console.log(messages);
        var errorModal = $('#errormodal');
        var errorMessagesDiv = errorModal.find('#errormessage');

        // Clear existing error messages
        errorMessagesDiv.empty();

        // Append new error messages
        messages.forEach(function(message) {
            console.log(message);

            errorMessagesDiv.append('<p>' + message + '</p>');
        });

        // Show the modal
        errorModal.modal('show');

        // Close error modal after 3 seconds
        setTimeout(function() {
            errorModal.modal('hide');
        }, 3000);
    }

    function validateMobileNumber(mobileNumber) {
        var regex = /^(\+?8801|01)[1-9]\d{8}$/;
        return regex.test(mobileNumber);
    }

    function validateWebsite(website) {
        try {
            new URL(website);
            return true;
        } catch (error) {
            return false;
        }
    }

    function validateEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        function filterMenuItems() {
            var searchInput = document.getElementById('searchInput').value.toLowerCase();
            var menuItems = document.querySelectorAll('#sidebarMenu li');

            menuItems.forEach(function(item) {
                var menuItemText = item.textContent.toLowerCase();
                if (menuItemText.includes(searchInput)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Event listener for search input
        document.getElementById('searchInput').addEventListener('input', filterMenuItems);

        // Make an AJAX call to fetch the sidebar menu
        $.ajax({
            type: 'GET',
            url: '{{ route("generateSidebarMenu") }}',
            success: function(response) {
                console.log(response);
                // Populate the sidebar menu with the received data
                if (response.sidebarMenu) {
                    response.sidebarMenu.forEach(function(menu) {
                        $('#sidebarMenu').append(
                            '<li><a href="' + menu.link + '"><i class="zmdi zmdi-dot-circle-alt"></i> ' + menu.name + '</a></li>'
                        );
                    });
                } else {
                    console.error('Error fetching sidebar menu:', response.error);
                }
            },
            error: function(error) {
                console.error('Error fetching sidebar menu:', error);
            }
        });
    });

    $(document).ready(function() {
        // Add a click event listener to the logout link
        $('#logout').click(function() {
            // Make an AJAX request to the logout endpoint
            $.ajax({
                type: 'POST',
                url: '{{ route("logout") }}', // Replace with your actual logout route
                data: {
                    _token: '{{ csrf_token() }}'
                }, // Include CSRF token
                success: function(response) {
                    // Redirect to the login page
                    window.location.href = '{{ route("login") }}';
                },
                error: function(error) {
                    console.error('Error logging out:', error);
                    // Redirect to the login page even if there's an error
                    window.location.href = '{{ route("login") }}';
                }
            });
        });
    });
</script>

<!--Start footer-->
<footer class="footer">
    <div class="container">
        <div class="text-center">
            Copyright © 2019 Bulona Admin
        </div>
    </div>
</footer>
<!--End footer-->
</div><!--End wrapper-->
</body>

<!-- Mirrored from codervent.com/bulona/demo/pages-user-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 26 Feb 2020 10:10:24 GMT -->

</html>
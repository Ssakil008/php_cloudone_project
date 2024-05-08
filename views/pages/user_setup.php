<?php
$title = 'User Setup';
include '../partials/header.php';
?>


<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2 align-items-center">
            <div class="col-sm-9">
                <h4 class="page-title">User Details</h4>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 text-right">
                <button type="button" id="addNewBtn" class="btn btn-primary btn-sm">Add New User</button>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <!--start overlay-->
    <div class="overlay toggle-menu"></div>
    <!--end overlay-->
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="modal_user" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_user"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form goes here -->

                <form id="userForm">
                    <?php
                    include '../../database/database.php';
                    $query = "SELECT * FROM roles";
                    $stmt = $pdo->query($query);
                    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <input type="hidden" name="userId" id="userId">
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" name="username" id="username" required placeholder="User Name" class="form-control input-shadow">
                            <span class="text-danger" id="username_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email ID</label>
                        <input type="email" id="email" name="email" name="email" required placeholder="E-mail" class="form-control input-shadow">
                        <span class="text-danger" id="email_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="number" name="mobile" required id="mobile" placeholder="Mobile Number" class="form-control input-shadow">
                        <span class="text-danger" id="mobile_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control input-shadow" name="role" required id="role">
                            <option value="" disabled selected>Select Role</option>
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= $role['id'] ?>"><?= $role['role'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger" id="role_error"></span>

                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control input-shadow" />
                        <span class="text-danger" id="password_error"></span>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="userSubmit"></button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>

<!-- simplebar js -->
<script src="../../assets/plugins/simplebar/js/simplebar.js"></script>
<!-- sidebar-menu js -->
<script src="../../assets/js/sidebar-menu.js"></script>
<!-- Custom scripts -->
<script src="../../assets/js/app-script.js"></script>
<script src="../../alertify/lib/alertify.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<!-- ColVis JavaScript file -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<!-- ColVis CSS file -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<!-- PDF export JavaScript (pdfMake) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<!-- Excel export JavaScript (JSZip) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- Excel export JavaScript (ExcelHTML5) -->
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var menuId = urlParams.get('id');

        $('#addNewBtn').click(function() {
            $('#userForm')[0].reset();
            $('#userSubmit').text('Submit');
            $('.modal-title').html('<strong>Add New User</strong>');
            $('#addUserModal .text-danger').text('');
        });

        $('#userSubmit').click(function(e) {
            var isValid = validateForm();
            if (isValid) {
                var formData = $('#userForm').serialize();
                console.log(formData);

                // Get the email from the form
                var email = document.getElementById('email').value;

                // Check email validation
                if (!validateEmail(email)) {
                    alertify.alert('E-mail is not valid');
                    return; // Prevent form submission if email is invalid
                }

                // Get the mobile number from the form
                var mobileNumber = document.getElementById('mobile').value;

                // Check mobile number validation
                if (!validateMobileNumber(mobileNumber)) {
                    alertify.alert('Mobile Number is not valid');
                    return; // Prevent form submission if mobile number is invalid
                }

                e.preventDefault(); // Prevent default form submission behavior

                // Check if userId exists in formData
                if (formData.indexOf('userId') !== -1) {
                    alertify.confirm('Are you sure?', function(e) {
                        if (e) {
                            submitFormData(formData);
                        }
                    });
                } else {
                    submitFormData(formData);
                }
            }
        });

        function submitFormData(formData) {
            $.ajax({
                type: 'POST',
                url: '../../database/upsertUser.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        $('#addUserModal').modal('hide');
                        $('#successmessage').text(response.message);
                        $('#successmodal').modal('show');
                        setTimeout(function() {
                            $('#successmodal').modal('hide');
                            window.location.reload();
                        }, 2000);
                    } else {
                        // Handle server-side errors
                        $('#addUserModal').modal('hide');
                        // Check if there's a message field in the response JSON
                        var errorMessage = response.message || 'An unknown error occurred.';

                        // Show error modal with the error message
                        showErrorModal([errorMessage]);

                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    $('#addUserModal').modal('hide');
                    var errorMessage = "An error occurred: " + xhr.status + " " + xhr.statusText;

                    // Extract the error message from the response JSON if available
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    // Show error modal with the error message
                    showErrorModal([errorMessage]);
                }
            });
        }

        // Function to validate the form
        function validateForm() {
            var isValid = true;
            $('.error-message').text(''); // Clear previous error messages

            // Validate input fields
            $('#userForm input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').text(fieldName + ' is required');
                    isValid = false;
                }
            });

            // Validate select fields
            $('#userForm select[required]').each(function() {
                if (!$(this).val()) {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').text(fieldName + ' is required');
                    isValid = false;
                }
            });

            return isValid;
        }

        $(document).on('click', '#addNewBtn, #edit-btn', function() {
            var userId = $(this).data('user-id');
            var buttonClicked = $(this).attr('id');
            if (buttonClicked === 'addNewBtn') {
                var action = 'create';
            } else {
                var action = 'edit';
            }

            console.log(menuId, buttonClicked, action, userId);
            // Make an AJAX call to check permissions
            $.ajax({
                url: '../../database/checkPermission.php',
                type: 'POST',
                data: {
                    menuId: menuId,
                    action: action
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (buttonClicked === 'addNewBtn') {
                            $('#addUserModal').modal('show');
                        } else if (buttonClicked === 'edit-btn') {
                            $.ajax({
                                type: 'POST',
                                url: '../../database/getUserData.php',
                                data: {
                                    userId: userId
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    if (response.hasOwnProperty('data')) {
                                        var user = response.data;
                                        $('#userForm')[0].reset();
                                        $('#addUserModal .text-danger').text('');
                                        $('#addUserModal').modal('show');
                                        $('#userId').val(user.id);
                                        $('#username').val(user.username);
                                        $('#email').val(user.email);
                                        $('#role').val(user.role_id);
                                        $('#mobile').val(user.mobile);
                                        $('#userSubmit').text('Update');
                                        $('.modal-title').html('<strong>Edit The User</strong>');
                                    } else {
                                        console.error('Invalid response structure:', response);
                                    }
                                },
                                error: function(error) {
                                    console.error('Error fetching user:', error);
                                }
                            });
                        } else {
                            // Permission denied, show a message or handle it as needed
                            alertify.alert('Permission denied');
                        }
                    } else {
                        // Permission denied, show a message or handle it as needed
                        alertify.alert('Permission denied');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking permission:', error);
                    // Handle error
                }
            });
        });

        var columns = [{
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "1"
            },
            {
                "data": "2"
            },
            {
                "data": "3"
            },
            {
                "data": "4"
            },
            {
                "data": "0",
                "render": function(data, type, row) {
                    return '<i class="icon-note mr-2 align-middle text-info" id="edit-btn" data-user-id="' + data + '"></i>';
                }
            },
            {
                "data": "0",
                "render": function(data, type, row) {
                    return '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-user-id="' + data + '"></i> ';
                }
            },
        ];

        // Check if user has edit permission, then add edit column
        // if (editPermission === 'yes') {
        //     columns.push({
        //         "data": "edit",
        //         "render": function(data, type, row) {
        //             return data ? data : '<i class="icon-note mr-2 align-middle text-info" id="edit-btn" data-user-id="' + row.id + '"></i>';
        //         }
        //     });
        // }

        // Check if user has delete permission, then add delete column
        // if (deletePermission === 'yes') {
        //     columns.push({
        //         "data": "delete",
        //         "render": function(data, type, row) {
        //             return data ? data : '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-user-id="' + row.id + '"></i> ';
        //         }
        //     });
        // }

        // Initialize DataTable with the dynamic columns
        $('#users-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "../../database/getAllUserData.php",
                "type": "GET",
            },
            "columns": columns,
            "dom": 'Bfrtip',
            "buttons": [
                ['pageLength'],
                {
                    extend: 'colvis',
                    text: 'Column Visibility'
                },
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                            extend: 'pdf',
                            text: 'PDF'
                        },
                        {
                            extend: 'excel',
                            text: 'Excel'
                        }
                    ]
                }
            ]
        });

        $('#users-table').on('click', '.delete-btn', function() {
            var id = $(this).data('user-id');
            var menuId = '{{ $menuId }}';
            console.log(id, menuId);
            alertify.confirm('Are you sure?', function(e) {
                if (e) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("deleteUserData") }}',
                        data: {
                            id: id,
                            menuId: menuId,
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#successmessage').text(response.message);
                                $('#successmodal').modal('show');
                                setTimeout(function() {
                                    $('#successmodal').modal('hide');
                                    window.location.href = '{{ route("user_setup") }}';
                                }, 2000);
                            } else {
                                $('#errormessage').text(response.message);
                                $('#errormodal').modal('show');
                                setTimeout(function() {
                                    $('#errormodal').modal('hide');
                                }, 2000);
                            }
                        },
                        error: function(error) {
                            $('#errormessage').text(response.message); // Show error message
                            $('#errormodal').modal('show');
                            setTimeout(function() {
                                $('#errormodal').modal('hide');
                            }, 2000);
                        }
                    });
                }
            });
        });
    });
</script>

<?php
include '../partials/footer.php';
?>
<?php
$title = 'Role';
include '../partials/header.php';
?>

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="content-header row">
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-lg-12 my-1">
                <div class="d-flex justify-content-between">
                    <button type="button" id="addNewBtn" class="btn btn-info btn-sm"><i class="icon-plus"></i> New Role</button>
                    <button type="button" id="addNewPermission" class="btn btn-info btn-sm" disabled><i class="fa fa-pencil-square-o"></i> Add Permission</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="card border">
                    <div class="card-header">
                        <i class="fa fa-user-o"></i> Role
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="roles-table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Role</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body content for roles -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border">
                    <div class="card-header">
                        <i class="icon-badge"></i> Permission
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="permission-table" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Can Read</th>
                                        <th>Can Create</th>
                                        <th>Can Edit</th>
                                        <th>Can Delete</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table body content for permissions -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--start overlay-->
    <div class="overlay toggle-menu"></div>
    <!--end overlay-->
</div>

<!-- New Role Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm">
                    <input type="hidden" name="roleId" id="roleId">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" name="role" required class="form-control" id="role" placeholder="Enter Role">
                        <span class="text-danger" id="role_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" required class="form-control" id="description" placeholder="Enter Description">
                        <span class="text-danger" id="description_error"></span>
                    </div>
                    <button type="button" id="roleSubmit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->

<!-- Permission Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permissionModalLabel">Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="permissionForm">
                    <?php
                    include '../../database/database.php';
                    $query = "SELECT * FROM menus";
                    $stmt = $pdo->query($query);
                    $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="form-group">
                        <input type="hidden" name="permissionId" id="permissionId">
                        <input type="hidden" name="role_id" id="role_id">
                        <label for="menu">Menu</label>
                        <select class="form-control input-shadow" name="menu" id="menu">
                            <option value="" disabled selected>Select Menu</option>
                            <?php foreach ($menus as $menu) : ?>
                                <option value="<?= $menu['id'] ?>"><?= $menu['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="form-check mr-3">
                            <input type="checkbox" class="form-check-input" id="readCheckbox" name="read">
                            <label class="form-check-label" for="readCheckbox">Read</label>
                        </div>
                        <div class="form-check mr-3">
                            <input type="checkbox" class="form-check-input" id="createCheckbox" name="create">
                            <label class="form-check-label" for="createCheckbox">Create</label>
                        </div>
                        <div class="form-check mr-3">
                            <input type="checkbox" class="form-check-input" id="editCheckbox" name="edit">
                            <label class="form-check-label" for="editCheckbox">Edit</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="deleteCheckbox" name="delete">
                            <label class="form-check-label" for="deleteCheckbox">Delete</label>
                        </div>
                    </div>
                    <button type="submit" id="permissionSubmit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->



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

<script>
    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var menuId = urlParams.get('id');

        $('#addNewBtn').click(function() {
            $('#addRoleForm')[0].reset();
            $('#roleSubmit').text('Submit');
            $('.modal-title').html('<strong>Add New Role</strong>');
            $('#newRoleModal .text-danger').text('');
        });

        $(document).on('click', '#addNewBtn, #addNewPermission, #permission-edit-btn, #role-edit-btn', function() {
            var buttonClicked = $(this).attr('id');
            var roleId = $(this).data('role-id');
            var permissionId = $(this).data('permission-id');
            if (buttonClicked === 'addNewBtn' || buttonClicked === 'addNewPermission') {
                var action = 'create';
            } else {
                var action = 'edit';
            }

            console.log(menuId, buttonClicked, roleId, permissionId, action);

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
                    console.log(roleId, buttonClicked);
                    if (response.success) {
                        // Check which button was clicked and show the corresponding modal
                        if (buttonClicked === 'addNewBtn') {
                            $('#newRoleModal').modal('show');
                        } else if (buttonClicked === 'addNewPermission') {
                            $('#permissionModal').modal('show');
                        } else if (buttonClicked === 'role-edit-btn') {
                            $.ajax({
                                type: 'POST',
                                url: '../../database/getRoleData.php',
                                data: {
                                    roleId: roleId
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    if (response.hasOwnProperty('data')) {
                                        var role = response.data;
                                        $('#addRoleForm')[0].reset();
                                        $('#newRoleModal .text-danger').text('');
                                        $('#newRoleModal').modal('show');
                                        $('#roleId').val(role.id);
                                        $('#role').val(role.role);
                                        $('#description').val(role.description);
                                        $('#roleSubmit').text('Update');
                                        $('.modal-title').html('<strong>Edit The Role</strong>');
                                    } else {
                                        console.error('Invalid response structure:', response);
                                    }
                                },
                                error: function(error) {
                                    console.error('Error fetching role:', error);
                                }
                            });
                        } else if (buttonClicked === 'permission-edit-btn') {
                            $.ajax({
                                type: 'POST',
                                url: '../../database/getPermissionData.php',
                                data: {
                                    permissionId: permissionId
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    if (response.hasOwnProperty('data')) {
                                        var permission = response.data;
                                        $('#permissionForm')[0].reset();
                                        $('#permissionModal .text-danger').text('');
                                        $('#permissionModal').modal('show');
                                        $('#permissionId').val(permission.id);
                                        $('#role_id').val(permission.role_id);
                                        $('#menu').val(permission.menu_id);
                                        $('#readCheckbox').prop('checked', permission.read === 'yes');
                                        $('#createCheckbox').prop('checked', permission.create === 'yes');
                                        $('#editCheckbox').prop('checked', permission.edit === 'yes');
                                        $('#deleteCheckbox').prop('checked', permission.delete === 'yes');
                                        $('#permissionSubmit').text('Update');
                                        $('.modal-title').html('<strong>Edit The Permission</strong>');
                                    } else {
                                        console.error('Invalid response structure:', response);
                                    }
                                },
                                error: function(error) {
                                    console.error('Error fetching permission:', error);
                                }
                            });
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

        $('#roleSubmit').click(function() {
            var isValid = validateForm();
            if (isValid) {
                var formData = $('#addRoleForm').serialize();
                console.log(formData);
                alertify.confirm('Are you sure?', function(e) {
                    if (e) {
                        $.ajax({
                            type: 'POST',
                            url: '../../database/upsertRole.php',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#newRoleModal').modal('hide');
                                    $('#successmessage').text(response.message);
                                    $('#successmodal').modal('show');
                                    setTimeout(function() {
                                        $('#successmodal').modal('hide');
                                        window.location.reload();
                                    }, 2000);
                                } else {
                                    $('#newRoleModal').modal('hide');
                                    showErrorModal([response.errors]);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', error);
                                $('#newRoleModal').modal('hide');
                                var errorMessage = "An error occurred: " + xhr.status + " " + xhr.statusText;
                                showErrorModal([errorMessage]);
                            }
                        });
                    }
                });
            }
        });

        // Function to validate the form
        function validateForm() {
            var isValid = true;
            $('.error-message').text(''); // Clear previous error messages
            $('#addRoleForm input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').text(fieldName + ' is required');
                    isValid = false;
                }
            });
            return isValid;
        }

        $.ajax({
            url: '../../database/getAllRoleData.php',
            type: 'POST',
            data: {
                menuId: menuId
            },
            dataType: 'json',
            success: function(response) {
                // Check if the response has the 'data' property
                if (response.hasOwnProperty('data')) {
                    var roles = response.data;
                    var serialNumber = 1;

                    // Iterate through roles and append rows to the table
                    $.each(roles, function(index, role) {
                        var row = '<tr>' +
                            '<td>' + serialNumber + '</td>' +
                            '<td>' + role.role + '</td>' +
                            '<td>' + role.description + '</td>' +
                            '<td>';


                        row += '<i class="icon-lock-open mr-2 permission-btn align-middle text-success" data-role-id="' + role.id + '"></i>';

                        row += '<i class="icon-note mr-2 align-middle text-info" id="role-edit-btn" data-role-id="' + role.id + '"></i>';


                        row += '<i class="fa fa-trash-o role-delete-btn align-middle text-danger" data-role-id="' + role.id + '"></i>';


                        row += '</td>' +
                            '</tr>';

                        $('#roles-table tbody').append(row);
                        serialNumber++;
                    });
                } else {
                    console.error('Invalid response structure:', response);
                }
            },
            error: function(error) {
                console.error('Error fetching roles:', error);
            }
        });

        $('#roles-table').on('click', '.role-delete-btn', function() {
            var id = $(this).data('role-id');
            var menuId = '{{ $menuId }}';
            console.log(id, menuId);
            alertify.confirm('Are you sure?', function(e) {
                if (e) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route("deleteRoleData") }}',
                        data: {
                            id: id,
                            menuId: menuId,
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#successmessage').text(response.message); // Show success message
                                $('#successmodal').modal('show');
                                setTimeout(function() {
                                    $('#successmodal').modal('hide');
                                    window.location.href = '{{ route("role") }}';
                                }, 2000);
                            } else {
                                $('#errormessage').text(response.message); // Show error message
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

        $(document).on('click', '.permission-btn', function() {
            // Enable the permission button
            $('#addNewPermission').prop('disabled', false);

            //Reset and Show the permission table
            $('#permission-table tbody').empty();
            $('#permission-table').show();


            // Store the ID of the clicked permission button
            roleId = $(this).data('role-id');

            // You can use this roleId for further operations
            console.log("Clicked permission button ID: ", roleId);

            // Fetch data for the permission table based on roleId using AJAX
            $.ajax({
                url: '../../database/getAllPermission.php',
                type: 'POST',
                data: {
                    menuId: menuId,
                    id: roleId,
                },
                dataType: 'json',
                success: function(response) {
                    // Check if the response has the 'data' property
                    if (response.hasOwnProperty('data')) {
                        var permissions = response.data;

                        $.each(permissions, function(index, permission) {
                            var row = '<tr>' +
                                '<td>' + permission.name + '</td>' +
                                '<td>' + permission.read + '</td>' +
                                '<td>' + permission.create + '</td>' +
                                '<td>' + permission.edit + '</td>' +
                                '<td>' + permission.delete + '</td>';

                            // Conditionally add edit and delete icons based on permission

                            row += '<td>' +
                                '<i class="icon-note mr-2 align-middle text-info" id="permission-edit-btn" data-permission-id="' + permission.id + '"></i>' +
                                '</td>';

                            row += '<td>' +
                                '<i class="fa fa-trash-o permission-delete-btn align-middle text-danger" data-permission-id="' + permission.id + '"></i>' +
                                '</td>';


                            row += '</tr>';

                            $('#permission-table tbody').append(row);
                        });
                    } else {
                        console.error('Invalid response structure:', response);
                    }
                },
                error: function(error) {
                    // Handle error response
                    console.error('Error:', error);
                    // Optionally, you can show an error message or perform other actions
                }
            });
        });

        $('#addNewPermission').click(function() {
            $('#permissionForm')[0].reset();
            $('#role_id').val(roleId);
            $('#permissionSubmit').text('Submit');
            $('.modal-title').html('<strong>Add New Permission</strong>');
            $('#permissionModal .text-danger').text('');
        });

        $('#permissionForm').submit(function(e) {
            e.preventDefault(); // Prevent form submission

            // Check if at least one permission checkbox is checked
            if (!$('#readCheckbox').is(':checked') &&
                !$('#createCheckbox').is(':checked') &&
                !$('#editCheckbox').is(':checked') &&
                !$('#deleteCheckbox').is(':checked')) {
                // Display error message and return
                alertify.alert("Please select at least one permission.");
            } else {

                // Prepare form data including role_id
                var formData = {
                    permissionId: $('#permissionId').val(),
                    role_id: $('#role_id').val(),
                    menu: $('#menu').val(),
                    read: $('#readCheckbox').is(':checked') ? 'yes' : 'no',
                    create: $('#createCheckbox').is(':checked') ? 'yes' : 'no',
                    edit: $('#editCheckbox').is(':checked') ? 'yes' : 'no',
                    delete: $('#deleteCheckbox').is(':checked') ? 'yes' : 'no'
                };

                console.log(formData);

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '../../database/insertPermission.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#permissionModal').modal('hide');
                            $('#successmessage').text(response.message);
                            $('#successmodal').modal('show');
                            setTimeout(function() {
                                $('#successmodal').modal('hide');
                                window.location.reload();
                            }, 2000);
                        } else {
                            // Handle server-side errors
                            $('#permissionModal').modal('hide');

                            // Check if there's a message field in the response JSON
                            var errorMessage = response.message || 'An unknown error occurred.';

                            // Show error modal with the error message
                            showErrorModal([errorMessage]);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        $('#permissionModal').modal('hide');
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
        });

        $('#permission-table').on('click', '.permission-delete-btn', function() {
            var id = $(this).data('permission-id');
            console.log(id, menuId);
            alertify.confirm('Are you sure?', function(e) {
                if (e) {
                    $.ajax({
                        type: 'POST',
                    url: '../../database/deletePermissionData.php',
                        data: {
                            id: id,
                            menuId: menuId,
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#successmessage').text(response.message); // Show success message
                                $('#successmodal').modal('show');
                                setTimeout(function() {
                                    $('#successmodal').modal('hide');
                                    window.location.reload();
                                }, 2000);
                            } else {
                            var errorMessage = response.message || 'An unknown error occurred.';
                            showErrorModal([errorMessage]);
                            }
                        },
                        error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        var errorMessage = "An error occurred: " + xhr.status + " " + xhr.statusText;
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showErrorModal([errorMessage]);
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
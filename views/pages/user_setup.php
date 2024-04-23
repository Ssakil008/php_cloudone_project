@extends('layouts.app')
@section('title','User Setup')
@section('content')

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2 align-items-center">
            <div class="col-sm-9">
                <h4 class="page-title">User Details</h4>
            </div>
            @if ($createPermission == 'yes')
            <div class="col-lg-3 col-md-3 col-sm-3 text-right">
                <button type="button" id="addNewBtn" class="btn btn-primary btn-sm">Add New User</button>
            </div>
            @endif
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
                        @if ($editPermission == 'yes')
                        <th>Edit</th>
                        @endif
                        @if ($deletePermission == 'yes')
                        <th>Delete</th>
                        @endif
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
                    @csrf
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
                        <input type="email" id="email" name="email" name="email" required placeholder="E-mail" value="{{old('email')}}" class="form-control input-shadow">
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
                            @foreach (\App\Models\Role::all() as $role)
                            <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- simplebar js -->
<script src="assets/plugins/simplebar/js/simplebar.js"></script>
<!-- sidebar-menu js -->
<script src="assets/js/sidebar-menu.js"></script>
<!-- Custom scripts -->
<script src="assets/js/app-script.js"></script>
<script src="alertify/lib/alertify.min.js"></script>
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
        $('#addNewBtn').click(function() {
            $('#userForm')[0].reset();
            $('#userSubmit').text('Submit');
            $('.modal-title').html('<strong>Add New User</strong>');
            $('#addUserModal .text-danger').text('');
        });
    });

    $(document).ready(function() {
        $('#userSubmit').click(function(e) {
            var isValid = validateForm();
            if (isValid) {
                var formData = $('#userForm').serialize();
                var roleId = $('#role').val(); // Get the selected role ID
                formData += '&roleId=' + roleId; // Append role ID to the form data
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
                url: '{{ route("upsertUser") }}',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#addUserModal').modal('hide');
                        $('#successmessage').text(response.message);
                        $('#successmodal').modal('show');
                        setTimeout(function() {
                            $('#successmodal').modal('hide');
                            window.location.href = '{{ route("user_setup") }}';
                        }, 2000);
                    } else {
                        // Handle server-side errors
                        $('#addUserModal').modal('hide');
                        showErrorModal([response.errors]);

                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    $('#addUserModal').modal('hide');
                    var errorMessage = "An error occurred: " + xhr.status + " " + xhr.statusText;
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
            var menuId = '{{ $menuId }}'; // Replace with the actual menuId you want to check permissions for
            var userId = $(this).data('user-id');
            var buttonClicked = $(this).attr('id');
            console.log(userId, buttonClicked);
            if (buttonClicked === 'addNewBtn') {
                var action = 'create';
            } else {
                var action = 'edit';
            }
            // Make an AJAX call to check permissions
            $.ajax({
                url: '{{ route("checkPermission") }}',
                type: 'POST',
                data: {
                    menuId: menuId,
                    action: action
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        if (buttonClicked === 'addNewBtn') {
                            $('#addUserModal').modal('show');
                        } else if (buttonClicked === 'edit-btn') {
                            $.ajax({
                                type: 'GET',
                                url: '{{ url("getUserData") }}/' + userId,
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
                                        $('#role').val(user.user_role.role.id);
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
    });

    $(document).ready(function() {
        // Fetch entries data from the server
        // $.ajax({
        //     type: 'GET',
        //     url: '{{ route("getAllUserData") }}',
        //     success: function(response) {
        //         // Check if the response has the 'data' property
        //         if (response.hasOwnProperty('data')) {
        //             var users = response.data;
        //             var serialNumber = 1;

        //             // Iterate through entries and append rows to the table
        //             $.each(users, function(index, user) {
        //                 var row = '<tr>' +
        //                     '<td>' + serialNumber + '</td>' +
        //                     '<td>' + user.email + '</td>' +
        //                     '<td>' + user.mobile + '</td>' +
        //                     '<td>' + user.user_role.role.role + '</td>' +
        //                     '<td>' +
        //                     '<i class="icon-note mr-2 edit-btn align-middle text-info" data-user-id="' + user.id + '"></i>' +
        //                     '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-user-id="' + user.id + '"></i>' +
        //                     '</td>' +
        //                     '</tr>';

        //                 $('#users-table tbody').append(row);
        //                 serialNumber++;
        //             });
        //         } else {
        //             console.error('Invalid response structure:', response);
        //         }
        //     },
        //     error: function(error) {
        //         console.error('Error fetching entries:', error);
        //     }
        // });

        var menuId = '{{ $menuId }}';
        var editPermission = '{{ $editPermission }}';
        var deletePermission = '{{ $deletePermission }}';
        // Define DataTable columns dynamically based on permissions
        var columns = [{
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "username"
            },
            {
                "data": "email"
            },
            {
                "data": "mobile"
            },
            {
                "data": "role"
            }
        ];

        // Check if user has edit permission, then add edit column
        if (editPermission === 'yes') {
            columns.push({
                "data": "edit",
                "render": function(data, type, row) {
                    return data ? data : '<i class="icon-note mr-2 align-middle text-info" id="edit-btn" data-user-id="' + row.id + '"></i>';
                }
            });
        }

        // Check if user has delete permission, then add delete column
        if (deletePermission === 'yes') {
            columns.push({
                "data": "delete",
                "render": function(data, type, row) {
                    return data ? data : '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-user-id="' + row.id + '"></i> ';
                }
            });
        }

        // Initialize DataTable with the dynamic columns
        $('#users-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('getAllUserData')}}",
                "type": "POST",
                "data": {
                    menuId: menuId
                }
            },
            "columns": columns,
            "dom": 'Bfrtip', // Custom dom structure with buttons
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

        // $('#users-table').on('click', '.edit-btn', function() {
        //     var userId = $(this).data('user-id');
        //     console.log(userId);

        //     $.ajax({
        //         type: 'GET',
        //         url: '{{ url("getUserData") }}/' + userId,
        //         success: function(response) {
        //             console.log(response);
        //             if (response.hasOwnProperty('data')) {
        //                 var user = response.data;
        //                 $('#userForm')[0].reset();
        //                 $('#addUserModal .text-danger').text('');
        //                 $('#addUserModal').modal('show');
        //                 $('#userId').val(user.id);
        //                 $('#username').val(user.username);
        //                 $('#email').val(user.email);
        //                 $('#role').val(user.user_role.role.id);
        //                 $('#mobile').val(user.mobile);
        //                 $('#userSubmit').text('Update');
        //                 $('.modal-title').html('<strong>Edit The User</strong>');
        //             } else {
        //                 console.error('Invalid response structure:', response);
        //             }
        //         },
        //         error: function(error) {
        //             console.error('Error fetching user:', error);
        //         }
        //     });
        // });

        $('#users-table').on('click', '.delete-btn', function() {
            var id = $(this).data('user-id');
            var menuId = '{{ $menuId }}';
            console.log(id, menuId);
            alertify.confirm('Are you sure?', function(e) {
                if (e) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route("deleteUserData") }}',
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
                                    window.location.href = '{{ route("user_setup") }}';
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
    });
</script>
@endsection
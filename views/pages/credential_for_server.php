@extends('layouts.app')
@section('title','Credential For Server')
@section('content')

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title">Credential Details</h4>
            </div>
            @if ($createPermission == 'yes')
            <div class="col-lg-3 col-md-3 col-sm-3 text-right">
                <button type="button" id="addNewBtn" class="btn btn-primary btn-sm">Add New User</button>
            </div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="entries-table">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>URL</th>
                        <th>IP Address</th>
                        <th>Username</th>
                        <th>Password</th>
                        @if ($editPermission == 'yes')
                        <th>Edit</th>
                        @endif
                        @if ($deletePermission == 'yes')
                        <th>Delete</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate table rows dynamically using PHP or JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    <!--start overlay-->
    <div class="overlay toggle-menu"></div>
    <!--end overlay-->
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form goes here -->

                <form id="myForm">
                    @csrf
                    <input type="hidden" name="entryId" id="entryId">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label for="credential_for">Name</label>
                                <input type="text" id="credential_for" name="credential_for" required placeholder="Name" value="{{ old('name') }}" class="form-control input-shadow">
                                <span class="text-danger" id="credential_for_error"></span>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label for="username">User Name</label>
                                <input type="text" name="username" required id="username" placeholder="User Name" value="{{old('username')}}" class="form-control input-shadow">
                                <span class="text-danger" id="username_error"></span>
                            </div>
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
                        <label for="url">Website Name</label>
                        <input type="url" name="url" required id="url" placeholder="Website Name" value="{{old('url')}}" class="form-control input-shadow">
                        <span class="text-danger" id="url_error"></span>
                    </div>


                    <div class="form-group">
                        <label for="ip_address">IP Address</label>
                        <input type="text" id="ip_address" name="ip_address" required placeholder="e.g., 192.168.1.1" value="{{old('ip_address')}}" class="form-control input-shadow">
                        <span class="text-danger" id="ip_address_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" name="password" required id="password" placeholder="Password" class="form-control input-shadow" />
                        <span class="text-danger" id="password_error"></span>
                    </div>

                    <!-- Add other form fields as needed -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitBtn"></button>
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
        // Clear form fields when the "Add New" button is clicked
        $('#addNewBtn').click(function() {
            $('#myForm')[0].reset();
            $('#submitBtn').text('Submit');
            $('.modal-title').html('<strong>Add New User</strong>');
            $('#myModal .text-danger').text('');
        });

        $(document).on('click', '#addNewBtn, #edit-btn', function() {
            var menuId = '{{ $menuId }}'; // Replace with the actual menuId you want to check permissions for
            var entryId = $(this).data('entry-id');
            var buttonClicked = $(this).attr('id');
            console.log(entryId, buttonClicked);
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
                        // Show the modal
                        if (buttonClicked === 'addNewBtn') {
                            $('#myModal').modal('show');
                        } else if (buttonClicked === 'edit-btn') {
                            $.ajax({
                                type: 'GET',
                                url: '{{ url("get-entry") }}/' + entryId,
                                success: function(response) {
                                    // Check if the response has the 'data' property
                                    if (response.hasOwnProperty('data')) {
                                        var entry = response.data;

                                        // Populate the modal with the entry data
                                        $('#myModal .text-danger').text('');
                                        $('#myModal').modal('show');
                                        $('#entryId').val(entry.id);
                                        $('#credential_for').val(entry.credential_for);
                                        $('#email').val(entry.email);
                                        $('#mobile').val(entry.mobile);
                                        $('#url').val(entry.url);
                                        $('#ip_address').val(entry.ip_address);
                                        $('#username').val(entry.username);
                                        $('#password').val(entry.password);
                                        $('#submitBtn').text('Update');
                                        $('.modal-title').html('<strong>Edit The User</strong>');
                                    } else {
                                        console.error('Invalid response structure:', response);
                                    }
                                },
                                error: function(error) {
                                    console.error('Error fetching entry:', error);
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
        $('#submitBtn').click(function(e) {
            var isValid = validateForm();
            if (isValid) {
                // Create a new FormData object
                var formData = $('#myForm').serialize();

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

                // Get the website from the form
                var website = document.getElementById('url').value;

                // Check website validation
                if (!validateWebsite(website)) {
                    alertify.alert('URL is not valid');
                    return; // Prevent form submission if email is invalid
                }

                e.preventDefault(); // Prevent default form submission behavior

                alertify.confirm('Are you sure?', function(e) {
                    if (e) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route("upsertCredential") }}',
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    $('#myModal').modal('hide');
                                    $('#successmessage').text(response.message);
                                    $('#successmodal').modal('show');
                                    setTimeout(function() {
                                        $('#successmodal').modal('hide');
                                        window.location.href = '{{ route("credential_for_server") }}';
                                    }, 2000);
                                } else {
                                    $('#myModal').modal('hide');
                                    showErrorModal([response.errors]);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', error);
                                $('#myModal').modal('hide');
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
            $('#myForm input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').text(fieldName + ' is required');
                    isValid = false;
                }
            });
            return isValid;
        }
    });

    $(document).ready(function() {
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
                "data": "credential_for"
            },
            {
                "data": "email"
            },
            {
                "data": "mobile"
            },
            {
                "data": "url"
            },
            {
                "data": "ip_address"
            },
            {
                "data": "username"
            },
            {
                "data": "password"
            }
        ];

        // Check if user has edit permission, then add edit column
        if (editPermission === 'yes') {
            columns.push({
                "data": "edit",
                "render": function(data, type, row) {
                    if (!data) {
                        return '<i class="icon-note mr-2 align-middle text-info" id="edit-btn" data-entry-id="' + row.id + '"></i>';
                    } else {
                        return data;
                    }
                }
            });
        }

        // Check if user has delete permission, then add delete column
        if (deletePermission === 'yes') {
            columns.push({
                "data": "delete",
                "render": function(data, type, row) {
                    if (!data) {
                        return '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-entry-id="' + row.id + '"></i>';
                    } else {
                        return data;
                    }
                }
            });
        }

        // Initialize DataTable with the dynamic columns
        $('#entries-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('get-entries')}}",
                "type": "POST",
                "data": {
                    menuId: menuId
                },
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

        // $('#entries-table').on('click', '.edit-btn', function() {
        //     // Retrieve entry ID from the clicked button
        //     var entryId = $(this).data('entry-id');
        //     console.log(entryId);

        //     // Make an AJAX request to get the entry data based on the ID
        //     $.ajax({
        //         type: 'GET',
        //         url: '{{ url("get-entry") }}/' + entryId,
        //         success: function(response) {
        //             // Check if the response has the 'data' property
        //             if (response.hasOwnProperty('data')) {
        //                 var entry = response.data;

        //                 // Populate the modal with the entry data
        //                 $('#myModal .text-danger').text('');
        //                 $('#myModal').modal('show');
        //                 $('#entryId').val(entry.id);
        //                 $('#credential_for').val(entry.credential_for);
        //                 $('#email').val(entry.email);
        //                 $('#mobile').val(entry.mobile);
        //                 $('#url').val(entry.url);
        //                 $('#ip_address').val(entry.ip_address);
        //                 $('#username').val(entry.username);
        //                 $('#password').val(entry.password);
        //                 $('#submitBtn').text('Update');
        //                 $('.modal-title').html('<strong>Edit The User</strong>');
        //             } else {
        //                 console.error('Invalid response structure:', response);
        //             }
        //         },
        //         error: function(error) {
        //             console.error('Error fetching entry:', error);
        //         }
        //     });
        // });

        $('#entries-table').on('click', '.delete-btn', function() {
            var id = $(this).data('entry-id');
            var menuId = '{{ $menuId }}';
            console.log(id, menuId);
            alertify.confirm('Are you sure?', function(e) {
                if (e) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route("deleteCredential") }}',
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
                                    window.location.href = '{{ route("credential_for_server") }}';
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
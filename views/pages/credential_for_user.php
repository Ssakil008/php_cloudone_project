@extends('layouts.app')
@section('title','Credential For User')
@section('content')

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2 align-items-center">
            <div class="col-sm-9">
                <h4 class="page-title">Credential For User</h4>
            </div>
            @if ($createPermission == 'yes')
            <div class="col-lg-3 col-md-3 col-sm-3 text-right">
                <button type="button" id="addNewBtn" class="btn btn-primary btn-sm">Add Credential</button>
            </div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Password</th>
                        <th>More Info</th>
                        @if ($editPermission == 'yes')
                        <th>Edit</th>
                        @endif
                        @if ($deletePermission == 'yes')
                        <th>Delete</th>
                        @endif
                        <!-- Thead will be generated dynamically by DataTables -->
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
                <form id="dynamicForm">
                    @csrf
                    <input type="hidden" name="userId" id="userId">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required placeholder="Name" value="{{ old('name') }}" class="form-control input-shadow">
                        <span class="text-danger" id="name_error"></span>
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
                        <label for="password">Password</label>
                        <input type="text" name="password" required id="password" placeholder="Password" class="form-control input-shadow" />
                        <span class="text-danger" id="password_error"></span>
                    </div>

                    <button type="button" class="btn btn-info btn-sm" id="addField">
                        <i class="icon-plus"></i> Add Field
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="removeField">
                        <i class="icon-minus"></i> Remove Field
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info btn-sm" id="userSubmit"></button>
                <a href=""></a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="more_info">
    <div class="modal-dialog">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
                <h5 class="modal-title">Additional Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="additonal_information">
                    <table id="more_info_table" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th style="text-align: center; vertical-align: middle; border: 1px solid black;">Field Name</th>
                            <th style="text-align: center; vertical-align: middle; border: 1px solid black;">Field Value</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <!-- <button type="button" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save changes</button> -->
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
            $('#dynamicForm')[0].reset();
            $(".dynamic-field").remove();
            $('#userSubmit').text('Submit');
            $('.modal-title').html('<strong>Add Credential</strong>');
            $('#addUserModal .text-danger').text('');
        });

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
                        // Show the modal
                        if (buttonClicked === 'addNewBtn') {
                            $('#addUserModal').modal('show');
                        } else if (buttonClicked === 'edit-btn') {
                            $.ajax({
                                type: 'GET',
                                url: '{{ url("getCredentialForUserData") }}/' + userId,
                                success: function(response) {
                                    console.log(response);
                                    if (response.hasOwnProperty('data')) {
                                        var user = response.data;
                                        $('#dynamicForm')[0].reset();
                                        $(".dynamic-field").remove();
                                        $('#addUserModal .text-danger').text('');
                                        $('#addUserModal').modal('show');
                                        $('#userId').val(user.id);
                                        $('#name').val(user.name);
                                        $('#email').val(user.email);
                                        $('#mobile').val(user.mobile);
                                        $('#password').val(user.password);
                                        $('#userSubmit').text('Update');
                                        $('.modal-title').html('<strong>Edit The Credential</strong>');
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

        $("#removeField").click(function() {
            $(".dynamic-field:last").remove();
        });

        $("#addField").click(function() {
            // Create a new row for the dynamic fields
            var newRow = $('<div class="row dynamic-field">');

            // Create the "Field Name" input field
            var fieldNameInput = $('<input>').attr({
                'type': 'text',
                'class': 'form-control',
                'name': 'fields[][field_name]',
                'placeholder': 'Field Name'
            });

            // Create the "Field Value" input field
            var fieldValueInput = $('<input>').attr({
                'type': 'text',
                'class': 'form-control',
                'name': 'fields[][field_value]',
                'placeholder': 'Field Value'
            });

            // Append the "Field Name" and "Field Value" input fields to the new row
            newRow.append($('<div class="form-group col-md-6">').append('<label>Additional Field</label>').append(fieldNameInput));
            newRow.append($('<div class="form-group col-md-6" style="margin: 25px 0px;">').append(fieldValueInput));

            // Insert the new row before the "Add Field" button
            $("#addField").before(newRow);
        });

        $("#userSubmit").click(function(e) {
            var isValid = validateForm();
            if (isValid) {
                // Create a new FormData object
                var formData = new FormData($('#dynamicForm')[0]);

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

                alertify.confirm('Are you sure?', function(e) {
                    if (e) {
                        // AJAX request to submit form data
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('storeDynamicData') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log(response);
                                $('#addUserModal').modal('hide');
                                $('#successmessage').text(response.message);
                                $('#successmodal').modal('show');
                                setTimeout(function() {
                                    $('#successmodal').modal('hide');
                                    // Redirect to user setup page
                                    window.location.replace('{{ route("credential_for_user") }}');
                                }, 2000);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                var errorMessage = "Failed to process the request.";
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                $('#addUserModal').modal('hide');
                                $('#errormessage').text(errorMessage);
                                $('#errormodal').modal('show');
                                setTimeout(function() {
                                    $('#errormodal').modal('hide');
                                }, 2000);
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

            // Validate input fields
            $('#dynamicForm input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').text(fieldName + ' is required');
                    isValid = false;
                }
            });

            // Validate select fields
            $('#dynamicForm select[required]').each(function() {
                if (!$(this).val()) {
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
        var columns = [{
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                "data": "name"
            },
            {
                "data": "email"
            },
            {
                "data": "mobile"
            },
            {
                "data": "password"
            },
            {
                "data": "information",
                // "render": function(data, type, row) {
                //     return data ? data : '<a href="/additional_information/' + row.id + '" class="show-info align-middle text-info">Show</a>';
                // }
                "render": function(data, type, row) {
                    return data ? data : '<a href="#" class="show-info align-middle text-info" data-user-id="' + row.id + row.name + '">Show</a> ';
                }
            },

        ];

        if (editPermission === 'yes') {
            columns.push({
                "data": "edit",
                "render": function(data, type, row) {
                    return data ? data : '<i class="icon-note mr-2 align-middle text-info" id="edit-btn" data-user-id="' + row.id + '"></i>';
                }
            });
        }

        if (deletePermission === 'yes') {
            columns.push({
                "data": "delete",
                "render": function(data, type, row) {
                    return data ? data : '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-user-id="' + row.id + '"></i> ';
                }
            });
        }

        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('getDynamicData')}}",
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

        $('#dataTable').on('click', '.delete-btn', function() {
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
                        url: '{{ route("deleteCredentialForUserData") }}',
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
                                    window.location.href = '{{ route("credential_for_user") }}';
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

        // $('#dataTable').on('click', '.edit-btn', function() {
        //     var userId = $(this).data('user-id');
        //     console.log(userId);

        //     $.ajax({
        //         type: 'GET',
        //         url: '{{ url("getCredentialForUserData") }}/' + userId,
        //         success: function(response) {
        //             console.log(response);
        //             if (response.hasOwnProperty('data')) {
        //                 var user = response.data;
        //                 $('#dynamicForm')[0].reset();
        //                 $(".dynamic-field").remove();
        //                 $('#addUserModal .text-danger').text('');
        //                 $('#addUserModal').modal('show');
        //                 $('#userId').val(user.id);
        //                 $('#name').val(user.name);
        //                 $('#email').val(user.email);
        //                 $('#mobile').val(user.mobile);
        //                 $('#password').val(user.password);
        //                 $('#userSubmit').text('Update');
        //                 $('.modal-title').html('<strong>Edit The Credential</strong>');
        //             } else {
        //                 console.error('Invalid response structure:', response);
        //             }
        //         },
        //         error: function(error) {
        //             console.error('Error fetching user:', error);
        //         }
        //     });
        // });

        $(document).on('click', '.show-info', function() {
            var userId = $(this).data('user-id'); // Getting user id from data attribute
            var matches = userId.match(/^(\d+)([^\d]+)$/); // Using regex to extract id and name
            if (matches && matches.length === 3) {
                var id = matches[1]; // Extracting id from matches
                var name = matches[2]; // Extracting name from matches

                console.log(userId);
                console.log(id);
                console.log(name);
                $.ajax({
                    type: 'GET',
                    url: '{{ url("getMoreInfo") }}/' + id,
                    success: function(response) {
                        if (response.hasOwnProperty('data')) {
                            var users = response.data;
                            var table = $('#more_info_table');
                            // Remove all rows from the table
                            $("#more_info_table").find("td").remove();

                            // Iterate over the received data and populate table rows
                            $.each(users, function(index, row) {
                                var tableRow = $('<tr>');

                                // Create table cells for field_name and field_value
                                var fieldNameCell = $('<td>').css({
                                    'font - family': 'Roboto',
                                    'color': '#000',
                                    'text-align': 'center',
                                    'vertical-align': 'middle',
                                    'border': '1px solid black',
                                }).html(row.field_name);

                                var fieldValueCell = $('<td>').css({
                                    'font - family': 'Roboto',
                                    'color': '#000',
                                    'text-align': 'center',
                                    'vertical-align': 'middle',
                                    'border-bottom': '1px solid black',
                                    'border-right': '1px solid black',
                                }).html(row.field_value);

                                // Append the cells to the row
                                tableRow.append(fieldNameCell);
                                tableRow.append(fieldValueCell);

                                // Append the row to the table
                                $('#more_info_table').append(tableRow);
                            });

                            // Show the modal after populating the table
                            $("#more_info").modal("show");
                        };
                    },

                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('Error fetching additional information:', error);
                        var errorMessage = "Failed to process the request.";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        // Display error message
                        $('#errormessage').text(errorMessage);
                        $('#errormodal').modal('show');
                        setTimeout(function() {
                            $('#errormodal').modal('hide');
                        }, 2000);
                    }
                });
            } else {
                console.log("Invalid userId format: " + userId);
            }
        });
    });
</script>



@endsection
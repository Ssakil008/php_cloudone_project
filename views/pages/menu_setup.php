@extends('layouts.app')
@section('title','Menu Setup')
@section('content')

<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row pt-2 pb-2 align-items-center">
            <div class="col-sm-9">
                <h4 class="page-title">Menu Details</h4>
            </div>
            @if ($createPermission == 'yes')
            <div class="col-lg-3 col-md-3 col-sm-3 text-right">
                <button type="button" id="addNewBtn" class="btn btn-primary btn-sm">Add New Menu</button>
            </div>
            @endif
        </div>


        <div class="table-responsive">
            <table class="table table-bordered" id="menu-table">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Menu Name</th>
                        <th>Menu Link</th>
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

<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="modal_menu" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_menu"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form goes here -->

                <form id="menuForm">
                    @csrf
                    <input type="hidden" name="menuId" id="menuId">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" name="name" id="name" required placeholder="Name" class="form-control input-shadow">
                            <span class="text-danger" id="name_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="link">Link</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" name="link" id="link" required placeholder="Link" class="form-control input-shadow">
                            <span class="text-danger" id="link_error"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="menuSubmit"></button>
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
            $('#menuForm')[0].reset();
            $('#menuSubmit').text('Submit');
            $('.modal-title').html('<strong>Add New Menu</strong>');
            $('#addMenuModal .text-danger').text('');
        });
    });

    $(document).ready(function() {

        $('#menuSubmit').click(function(e) {
            var isValid = validateForm();
            if (isValid) {
                var formData = $('#menuForm').serialize();
                console.log(formData);

                e.preventDefault(); // Prevent default form submission behavior

                // Check if menuId exists in formData
                if (formData.indexOf('menuId') !== -1) {
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
                url: '{{ route("upsertMenu") }}',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#addMenuModal').modal('hide');
                        $('#successmessage').text(response.message);
                        $('#successmodal').modal('show');
                        setTimeout(function() {
                            $('#successmodal').modal('hide');
                            window.location.href = '{{ route("menu_setup") }}';
                        }, 2000);
                    } else {
                        // Handle server-side errors
                        $('#addMenuModal').modal('hide');
                        showErrorModal(response.errors);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    $('#addMenuModal').modal('hide');
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
            $('#menuForm input[required]').each(function() {
                if ($(this).val().trim() === '') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').text(fieldName + ' is required');
                    isValid = false;
                }
            });

            // Validate select fields
            $('#menuForm select[required]').each(function() {
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
            var menu_Id = $(this).data('menu-id');
            var buttonClicked = $(this).attr('id');
            console.log(menuId, buttonClicked);
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
                            $('#addMenuModal').modal('show');
                        } else if (buttonClicked === 'edit-btn') {
                            $.ajax({
                                type: 'GET',
                                url: '{{ url("getMenuData") }}/' + menu_Id,
                                success: function(response) {
                                    console.log(response);
                                    if (response.hasOwnProperty('data')) {
                                        var menu = response.data;
                                        $('#menuForm')[0].reset();
                                        $('#addMenuModal .text-danger').text('');
                                        $('#addMenuModal').modal('show');
                                        $('#menuId').val(menu.id);
                                        $('#name').val(menu.name);
                                        $('#link').val(menu.link);
                                        $('#menuSubmit').text('Update');
                                        $('.modal-title').html('<strong>Edit The Menu</strong>');
                                    } else {
                                        console.error('Invalid response structure:', response);
                                    }
                                },
                                error: function(error) {
                                    console.error('Error fetching menu:', error);
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
                "data": "name"
            },
            {
                "data": "link"
            },
        ];

        // Check if menu has edit permission, then add edit column
        if (editPermission === 'yes') {
            columns.push({
                "data": "edit",
                "render": function(data, type, row) {
                    return data ? data : '<i class="icon-note mr-2 align-middle text-info" id="edit-btn" data-menu-id="' + row.id + '"></i>';
                }
            });
        }

        // Check if menu has delete permission, then add delete column
        if (deletePermission === 'yes') {
            columns.push({
                "data": "delete",
                "render": function(data, type, row) {
                    return data ? data : '<i class="fa fa-trash-o delete-btn align-middle text-danger" data-menu-id="' + row.id + '"></i> ';
                }
            });
        }

        // Initialize DataTable with the dynamic columns
        $('#menu-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('getAllMenuData')}}",
                "type": "POST",
                "data": {
                    menuId: menuId
                }
            },
            "columns": columns,
        });

        $('#menu-table').on('click', '.delete-btn', function() {
            var id = $(this).data('menu-id');
            var menuId = '{{ $menuId }}';
            console.log(id, menuId);
            alertify.confirm('Are you sure?', function(e) {
                if (e) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route("deleteMenuData") }}',
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
                                    window.location.href = '{{ route("menu_setup") }}';
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
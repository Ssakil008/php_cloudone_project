<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/bulona/demo/authentication-signup.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 26 Feb 2020 10:09:20 GMT -->

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>Bulona - Bootstrap Admin Dashboard Template</title>
   <!--favicon-->
   <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
   <!-- Bootstrap core CSS-->
   <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
   <!-- animate CSS-->
   <link href="assets/css/animate.css" rel="stylesheet" type="text/css" />
   <!-- Icons CSS-->
   <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
   <!-- Custom Style-->
   <link href="assets/css/app-style.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/default.min.css" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

</head>

<body>

   <!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming">
      <div class="loader-wrapper-outer">
         <div class="loader-wrapper-inner">
            <div class="loader"></div>
         </div>
      </div>
   </div>
   <!-- end loader -->

   <!-- Start wrapper-->
   <div id="wrapper">

      <div class="card card-authentication1 mx-auto my-4">
         <div class="card-body">
            <div class="card-content p-2">
               <div class="text-center">
                  <img src="assets/images/logo-icon.png" alt="logo icon">
               </div>
               <div class="card-title text-uppercase text-center py-3">Sign Up</div>
               <form class="register_form" id="register_form">
                  @csrf
                  <div class="form-group">
                     <label for="username" class="sr-only">User Name</label>
                     <div class="position-relative has-icon-right">
                        <input type="text" name="username" id="username" required placeholder="User Name" class="form-control input-shadow">
                        <span class="text-danger" id="username_error"></span>
                        <div class="form-control-position">
                           <i class="zmdi zmdi-email"></i>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="email" class="sr-only">Email ID</label>
                     <div class="position-relative has-icon-right">
                        <input type="email" name="email" id="email" required placeholder="E-mail" class="form-control input-shadow">
                        <span class="text-danger" id="email_error"></span>
                        <div class="form-control-position">
                           <i class="zmdi zmdi-email"></i>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="mobile" class="sr-only">Mobile Number</label>
                     <div class="position-relative has-icon-right">
                        <input type="number" name="mobile" required id="mobile" placeholder="Mobile Number" class="form-control input-shadow">
                        <span class="text-danger" id="mobile_error"></span>
                        <div class="form-control-position">
                           <i class="zmdi zmdi-account material-icons-name"></i>
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="password" class="sr-only">Password</label>
                     <div class="position-relative has-icon-right">
                        <input type="password" name="password" required id="password" placeholder="Password" class="form-control input-shadow" />
                        <span class="text-danger" id="password_error"></span>
                        <div class="form-control-position">
                           <i class="zmdi zmdi-lock"></i>
                        </div>
                     </div>
                  </div>

                  <button type="button" id="submit-btn" class="btn btn-primary btn-block waves-effect waves-light">Sign Up</button>

                  <div class="text-center mt-3">Sign Up With</div>

                  <div class="form-row mt-4">
                     <div class="form-group mb-0 col-6">
                        <button type="button" class="btn bg-facebook text-white btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
                     </div>
                     <div class="form-group mb-0 col-6 text-right">
                        <button type="button" class="btn bg-twitter text-white btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
                     </div>
                  </div>

               </form>
            </div>
         </div>
         <div class="card-footer text-center py-3">
            <p class="text-dark mb-0">Already have an account? <a href="login"> Sign In here</a></p>
         </div>
      </div>
      <!--Start Back To Top Button-->
      <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
      <!--End Back To Top Button-->
   </div><!--wrapper-->

   <!--Success  Modal -->
   <div class="modal fade" id="successmodal">
      <div class="modal-dialog">
         <div class="modal-content border-success">
            <div class="modal-header bg-success">
               <h5 class="modal-title text-white">Successful</h5>
               <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body text-center" id="successmessage">
            </div>
            <div class="modal-footer">
            </div>
         </div>
      </div>
   </div>
   <!--End Modal -->

   <!--Error Modal -->
   <div class="modal fade" id="errormodal">
      <div class="modal-dialog">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title text-white">Error</h5>
               <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body text-center" id="errormessage">
            </div>
            <div class="modal-footer">
            </div>
         </div>
      </div>
   </div>
   <!--End Modal -->

   <!-- Bootstrap core JavaScript-->
   <script src="assets/js/jquery.min.js"></script>
   <script src="assets/js/popper.min.js"></script>
   <script src="assets/js/bootstrap.min.js"></script>

   <!-- sidebar-menu js -->
   <script src="assets/js/sidebar-menu.js"></script>

   <!-- Custom scripts -->
   <script src="assets/js/app-script.js"></script>

   <!-- Add this script at the end of your HTML file, before </body> -->
   <script>
      $(document).ready(function() {

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

         // Set up jQuery to include the CSRF token in all AJAX requests
         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         $('#submit-btn').click(function() {
            var isValid = validateForm();
            if (isValid) {
               // Fetch the roleId dynamically
               fetchRoleIdAndSubmitForm();
            }
         });

         function fetchRoleIdAndSubmitForm() {
            $.ajax({
               type: 'GET',
               url: '{{ route("fetchRoleId") }}', // Assuming you have a route to fetch the roleId
               success: function(response) {
                  console.log(response);
                  if (response.success) {
                     var roleId = response.roleId;
                     var formData = $('#register_form').serialize();
                     formData += '&roleId=' + roleId; // Append fetched roleId to the form data
                     console.log(formData);

                     $.ajax({
                        type: 'POST',
                        url: '{{ route("upsertUser") }}',
                        data: formData,
                        success: function(response) {
                           if (response.success) {
                              $('#successmessage').text('Registration Successful');
                              $('#successmodal').modal('show');
                              setTimeout(function() {
                                 $('#successmodal').modal('hide');
                              }, 1000);
                              autoLoginAndRedirect($('#email').val(), $('#password').val());
                           } else {
                              // Handle server-side errors
                              showErrorModal([response.errors]);
                           }
                        },
                        error: function(xhr, status, error) {
                           console.error('AJAX error:', error);
                           var errorMessage = "An error occurred: " + xhr.status + " " + xhr.statusText;
                           showErrorModal([errorMessage]);
                        }
                     });
                  } else {
                     console.error('Error fetching roleId:', response.message);
                     $('#errormessage').text('Registration Failed');
                     $('#errormodal').modal('show');
                     setTimeout(function() {
                        $('#errormodal').modal('hide');
                     }, 2000);
                  }
               },
               error: function(error) {
                  console.error('Error fetching roleId:', error);
                  $('#errormessage').text('Registration Failed');
                  $('#errormodal').modal('show');
                  setTimeout(function() {
                     $('#errormodal').modal('hide');
                  }, 2000);
               }
            });
         }

      });

      // Function to validate the form
      function validateForm() {
         var isValid = true;
         $('.error-message').text(''); // Clear previous error messages
         $('#register_form input[required]').each(function() {
            if ($(this).val().trim() === '') {
               var fieldName = $(this).attr('name');
               $('#' + fieldName + '_error').text(fieldName + ' is required');
               isValid = false;
            }
         });
         return isValid;
      }

      // Function to perform auto-login and redirect
      function autoLoginAndRedirect(email, password) {
         var loginData = {
            email: email,
            password: password
         };

         console.log(loginData);

         $.ajax({
            type: 'POST',
            url: '{{ route("login-user") }}',
            data: loginData,
            success: function(response) {
               if (response.success) {
                  window.location.href = '{{ route("dashboard") }}';
               } else {
                  $('#errormessage').text('Auto login failed');
                  $('#errormodal').modal('show');
                  setTimeout(function() {
                     $('#errormodal').modal('hide');
                  }, 2000);
               }
            },
            error: function(error) {
               console.log('Error:', error);
               $('#errormessage').text('Auto login failed');
               $('#errormodal').modal('show');
               setTimeout(function() {
                  $('#errormodal').modal('hide');
               }, 2000);
            }
         });
      }
   </script>

</body>

<!-- Mirrored from codervent.com/bulona/demo/authentication-signup.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 26 Feb 2020 10:09:20 GMT -->

</html>
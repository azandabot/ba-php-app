<?php

  if(@$_SESSION['logged_user']){
    header('Location: index.php?route=dashboard.php');
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Boston Bakery - Sign In
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
</head>

<body class="bg-gray-200">

  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('../assets/img/backgrounds/landing.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-white shadow-dark border-radius-lg py-3 pe-1 text-center">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your credentials below to login</p>

                </div>
              </div>
              <div class="card-body">
                                <div id="alert" class="alert text-white" role="alert"></div>
                                <form id="signInForm" class="text-start">
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Username / Email</label>
                                        <input type="text" name="edtUsername" id="edtUsername" class="form-control" required>
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="edtUserPassword" id="edtUserPassword" class="form-control" required>
                                    </div>
                                    <div class="form-check form-switch d-flex align-items-center mb-3">
                                        <input class="form-check-input" type="checkbox" name="rememberMe" checked>
                                        <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                                    </div>
                                    <input type="hidden" name="sign" value="1">
                                    <div class="text-center">
                                        <button type="button" id="signInBtn" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                                    </div>
                                    <p class="mt-4 text-sm text-center">
                                        Don't have an account?
                                        <a href="index.php?route=sign-up.php" class="text-primary font-weight-bold">Sign up</a>
                                    </p>
                                </form>
                            </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#alert").hide();

            $("#signInBtn").click(function () {
              // Validate username and password length
              var username = $("#edtUsername").val();
              var password = $("#edtUserPassword").val();

              if (!username || !password) {
                  // Display an error message if username or password is empty
                  display_response("Please enter both username and password.", false);
                  return;
              }

              if (username.length < 6 || password.length < 6) {
                  // Display an error message for invalid length
                  display_response("Username and password must be at least 6 characters long.", false);
                  return;
              }

              // If validation passes, make the AJAX request
              $.ajax({
                  type: "POST",
                  url: "scripts/execute_process.php?process=sign",
                  data: $("#signInForm").serialize(),
                  dataType: "json",
                  success: function (response) {
                      display_response(response.message, response.success);
                      if (response.redirect) {
                          window.location.href = response.redirect;
                      }
                  },
                  error: function () {
                      display_response("An error occurred", false);
                  },
              });
          });


            function display_response(message, success) {
                var alertDiv = $("#alert");
                alertDiv.removeClass("alert-success alert-danger");
                alertDiv.text(message);

                if (success) {
                    alertDiv.addClass("alert-success");
                } else {
                    alertDiv.addClass("alert-danger");
                }

                alertDiv.show();
            }
        });
    </script>
</body>

</html>
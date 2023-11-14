<?php

  $userLetter = strtoupper(substr($_SESSION['logged_user'], 0, 1));
  $logged_page = @$_GET['tmpl_page'] ?: 'pages/index.php';
  $page = @$_GET['page'] ?: 'Dashboard';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Sakhile Bakery - <?php echo $page; ?>
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show ">
  <?php require_once 'includes/sidenav.php'; ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php require_once 'includes/navbreadcrumb.php'; ?>

    <div class="container-fluid py-4">
      <div class="row">
        <?php require_once $logged_page; ?>
        
      </div>
    </div>
  </main>
  
  <!--   Core JS Files   -->
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>
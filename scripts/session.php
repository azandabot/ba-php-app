<?php

    session_start();

    # default location
    $sys_location = 'sign-in.php';
    # check if user is logged in
    $loggedin = @$_SESSION['logged_user'];
    $route = @$_GET['route'];

    if($loggedin){
        $sys_location = 'dashboard.php';
    }
     
    if ($route) {
        $routeParts = explode('?', $route);
        $sys_location = $routeParts[0];
    }

    
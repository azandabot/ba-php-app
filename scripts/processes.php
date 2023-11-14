<?php

    require_once 'dbconfig.php';
    require_once 'functions.php';
    require_once 'session.php';

    $log = @$_GET['log'];

    if($log){
        unset($_SESSION['logged_user']);
        header('Location: /index.php?route=sign-in.php');
    }
    
    function process_sign($data){
        try{
            $client = new BakeryDBClient;
            $formdata = cleanFormData($data);

            # determine signin/signup
            $operation = $formdata['sign'];
            if($operation === "1"){
                # check result of login
                $status = $client->userLogin($formdata['edtUsername'], $formdata['edtUserPassword']);
                if($status === 'valid'){
                    # save login details for next login, set logged in user and redirect to dashboard
                    if($formdata['rememberMe']){
                        $_SESSION['savedUser_Name'] = $formdata['edtUsername'];
                        $_SESSION['savedUser_Pwd'] = $formdata['edtUserPassword'];
                    }

                    $_SESSION['logged_user'] = $formdata['edtUsername'];

                    return 'dashboard.php';
                }

                $_SESSION['msg'] = 'Incorrect username or password. Please try again.';
                return 'sign-in.php';
            }else{
                # check result of register
                $created = $client->createUser($formdata['edtUsername'], $formdata['edtUserEmail'], $formdata['edtUserPassword'], 'user');
                if($created){
                    $_SESSION['msg'] = 'User created successfully. Login to continue';
                    $_SESSION['status'] = 'success';
                    return 'sign-in.php';
                }

                $_SESSION['msg'] = 'Could not register user. Please try again later.';
                return 'sign-up.php';
            }


            
        }catch(Exception $ex){
            var_dump($ex);
        }
    }
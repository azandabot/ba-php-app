<?php
require_once 'dbconfig.php';
require_once 'functions.php';
require_once 'session.php';

$log = @$_GET['log'];

if ($log) {
    unset($_SESSION['logged_user']);
    header('Location: /index.php?route=sign-in.php');
}

function process_sign($data)
{
    try {
        $client = new BakeryDBClient;
        $formdata = cleanFormData($data);

        # determine signin/signup
        $operation = $formdata['sign'];
        if ($operation === "1") {
            # check result of login
            $status = $client->userLogin($formdata['edtUsername'], $formdata['edtUserPassword']);
            if ($status === 'valid') {
                # save login details for next login, set logged in user and redirect to dashboard
                if ($formdata['rememberMe']) {
                    $_SESSION['savedUser_Name'] = $formdata['edtUsername'];
                    $_SESSION['savedUser_Pwd'] = $formdata['edtUserPassword'];
                }

                $_SESSION['logged_user'] = $formdata['edtUsername'];
                $_SESSION['logged_user_id'] = $client->getLoggedUserId($formdata['edtUsername']);

                echo json_encode([
                    'success' => true,
                    'message' => 'Login Successful!',
                    'redirect' => 'index.php?route=dashboard.php'
                ]);
                exit();
            }

            echo json_encode([
                'success' => false,
                'message' => 'Incorrect username or password. Please try again.'
            ]);
            exit();
        } else {
            # check result of register
            $created = $client->createUser($formdata['edtUsername'], $formdata['edtUserEmail'], $formdata['edtUserPassword'], 'user');
            if ($created) {
                echo json_encode([
                    'success' => true,
                    'message' => 'User created successfully. Login to continue'
                ]);
                exit();
            }

            echo json_encode([
                'success' => false,
                'message' => 'Could not register user. Please try again later.'
            ]);
            exit();
        }
    } catch (Exception $ex) {
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred'
        ]);
        exit();
    }
}

function process_order($data)
{
    try {
        $client = new BakeryDBClient;
        $formdata = cleanFormData($data);

        $operation = $formdata['operation'];

        if ($operation === "1") {
            # create
            $res = $client->makeOrder($_SESSION['logged_user_id'], $formdata['edtItem'], $formdata['edtQty'], 'Y', $formdata['edtInstructions']);
            if ($res) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Order Placed Successfully!'
                ]);
                exit();
            }

            echo json_encode([
                'success' => false,
                'message' => 'Could not Place Order. Please try again later...'
            ]);
            exit();
        } else {
            # edit
            $res = $client->updateOrder($formdata['edtOrderId'], $_SESSION['logged_user_id'], $formdata['edtItem'], $formdata['edtQty'], 'Y', $formdata['edtInstructions']);
            if ($res) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Order Details Updated Successfully!'
                ]);
                exit();
            }

            echo json_encode([
                'success' => false,
                'message' => 'Could not Update Order Details. Please try again later...'
            ]);
            exit();
        }
    } catch (Exception $ex) {
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred'
        ]);
        exit();
    }
}

function process_menu($data)
{
    try {
        $client = new BakeryDBClient;
        $formdata = cleanFormData($data);

        $operation = $formdata['operation'];
        $itemName = $formdata['edtItemName'];
        $itemPrice = $formdata['edtItemPrice'];
        $available = $formdata['edtAvailable'];

        if ($operation === "1") {
            $discount = 0.00;
            $res = $client->createItem($itemName, $itemPrice, $available, $discount);

            if ($res) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Item Created Successfully!'
                ]);
                exit();
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Could not Create Item. Please try again later...'
                ]);
                exit();
            }
        } elseif ($operation === "3") {
            # delete
            $itemId = $formdata['edtItemId'];
            $res = $client->deleteItem($itemId);

            if ($res) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Item Deleted Successfully!'
                ]);
                exit();
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Could not Delete Item. Please try again later...'
                ]);
                exit();
            }
        } elseif ($operation === "2") {
            # update
            $itemId = $formdata['edtItemId'];
            $discount = $formdata['edtDiscount'];
            $res = $client->updateItem($itemId, $itemName, $itemPrice, $available, $discount);

            if ($res) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Item Details Updated Successfully!'
                ]);
                exit();
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Could not Update Item Details. Please try again later...'
                ]);
                exit();
            }
        }
    } catch (Exception $ex) {
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred'
        ]);
        exit();
    }
}

?>

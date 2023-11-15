<?php

    require_once 'processes.php';

    $process = @$_GET['process'];

    switch ($process) {
        case 'menu':
            process_menu($_POST);
            break;

        case 'order':
            process_order($_POST);
            break;

        case 'sign':
            process_sign($_POST);
            break;

        // Add more cases for other processes as needed

        default:
            // Handle invalid process
            echo json_encode(['message' => 'Invalid process', 'success' => false]);
            break;
}

?>

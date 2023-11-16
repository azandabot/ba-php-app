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
        case 'delivery':
            process_delivery($_POST);
            break;

        default:
            echo json_encode(['message' => 'Invalid process', 'success' => false]);
            break;
}

?>

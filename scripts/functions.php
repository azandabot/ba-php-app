<?php

    function cleanInput($data){
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }

    function cleanFormData($data, $cnt = 0, $newData = []) {
        foreach ($data as $key => $value) {
            $newData[$key] = cleanInput($value);
        }
        return $newData;
    }
    
    function getIconForPage($pageName){
        switch ($pageName) {
            case 'Dashboard':
                return 'dashboard';
            case 'Orders':
                return 'table_view';
            case 'Deliveries':
                return 'receipt_long';
            case 'Tracking':
                return 'notifications';
            case 'Menus':
                return 'format_textdirection_r_to_l';
            case 'Prices':
                return 'money';
            case 'Discounts':
                return 'discount';
            case 'Inventory':
                return 'inventory';
            default:
                return 'dashboard'; 
        }
    }
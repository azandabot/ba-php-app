<?php
    require_once 'scripts/session.php';

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

    $site_pages = [
        'Orders' => 'dashboard.php&tmpl_page=pages/orders.php&page=Orders',
        'Deliveries' => 'dashboard.php&tmpl_page=pages/deliveries.php&page=Deliveries',
        'Tracking' => 'dashboard.php&tmpl_page=pages/dashboard-tracking.php&page=Tracking',
        'Menus' => 'dashboard.php&tmpl_page=pages/menus.php&page=Menus',
        'Prices' => 'dashboard.php&tmpl_page=pages/manage-prices.php&page=Prices',
        'Discounts' => 'dashboard.php&tmpl_page=pages/menus.php&page=Discounts&tblView=discount',
        'Inventory' => 'dashboard.php&tmpl_page=pages/inventory.php&page=Inventory',
        'Users' => 'dashboard.php&tmpl_page=pages/users.php&page=User Management'
    ];

    $roles = [
        'user' => [
            'Orders' => ['Place Order'],
            'Deliveries' => ['Schedule Delivery'],
            'Tracking' => ['Orders', 'Deliveries'],
        ],
        'baker_owner' => [
            'Orders' => ['All'],
            'Deliveries' => ['All'],
            'Tracking' => ['All'],
            'Menus' => ['All'],
            'Prices' => ['All'],
            'Discounts' => ['All'],
            'Inventory' => ['All'],
        ], 
        'admin' => [
            'Orders' => ['All'],
            'Deliveries' => ['All'],
            'Tracking' => ['All'],
            'Menus' => ['All'],
            'Prices' => ['All'],
            'Discounts' => ['All'],
            'Inventory' => ['All'],
            'Users' => ['All']
        ]
    ];

    $actions = 0;

    $loggedUserRole = $_SESSION['logged_user_role'];

    if (isset($roles[$loggedUserRole])) {
        $allowedModules = $roles[$loggedUserRole];

        $pages = array_intersect_key($site_pages, $allowedModules);
        if($loggedUserRole !== 'user'){
            $actions = 1;
        }

    } else {
        echo "User role not defined.";
    }
?>

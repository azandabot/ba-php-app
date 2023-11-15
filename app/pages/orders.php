<?php
require_once 'scripts/dbconfig.php';
require_once 'scripts/processes.php';

$client = new BakeryDBClient;

$orders = $client->getAllOrders();
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-primary btn-sm" href="index.php?route=dashboard.php&tmpl_page=pages/manage-orders.php&page=New Order&operation=1">
                <i class="fas fa-plus me-2"></i> New Order
            </a>
        </div>
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Orders</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Qty</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">OrderedAt</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $orders->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><?php echo $order['item_name']; ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?php echo 'R'.$order['quantity']; ?></p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm <?php echo ($order['status'] == 'Pending') ? 'bg-gradient-success' : (($order['status'] == 'In Progress') ? 'bg-gradient-secondary' : 'bg-gradient-danger'); ?>">
                                            <?php echo $order['status']; ?>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $order['created_at']; ?></span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="index.php?route=dashboard.php&tmpl_page=pages/manage-orders.php&page=Update Order&operation=2&orderId=<?php echo $order['id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once 'scripts/dbconfig.php';
    $client = new BakeryDBClient;

    $orders = $client->getOrdersForUser();
    $deliveries = $client->getDeliveriesForUser();
?>

<div class="row">
    <div class="col-xl-6 col-sm-12 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">table_view</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Check your order</p>
                    <h4 class="mb-0">Orders</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <p class="mb-0">
                            <span class="text-sm font-weight-bolder float-left">
                                <?= $order['order_name'] ?> (R<?= $order['order_price'] ?>)
                            </span>
                            <span class="badge float-right <?= ($order['status'] === 'Scheduled' || $order['status'] === 'En-Route') ? 'bg-gradient-secondary' : ($order['status'] === 'Delivered' ? 'bg-gradient-success' : 'bg-gradient-danger'); ?>">
                                <?= $order['status'] ?>
                            </span>
                        </p>
                        <hr class="dark horizontal my-1">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mb-0">No orders made</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-sm-12">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">receipt_long</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Track your delivery</p>
                    <h4 class="mb-0">Deliveries</h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <?php if (!empty($deliveries)): ?>
                    <?php foreach ($deliveries as $delivery): ?>
                        <p class="mb-0">
                            <span class="text-sm font-weight-bolder float-left">
                                <?= $delivery['delivery_name'] ?> (R<?= $delivery['delivery_price'] ?>)
                            </span>
                            <span class="badge float-right <?= ($delivery['status'] === 'Scheduled' || $delivery['status'] === 'En-Route') ? 'bg-gradient-secondary' : ($delivery['status'] === 'Delivered' ? 'bg-gradient-success' : 'bg-gradient-danger'); ?>">
                                <?= $delivery['status'] ?>
                            </span>
                        </p>
                        <hr class="dark horizontal my-1">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mb-0">No deliveries made</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

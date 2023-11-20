<?php
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

// Retrieve delivery data
$deliveries = $client->getDeliveries();
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-primary btn-sm" href="index.php?route=dashboard.php&tmpl_page=pages/manage-delivery.php&page=Deliveries&operation=1">
                <i class="fas fa-plus me-2"></i> Schedule Delivery
            </a>
        </div>
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Deliveries</h6>
                </div>
            </div>
            <div class="card-body px-3 pb-2">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Delivery Date</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Ordered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deliveries as $delivery): ?>
                            <tr>
                                <td><?php echo $delivery['date']; ?></td>
                                <td><?php echo $delivery['item_name']; ?></td>
                                <td><?php echo $delivery['qty']; ?></td>
                                <td><?php echo $delivery['status']; ?></td>
                                <td><?php echo $delivery['created_at']; ?></td>
                                <td>
                                    <?php if($actions): ?>
                                        <a href="index.php?route=dashboard.php&tmpl_page=pages/manage-delivery.php&page=Deliveries&operation=2&deliveryId=<?php echo $delivery['id']; ?>" class="btn btn-primary">Edit</a>
                                        <a href="#" class="btn btn-danger font-weight-bold text-xs delete-delivery" data-delivery-id="<?php echo $delivery['id']; ?>">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $(".delete-delivery").click(function (event) {
            event.preventDefault();
            var deliveryId = $(this).data('delivery-id');

            if (confirm('Are you sure you want to delete this delivery?')) {
                $.ajax({
                    type: "POST",
                    url: "scripts/execute_process.php?process=delivery",
                    data: { operation: "3", edtDeliveryId: deliveryId },
                    dataType: "json",
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function () {
                        alert("An error occurred");
                    },
                });
            }
        });
    });
</script>

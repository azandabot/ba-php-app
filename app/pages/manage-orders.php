<?php

require_once 'scripts/dbconfig.php';
require_once 'scripts/processes.php';

// Initialize the class
$client = new BakeryDBClient;

$page_label = ($_GET['operation'] === "1") ? "New Order" : "Update Order";
$btn_label = ($_GET['operation'] === "1") ? "Place Order" : "Update Order";

// Retrieve menu items
$menuItems = $client->getMenuItems();

// Initialize variables for form data
$edtItem = '';
$edtQty = '';
$edtInstructions = '';
$edtOrderId = '';

// Check if it's an update operation and retrieve data
if ($_GET['operation'] === "2" && isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Replace with your actual method to get a single order
    $order = $client->getOrder($orderId);

    // Populate variables with retrieved data
    if ($order) {
        $edtItem = $order['id'];
        $edtQty = $order['qty'];
        $edtInstructions = $order['instructions'];
        $edtStatus = $order['status'];
        $edtOrderId = $order['id'];
    }
} else if ($_GET['operation'] === "3") {
    $orderId = $_GET['orderId'];
}
?>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3"><?php echo $page_label; ?></h6>
                </div>
            </div>
            <div class="card-body px-3 pb-2">
                <div id="alert" class="alert" role="alert"></div>
                <?php if ($_GET['operation'] === '3'): ?>
                    <div class="alert" role="alert">
                        Are you sure you want to delete this order?
                        <div class="mt-3">
                            <a href="#" class="btn btn-danger" id="deleteBtn">Delete</a>
                            <a href="index.php?route=dashboard.php&tmpl_page=pages/orders.php&page=Orders" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                <?php else: ?>
                    <form action="" method="POST" id="orderForm">
                        <select class="form-select mb-3" id="item" name="edtItem" required>
                            <option value="" disabled selected>Select a Menu Item</option>
                            <?php foreach ($menuItems as $menuItem): ?>
                                <option value="<?php echo $menuItem['id']; ?>" <?php echo ($edtItem === $menuItem['id']) ? 'selected' : ''; ?>><?php echo $menuItem['item_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" class="form-control mb-3" id="quantity" name="edtQty" placeholder="Enter Quantity" value="<?php echo $edtQty; ?>" required>
                        <textarea class="form-control mb-3" id="instructions" name="edtInstructions" rows="5" placeholder="Enter Instructions"><?php echo $edtInstructions; ?></textarea>
                        <?php if ($_GET['operation'] !== "1"): ?>
                            <input type="hidden" name="edtOrderId" value="<?php echo $edtOrderId; ?>">
                            <select class="form-select mb-3" id="item" name="edtStatus" required>
                                <option value="In Progress" <?php echo ($edtStatus === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Delivered" <?php echo ($edtStatus === 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo ($edtStatus === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        <?php endif; ?>
                        <input type="hidden" name="operation" value="<?php echo $_GET['operation']; ?>">
                        <div class="text-center">
                            <button type="button" id="orderBtn" class="btn btn-success w-100 btn-lg"><?php echo $btn_label; ?></button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $("#alert").hide();
        $("#orderForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=order",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    display_response(response.message, response.success);
                    
                },
                error: function () {
                    display_response("An error occurred", false);
                },
            });
        });

        $("#orderBtn").click(function () {
            // Trigger form submission on button click
            $("#orderForm").submit();
        });

        $("#deleteBtn").click(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=order",
                data: { operation: "3", edtOrderId: <?php echo @$orderId ?: 0; ?> },
                dataType: "json",
                success: function (response) {
                    display_response(response.message, response.success);
                    $("#deleteBtn").hide();
                    
                },
                error: function () {
                    display_response("An error occurred", false);
                },
            });
        });

        function display_response(message, success) {
            var alertDiv = $("#alert");
            alertDiv.removeClass("alert-success alert-danger");
            alertDiv.text(message);

            if (success) {
                alertDiv.addClass("alert-success");
            } else {
                alertDiv.addClass("alert-danger");
            }

            alertDiv.show();
        }
    });
</script>

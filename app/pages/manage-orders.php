<?php

require_once 'scripts/dbconfig.php';
require_once 'scripts/processes.php';

// Initialize the class
$client = new BakeryDBClient;

$page_label = ($_GET['operation'] === "1") ? "New Order" : "Update Order";
$btn_label = ($_GET['operation'] === "1") ? "Place Order" : "Update Order";

// Retrieve menu items
$menuItems = $client->getMenuItems();

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
                <form action="" method="POST" id="orderForm">
                    <select class="form-select mb-3" id="item" name="edtItem" required>
                        <option value="" disabled selected>Select a Menu Item</option>
                        <?php foreach ($menuItems as $menuItem): ?>
                            <option value="<?php echo $menuItem['id']; ?>"><?php echo $menuItem['item_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control mb-3" id="quantity" name="edtQty" placeholder="Enter Quantity" required>
                    <textarea class="form-control mb-3" id="instructions" name="edtInstructions" rows="5" placeholder="Enter Instructions"></textarea>
                    <?php if ($_GET['operation'] !== "1"): ?>
                        <input type="hidden" name="edtOrderId" value="<?php echo @$_GET['orderId']; ?>">
                    <?php endif; ?>
                    <input type="hidden" name="operation" value="<?php echo $_GET['operation']; ?>">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100 btn-lg"><?php echo $btn_label; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $("#orderForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=order",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    display_response(response.message, response.success);
                    if (response.reload) {
                        location.reload();
                    }
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


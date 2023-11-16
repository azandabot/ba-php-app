<?php
require_once 'scripts/processes.php';
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

$page_label = ($_GET['operation'] === "1") ? "Schedule Delivery" : "Update Delivery";
$btn_label = ($_GET['operation'] === "1") ? "Schedule" : "Update";

// Initialize variables for form data
$edtDate = '';
$edtItem = '';
$edtQty = '';
$edtStatus = 'Scheduled'; // Default status
$edtInstructions = '';
$edtDeliveryId = '';

// Check if it's an update operation and retrieve data
if ($_GET['operation'] === "2" && isset($_GET['deliveryId'])) {
    $deliveryId = $_GET['deliveryId'];

    // Replace with your actual method to get a single delivery
    $delivery = $client->getDelivery($deliveryId);

    // Populate variables with retrieved data
    if ($delivery) {
        $edtDate = $delivery['date'];
        $edtItem = $delivery['item_id'];
        $edtQty = $delivery['qty'];
        $edtStatus = $delivery['status'];
        $edtInstructions = $delivery['instructions'];
        $edtDeliveryId = $delivery['id'];
    }
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
                <div id="alert" class="alert text-white" role="alert"></div>
                <form action="" method="POST" id="deliveryForm">
                    <input type="text" class="form-control mb-3 datepicker" id="date" name="edtDate" placeholder="Select Date" value="<?php echo $edtDate; ?>" required>
                    <select class="form-select mb-3" id="item" name="edtItem" required>
                        <option value="" disabled selected>Select a Menu Item</option>
                        <?php foreach ($client->getMenuItems() as $menuItem): ?>
                            <option value="<?php echo $menuItem['id']; ?>" <?php echo ($edtItem === $menuItem['id']) ? 'selected' : ''; ?>><?php echo $menuItem['item_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control mb-3" id="quantity" name="edtQty" placeholder="Enter Quantity" value="<?php echo $edtQty; ?>" required>
                    <?php if($_GET['operation'] === "2"): ?>
                        <select class="form-select mb-3" id="status" name="edtStatus" required>
                            <option value="Scheduled" <?php echo ($edtStatus === 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                            <option value="En-Route" <?php echo ($edtStatus === 'En-Route') ? 'selected' : ''; ?>>En-Route</option>
                            <option value="Delivered" <?php echo ($edtStatus === 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                            <option value="Cancelled" <?php echo ($edtStatus === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    <?php endif; ?>
                    <textarea class="form-control mb-3" id="instructions" name="edtInstructions" rows="5" placeholder="Enter Instructions"><?php echo $edtInstructions; ?></textarea>
                    <input type="hidden" name="operation" value="<?php echo $_GET['operation']; ?>">
                    <?php if ($_GET['operation'] === "2"): ?>
                        <input type="hidden" name="edtDeliveryId" value="<?php echo $edtDeliveryId; ?>">
                    <?php endif; ?>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100 btn-lg"><?php echo $btn_label; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function () {
        // Set default display of the alert to none
        $("#alert").hide();

        // Initialize datepicker
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        $("#deliveryForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=delivery",
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

        $("#cancelBtn").click(function (event) {
            event.preventDefault();
            window.location.href = "index.php?route=dashboard.php&tmpl_page=pages/deliveries.php&page=Deliveries";
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

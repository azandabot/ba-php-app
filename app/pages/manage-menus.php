<?php
require_once 'scripts/processes.php';
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

$page_label = ($_GET['operation'] === "1") ? "New Item" : "Update Item";
$btn_label = ($_GET['operation'] === "1") ? "Add Item" : "Update Item";

// Initialize variables for form data
$edtItemName = '';
$edtItemPrice = '';
$edtDiscount = '';
$edtAvailable = '';
$edtItemId = '';

// Check if it's an update operation and retrieve data
if ($_GET['operation'] === "2" && isset($_GET['itemId'])) {
    $itemId = $_GET['itemId'];

    // Replace with your actual method to get a single menu item
    $menuItem = $client->getMenuItem($itemId);

    // Populate variables with retrieved data
    if ($menuItem) {
        $edtItemName = $menuItem['item_name'];
        $edtItemPrice = $menuItem['item_price'];
        $edtDiscount = $menuItem['discount'];
        $edtAvailable = $menuItem['available'];
        $edtItemId = $menuItem['id'];
    }
} else if($_GET['operation'] === "3") {
    $itemName = $_GET['item'];
    $itemId = $_GET['itemId'];
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
                
                <?php if ($_GET['operation'] === '3'): ?>
                    <div id="alert" class="alert text-white" role="alert"></div>
                    <div class="alert" role="alert">
                        Are you sure you want to delete <?php echo $itemName; ?>?
                        <div class="mt-3">
                            <a href="#" class="btn btn-danger" id="deleteBtn">Delete</a>
                            <a href="index.php?route=dashboard.php&tmpl_page=pages/menus.php&page=Menus" class="btn btn-secondary" >Cancel</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div id="alert" class="alert text-white" role="alert"></div>
                    <form action="" method="POST" id="menuForm">
                        <input type="text" class="form-control mb-3" id="item_name" name="edtItemName" placeholder="Enter Item Name" value="<?php echo $edtItemName; ?>" required>
                        <input type="number" class="form-control mb-3" id="item_price" name="edtItemPrice" placeholder="Enter Item Price" value="<?php echo $edtItemPrice; ?>" required>
                        <input type="hidden" name="operation" value="<?php echo $_GET['operation']; ?>">
                        <?php if ($_GET['operation'] === "2"): ?>
                            <input type="number" class="form-control mb-3" id="item_discount" name="edtDiscount" placeholder="Enter Item Discount" value="<?php echo $edtDiscount; ?>">
                            <input type="hidden" name="edtItemId" value="<?php echo $edtItemId; ?>">
                        <?php endif; ?>
                        <select class="form-select mb-3" id="available" name="edtAvailable" required>
                            <option value="" disabled selected>Is Item Available?</option>
                            <option value="Y" <?php echo ($edtAvailable === 'Y') ? 'selected' : ''; ?>>Yes</option>
                            <option value="N" <?php echo ($edtAvailable === 'N') ? 'selected' : ''; ?>>No</option>
                        </select>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100 btn-lg"><?php echo $btn_label; ?></button>
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
        // Set default display of the alert to none
        $("#alert").hide();

        $("#menuForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=menu",
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

        $("#deleteBtn").click(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=menu",
                data: { operation: "3", edtItemId: <?php echo @$itemId ?: 0; ?> },
                dataType: "json",
                success: function (response) {
                    display_response(response.message, response.success);
                    $("#deleteBtn").hide();
                    if (response.reload) {
                        location.reload();
                    }
                },
                error: function () {
                    display_response("An error occurred", false);
                },
            });
        });

        $("#cancelBtn").click(function (event) {
            event.preventDefault();
            // Redirect or handle cancellation as needed
            window.location.href = "index.php?route=dashboard.php&tmpl_page=pages/manage-menus.php&page=Menu";
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

            // Toggle the display of the alert
            alertDiv.show();
        }
    });
</script>


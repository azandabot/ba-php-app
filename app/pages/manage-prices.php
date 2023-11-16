<?php
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

// Retrieve menu items
$menuItems = $client->getMenuItems();
?>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Update Prices</h6>
                </div>
            </div>
            <div class="card-body px-3 pb-2">
                <div id="alert" class="alert text-white" role="alert"></div>
                <form action="" method="POST" id="priceUpdateForm">
                    <select class="form-select mb-3" id="item" name="edtItem" required>
                        <option value="" disabled selected>Select an Item</option>
                        <?php foreach ($menuItems as $menuItem): ?>
                            <option value="<?php echo $menuItem['id']; ?>"><?php echo $menuItem['item_name'].' (R'.$menuItem['item_price'].')'; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control mb-3" id="newPrice" name="edtNewPrice" placeholder="Enter New Price" required>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100 btn-lg">Save</button>
                    </div>
                </form>
            </div>
        </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $("#alert").hide();
        $("#newPrice").prop('disabled', true);

        $("#item").change(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "getData.php?fetch=menu_item_price&fetch_id=" + this.value,
                data: $(this).serialize(),
                dataType: "json",
                success: function (data) {
                    $("#newPrice").prop('disabled', false);
                    $("#newPrice").val(data.data); 
                },
                error: function () {
                    display_response("An error occurred", false, '');
                },
            });
        });


        $("#priceUpdateForm").submit(function (event) {
            event.preventDefault();

            var item_id = $("#item").val();
            var new_price = $("#newPrice").val();

            $.ajax({
                type: "POST",
                url: "scripts/execute_process.php?process=menu",
                data: {
                    operation: 'update_price',
                    item_id: item_id,
                    edtItemPrice: new_price
                },
                dataType: "json",
                success: function (response) {
                    display_response(response.message, response.success, response.link);
                },
                error: function () {
                    display_response("An error occurred", false, '');
                },
            });
        });

        function display_response(message, success, link) {
            var alertDiv = $("#alert");
            alertDiv.removeClass("alert-success alert-danger");
            alertDiv.text(message);

            if (success) {
                alertDiv.addClass("alert-success");
                if (link) {
                    alertDiv.append(' <a href="' + link + '" class="alert-link">View Item</a>');
                }
            } else {
                alertDiv.addClass("alert-danger");
            }

            alertDiv.show();
        }
    });
</script>

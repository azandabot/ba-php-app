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
                    <h6 class="text-white text-capitalize ps-3">Stock Status</h6>
                </div>
            </div>
            <div class="card-body px-3 pb-2">
                <div id="alert" class="alert text-white" role="alert"></div>
                <form action="" method="POST" id="priceUpdateForm">
                    <select class="form-select mb-3" id="item" name="edtItem" required>
                        <option value="" disabled selected>Select an Item</option>
                        <?php foreach ($menuItems as $menuItem): ?>
                            <option value="<?php echo $menuItem['id']; ?>"><?php echo $menuItem['item_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" class="form-control mb-3" name="Total Sales" id="edtSalesTotal" placeholder="Total Sales" disabled>
                    <input type="number" class="form-control mb-3" name="Qty Purchased" id="edtQtyPurchased" placeholder="Qty Purchased" disabled>
                    <input type="number" class="form-control mb-3" id="total_stock" name="edtTotalStock" placeholder="Stock Total" required>
                   
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-100 btn-lg">Calculate</button>
                    </div>

                    <h5>
                        Results:
                    </h5>

                    <!-- Display results -->
                    <div id="stockResults">
                        <!-- Results will be dynamically populated here -->
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

        $("#item").change(function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "getData.php?fetch=stock_status&fetch_id=" + this.value,
                data: $(this).serialize(),
                dataType: "json",
                success: function (data) {
                    $("#edtSalesTotal").val(data.TotalSales);
                    $("#edtQtyPurchased").val(data.TotalQty);
                },
                error: function () {
                    display_response("An error occurred", false, '');
                },
            });
        });


        $("#priceUpdateForm").submit(function (event) {
            event.preventDefault();

            var item_id = $("#item").val();
            var total_stock = $("#total_stock").val();

            $.ajax({
                type: "POST",
                url: "getData.php?fetch=stock_calculations&fetch_id=" + item_id + '&fetch_id_2=' + total_stock,
                data: { total_stock: total_stock },
                dataType: "json",
                success: function (data) {
                    display_response("Calculation successful", true, '');

                      // Parse JSON string
                    var jsonData = JSON.parse(data);

                    // Create HTML representation
                    var htmlOutput = '<strong>Total Sales:</strong> ' + jsonData.totalSales + '<br />';
                    htmlOutput += '<strong>Total Qty:</strong> ' + jsonData.totalQty + '<br />';
                    htmlOutput += '<strong>Stock Utilization:</strong> ' + jsonData.stockUtilization + '%<br />';
                    htmlOutput += '<strong>Reorder Recommendation:</strong> ' + jsonData.reorderRecommendation + '<br />';
                    htmlOutput += '<strong>Sales Velocity:</strong> ' + jsonData.salesVelocity + '<br />';

                    // Display the HTML in the #stockResults div
                    $("#stockResults").html(htmlOutput);
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

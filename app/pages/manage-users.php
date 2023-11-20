<?php
require_once 'scripts/processes.php';
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

$page_label = ($_GET['operation'] === "1") ? "Add User" : "Update User";
$btn_label = ($_GET['operation'] === "1") ? "Add" : "Update";

// Initialize variables for form data
$edtUsername = '';
$edtEmail = '';
$edtPassword = ''; // Make password not required
$edtRole = 'user'; // Default role
$edtCreatedAt = '';

// Check if it's an update operation and retrieve data
if ($_GET['operation'] === "2" && isset($_GET['userId'])) {
  $userId = $_GET['userId'];

  // Replace with your actual method to get a single user
  $user = $client->getUser($userId);

  // Populate variables with retrieved data
  if ($user) {
    $edtUsername = $user['username'];
    $edtEmail = $user['email'];
    $edtPassword = ''; // Make password not required
    $edtRole = $user['role'];
    $edtCreatedAt = $user['created_at'];
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
        <form action="" method="POST" id="userForm">
          <input type="text" class="form-control mb-3" id="username" name="edtUsername" placeholder="Enter Username" value="<?php echo $edtUsername; ?>" required>
          <input type="email" class="form-control mb-3" id="email" name="edtEmail" placeholder="Enter Email" value="<?php echo $edtEmail; ?>" required>
          <input type="password" class="form-control mb-3" id="password" name="edtPassword" placeholder="Enter Password" value="<?php echo $edtPassword; ?>">
          <?php if ($_GET['operation'] === "2"){echo "<small class='text-danger mb-2'>Only fill password in if you want it to be changed!</small>";} ?>
          <select class="form-select mb-3" id="role" name="edtRole" required>
            <option value="user" <?php echo ($edtRole === 'user') ? 'selected' : ''; ?>>User</option>
            <option value="baker_owner" <?php echo ($edtRole === 'baker_owner') ? 'selected' : ''; ?>>Baker Owner</option>
          </select>
          <input type="hidden" name="operation" value="<?php echo $_GET['operation']; ?>">
          <?php if ($_GET['operation'] === "2"): ?>
            <input type="hidden" name="edtUserId" value="<?php echo $userId; ?>">
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
<script>
  $(document).ready(function () {
    // Set default display of the alert to none
    $("#alert").hide();

    $("#userForm").submit(function (event) {
      event.preventDefault();

      $.ajax({
        type: "POST",
        url: "scripts/execute_process.php?process=user",
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
            window.location.href = "index.php?route=dashboard.php&tmpl_page=pages/users.php&page=Users";
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

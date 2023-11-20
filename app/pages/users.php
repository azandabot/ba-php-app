<?php
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

// Retrieve user data
$users = $client->getUsers();
?>

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Users</h6>
                </div>
            </div>
            <div class="card-body px-3 pb-2">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td><?php echo $user['created_at']; ?></td>
                                <td>
                                <a href="index.php?route=dashboard.php&tmpl_page=pages/manage-users.php&page=Users&operation=2&userId=<?php echo $user['id']; ?>" class="btn btn-primary">Edit</a>
                                        <a href="#" class="btn btn-danger font-weight-bold text-xs delete-user" data-user-id="<?php echo $user['id']; ?>">Delete</a>

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
        $(".delete-user").click(function (event) {
            event.preventDefault();
            var userId = $(this).data('user-id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    type: "POST",
                    url: "scripts/execute_process.php?process=user",
                    data: { operation: "3", edtUserId: userId },
                    dataType: "json",
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (response) {
                        alert("An error occurred");
                    },
                });
            }
        });
    });
</script>
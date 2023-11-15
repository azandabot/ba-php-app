<?php
require_once 'scripts/dbconfig.php';
$client = new BakeryDBClient;

$menus = $client->getMenuItems();
?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-primary btn-sm" href="index.php?route=dashboard.php&tmpl_page=pages/manage-menus.php&page=New Menu Item&operation=1">
                <i class="fas fa-plus me-2"></i> New Item
            </a>
        </div>
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Menu</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Available</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Discount(%)</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($menu = $menus->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td>
                    <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $menu['item_name']; ?></h6>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-bold mb-0">R<?= $menu['item_price']; ?></p>
                </td>
                <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm <?= $menu['available'] == 'Y' ? 'bg-gradient-success' : 'bg-gradient-danger'; ?>">
                        <?= $menu['available'] == 'Y' ? 'Yes' : 'No'; ?>
                    </span>
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold"><?= $menu['discount'] == 0 ? 'N/A' : $menu['discount']; ?></span>
                </td>
                <td class="align-middle">
                    <a href="index.php?route=dashboard.php&tmpl_page=pages/manage-menus.php&page=Update Menu Item&operation=2&itemId=<?= $menu['id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit menu">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="index.php?route=dashboard.php&tmpl_page=pages/manage-menus.php&page=Delete Menu Item&operation=3&itemId=<?= $menu['id']; ?>&item=<?= $menu['item_name']; ?>" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete menu">
                        <i class="fas fa-trash-alt ms-1"></i> Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

                    </div>
            </div>
        </div>
    </div>
</div>

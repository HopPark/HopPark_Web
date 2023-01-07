<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/ParkingLots/ParkingLots.php';
$parkinglot = new ParkingLots();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$active = filter_input(INPUT_GET, 'active');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'pl_id';
}
if (!$order_by) {
	$order_by = 'Asc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();

//Start building query according to input parameters.
// If search string
if ($search_string) {
    $db->where('pl_name', '%' . $search_string . '%', 'like');
    $db->orwhere('pl_address', '%' . $search_string . '%', 'like');
    $db->orwhere('city_name', '%' . $search_string . '%', 'like');
    $db->orwhere('district_name', '%' . $search_string . '%', 'like');
}
if ($active) {
    switch ($active){
        case "-1":
            $db->where('pl_is_active', "0");
            break;
        case "1":
            $db->where('pl_is_active', "1");
            break;
    }
}
//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$db->where('pl_owner_id', $_SESSION['user_id']);
$rows = $db->arraybuilder()->paginate('pl_view', $page);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header"><?php if ($active) {
                    switch ($active){
                        case "-1":
                            echo "Pasif ";
                            break;
                        case "1":
                            echo "Aktif ";
                            break;
                    }
                }?>Otopark Listesi</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_parking_lot.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Ekle</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Ara</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
            <label for="input_order">Sırala</label>
            <select name="filter_col" class="form-control">
                <?php
foreach ($parkinglot->setOrderingValues() as $opt_value => $opt_name):
	($filter_col === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_by == 'Asc') {
	echo 'selected';
}
?> >Artan</option>
                <option value="Desc" <?php
if ($order_by == 'Desc') {
	echo 'selected';
}
?>>Azalan</option>
            </select>
            <input type="submit" value="Git" class="btn btn-primary">
        </form>
    </div>
    <hr>

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="5%">Aktif</th>
                <th width="15%">Otopark Adı</th>
                <th width="10%">Şehir</th>
                <th width="10%">İlçe</th>
                <th width="20%">Adres</th>
                <th width="5%">Kapasite</th>
                <th width="5%">Doluluk</th>
                <th width="7%">Saatlik ücret</th>
                <th width="5%">Bakiye</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['pl_id']; ?></td>
                <td><?php echo $row['pl_is_active'] != 0 ? "Evet" : "Hayır"; ?></td>
                <td><?php echo xss_clean($row['pl_name']); ?></td>
                <td><?php echo xss_clean($row['city_name']); ?></td>
                <td><?php echo xss_clean($row['district_name']); ?></td>
                <td><?php echo xss_clean($row['pl_address']); ?></td>
                <td><?php echo xss_clean($row['pl_capacity']); ?></td>
                <td><?php echo xss_clean($row['pl_size']); ?></td>
                <td><?php echo xss_clean($row['pl_hourly_rate']); ?></td>
                <td><?php echo xss_clean($row['pl_balance']); ?></td>
                <td>
                    <a href="edit_parking_lot.php?pl_id=<?php echo $row['pl_id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-warning delete_btn" data-toggle="modal" data-target="#confirm-passive-<?php echo $row['pl_id']; ?>"><i class="glyphicon glyphicon-stop"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['pl_id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['pl_id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_parking_lot.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Onayla</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['pl_id']; ?>">
                                <p>Otoparkı silmek istediğinize emin misiniz?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Evet</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hayır</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-passive-<?php echo $row['pl_id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_parking_lot.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Onayla</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['pl_id']; ?>">
                                <input type="hidden" name="passive" id="passive" value="1">
                                <p>Otoparkı aktif/pasif hale getirmek istediğinize emin misiniz?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Evet</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hayır</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <?php endforeach;?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'parking_lots.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>

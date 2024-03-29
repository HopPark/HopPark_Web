<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/ParkingLots/CarParkingLogs.php';
$parkinglot = new CarParkingLogs();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$pl_id = filter_input(INPUT_GET, 'pl_id');
if (!$pl_id || !filter_var($pl_id, FILTER_VALIDATE_INT) || $pl_id < 1) {
    header('location: pl_logs.php' );
    exit;
}

// Per page limit for pagination.
$pagelimit = 25;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'cpl_id';
}
if (!$order_by) {
	$order_by = 'Asc';
}
$db = getDbInstance();
$db->where('pl_id', $pl_id);
$row2 = $db->getOne('parking_lot');

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();

//Start building query according to input parameters.
// If search string
if ($search_string) {
    $db->where('cpl_car_plate', '%' . $search_string . '%', 'like');
    $db->orwhere('cpl_enter_date', '%' . $search_string . '%', 'like');
    $db->orwhere('cpl_exit_date', '%' . $search_string . '%', 'like');
}
//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$db->where('cpl_pl_id', $pl_id);
$rows = $db->arraybuilder()->paginate('pl_log_view', $page);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header"><?php echo $row2['pl_name']; ?> Kayıt Listesi</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_pl_log.php?pl_id=<?php echo $pl_id; ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Kayıt Ekle</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <input type="hidden" class="form-control" id="pl_id" name="pl_id" value="<?php echo xss_clean($pl_id ?? ''); ?>">
            <label for="input_search">Ara</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string ?? ''); ?>">
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
                <th width="5%">Plaka</th>
                <th width="10%">Giriş Tarihi</th>
                <th width="10%">Çıkış Tarihi</th>
                <th width="10%">Ücret</th>
                <th width="5%">Çıkış Yap</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['cpl_id']; ?></td>
                <td><?php echo xss_clean($row['cpl_car_plate'] ?? ''); ?></td>
                <td><?php echo xss_clean($row['cpl_enter_date'] ?? ''); ?></td>
                <td><?php echo xss_clean($row['cpl_exit_date'] ?? ''); ?></td>
                <td><?php echo xss_clean($row['cpl_total_payment'] ?? ''); ?></td>
                <td>
                    <?php echo !$row['cpl_exit_date'] ? '<a href="#" class="btn btn-warning delete_btn" data-toggle="modal" data-target="#confirm-exit-'.$row['cpl_id'].'"><i class="glyphicon glyphicon-stop"></i></a>' : ''; ?>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-exit-<?php echo !$row['cpl_exit_date'] ? $row['cpl_id']: ''; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="exit_pl_log.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Onayla</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="cpl_id" id="cpl_id" value="<?php echo !$row['cpl_exit_date'] ? $row['cpl_id']: ''; ?>">
                                <input type="hidden" name="car_plate" id="car_plate" value="<?php echo !$row['cpl_exit_date'] ? $row['cpl_car_plate']: ''; ?>">
                                <p>Aracın otoparktan çıkışının yapılmasını istediğinize emin misiniz?</p>
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
    <?php echo paginationLinks($page, $total_pages, 'pl_log.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>

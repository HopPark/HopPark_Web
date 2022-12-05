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
            <h1 class="page-header">Kayıtlar İçin Otopark Seçimi Yapın</h1>
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
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr class='clickable-row' data-href='pl_log.php?pl_id=<?php echo $row['pl_id']; ?>'>
                <td><?php echo $row['pl_id']; ?></td>
                <td><?php echo $row['pl_is_active'] != 0 ? "Evet" : "Hayır"; ?></td>
                <td><?php echo xss_clean($row['pl_name']); ?></td>
                <td><?php echo xss_clean($row['city_name']); ?></td>
                <td><?php echo xss_clean($row['district_name']); ?></td>
                <td><?php echo xss_clean($row['pl_address']); ?></td>
                <td><?php echo xss_clean($row['pl_capacity']); ?></td>
                <td><?php echo xss_clean($row['pl_size']); ?></td>
                <td><?php echo xss_clean($row['pl_hourly_rate']); ?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <!-- //Table -->
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>

    <!-- Pagination -->
    <div class="text-center">
        <?php echo paginationLinks($page, $total_pages, 'parking_lots.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>

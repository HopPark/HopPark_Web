<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

$operation = filter_input(INPUT_GET, 'operation');
($operation == 'edit') ? $edit = true : $edit = false;
//Serve POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input post if we want
    $data_to_update = filter_input_array(INPUT_POST);

    if (5 > $data_to_update['pl_capacity']) {

        $_SESSION['failure'] = "Kapasite 5 den az olamaz!";

        header('location: parking_lots.php' );
        exit;
    } 

    //Check whether the user name already exists ;
    $db = getDbInstance();

    $data = Array (
        'pl_owner_id' => $_SESSION['user_id'],
        'pl_is_active' => 1,
        'pl_name' => $data_to_update['pl_name'],
        'pl_city_id' => $data_to_update['pl_city_id'],
        'pl_district_id' => $data_to_update['pl_district_id'],
        'pl_address' => $data_to_update['pl_address'],
        'pl_geojson' => "",
        'pl_capacity' => $data_to_update['pl_capacity'],
        'pl_size' => 0,
        'pl_hourly_rate' => $data_to_update['pl_hourly_rate'],
        'pl_balance' => 0,
    );

    $id = $db->insert ('parking_lot', $data);
    if ($id) {
        $_SESSION['success'] = "Otopark başarılı bir şekilde eklendi";
    } else {
        $_SESSION['failure'] = "Ekleme yapılırken hata alındı: " . $db->getLastError();
    }

    header('location: parking_lots.php');
    exit;

}

$totalCapacity = 10000;

//$db = getDbInstance();
//$cities = $db->get("cities");
$cities = array( array("city_id" => "34" , "city_name" => "İstanbul"));
$db = getDbInstance();
$districts = $db->get("districts");

// import header
require_once 'includes/header.php';
?>
<style>
    #map { height: 360px; width: 720px }
</style>



<div id="page-wrapper">

    <div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Yeni Otopark Ekle</h2>
        </div>

    </div>
    <?php include_once 'includes/flash_messages.php';?>
    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">
        <div class="form-group">
            <label for="pl_name">Otopark Adı</label>
            <input maxlength="30" name="pl_name" value="" placeholder="Otopark İsmini Giriniz" class="form-control" required="required" id="pl_name">
        </div>

        <div class="form-group">
            <label for="pl_city_id">İl</label>
            <select name="pl_city_id" class="form-control selectpicker" required>
                <option selected="selected" disabled="disabled" style="display:none;" value=" " >Lütfen bulunduğu şehri seçiniz</option>
                <?php
                foreach ($cities as $city) {
                    echo '<option value="'.$city['city_id'].'">' . $city['city_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pl_district_id">İlçe</label>
            <select name="pl_district_id" class="form-control selectpicker" required>
                <option selected="selected" disabled="disabled" style="display:none;" value=" " >Lütfen bulunduğu ilçeyi seçiniz</option>
                <?php
                foreach ($districts as $district) {
                    echo '<option value="'.$district['district_id'].'">' . $district['district_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pl_address">Otopark Adresi</label>
            <input maxlength="50" name="pl_address" value="" placeholder="Otopark Adresini Giriniz" class="form-control" required="required" id="pl_address">
        </div>

        <div class="form-group">
            <label for="pl_capacity">Otopark Kapasitesi</label>
            <input type="number" name="pl_capacity" value="" placeholder="~100" max="<?php echo $totalCapacity; ?>" class="form-control" required="required" id="pl_capacity">
        </div>

        <div class="form-group">
            <label for="pl_hourly_rate">Otopark Saatlik Ücreti</label>
            <input type="number" name="pl_hourly_rate" value="" placeholder="~15" class="form-control" required="required" id="pl_hourly_rate">
        </div>

        <div class="form-group">
            <label for="pl_geojson">Seçilen Konum:</label>
            <input type="text" id="pl_geojson" name="pl_geojson" placeholder="Haritadan konum seçin.." onkeydown="return false;" class="form-control" style="caret-color: transparent !important;" required>
        </div>

        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning" >Oluştur <span class="glyphicon glyphicon-send"></span></button>
        </div>       
    </form>
    <div id="map"></div>
</div>

<script>
    var map = L.map('map', {tap: false}).setView([41.0053215,29.0121795], 13);

    L.control.layers({
        "Varsayılan": L.tileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', { maxZoom: 19}).addTo(map),
        "Uydu": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', { maxZoom: 19}),
        "Osm": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19})
    }).addTo(map);

    var drawnItems = L.featureGroup().addTo(map);
    var options = {
      edit: false,
      draw: {
          circle: false,
          circlemarker: false,
          polygon: false,
          rectangle: false,
          polyline: false,
      }
    };
    map.addControl(new L.Control.Draw(options));


      map.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;

        drawnItems.clearLayers();
        drawnItems.addLayer(layer);

        var shape = layer.toGeoJSON()
        var shape_for_db = JSON.stringify(shape);

        $('#pl_geojson').val(shape_for_db);
      });

</script>

<?php include_once 'includes/footer.php';?>
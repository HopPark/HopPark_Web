<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$pl_id = filter_input(INPUT_GET, 'pl_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
$edit = true;
$db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);

    $db = getDbInstance();
    $db->where('pl_id',$pl_id);
    $stat = $db->update('parking_lot', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Gerçekleştirme görevlisi başarılı bir şekilde güncellendi!";
    }
    else
    {
        $_SESSION['failure'] = "Güncelleme başarısız: " . $db->getLastError();
    }
    header('location: parking_lots.php');
    exit();
}


//If edit variable is set, we are performing the update operation.
if($pl_id)
{
    $db->where('pl_id', $pl_id);
    //Get data to pre-populate the form.
    $parking_lot = $db->getOne("parking_lot");

    $totalCapacity = 10000;

    $db = getDbInstance();
    $cities = $db->get("cities");
    $db = getDbInstance();
    $districts = $db->get("districts");
} else {
    header('location: parking_lots.php');
    exit();
}
?>


<?php
    include_once 'includes/header.php';
?>
<style>
    #map { height: 360px; width: 720px }
</style>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Otopark Bilgilerini Güncelleme</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">

        <div class="form-group">
            <label for="pl_name">Otopark Adı</label>
            <input maxlength="30" name="pl_name" value="<?php echo htmlspecialchars($edit ? $parking_lot['pl_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Otopark İsmini Giriniz" class="form-control" required="required" id="pl_name">
        </div>

        <div class="form-group">
            <label for="pl_city_id">İl</label>
            <select name="pl_city_id" class="form-control selectpicker" required>
                <?php
                foreach ($cities as $city) {
                    if ($parking_lot['pl_city_id'] == $city['city_id'])
                        echo '<option selected="selected" value="'.$city['city_id'].'">' . $city['city_name'] . '</option>';
                    else
                        echo '<option value="'.$city['city_id'].'">' . $city['city_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pl_district_id">İlçe</label>
            <select name="pl_district_id" class="form-control selectpicker" required>
                <?php
                foreach ($districts as $district) {
                    if ($parking_lot['pl_district_id'] == $district['district_id'])
                        echo '<option selected="selected" value="'.$district['district_id'].'">' . $district['district_name'] . '</option>';
                    else
                        echo '<option value="'.$district['district_id'].'">' . $district['district_name'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pl_address">Otopark Adresi</label>
            <input maxlength="50" name="pl_address" value="<?php echo htmlspecialchars($edit ? $parking_lot['pl_address'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Otopark Adresini Giriniz" class="form-control" required="required" id="pl_address">
        </div>

        <div class="form-group">
            <label for="pl_capacity">Otopark Kapasitesi</label>
            <input type="number" name="pl_capacity" value="<?php echo htmlspecialchars($edit ? $parking_lot['pl_capacity'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="~100" max="<?php echo $totalCapacity; ?>" class="form-control" required="required" id="pl_capacity">
        </div>

        <div class="form-group">
            <label for="pl_hourly_rate">Otopark Saatlik Ücreti</label>
            <input type="number" name="pl_hourly_rate" value="<?php echo htmlspecialchars($edit ? $parking_lot['pl_hourly_rate'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="~15" class="form-control" required="required" id="pl_hourly_rate">
        </div>

        <div class="form-group">
            <label for="pl_geojson">Seçilen Konum:</label>
            <input type="text" id="pl_geojson" name="pl_geojson" value="<?php echo htmlspecialchars($edit ? $parking_lot['pl_geojson'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Haritadan konum seçin.." onkeydown="return false;" class="form-control" style="caret-color: transparent !important;" required>
        </div>

        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning" >Kaydet <span class="glyphicon glyphicon-send"></span></button>
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


      <?php
        $obj = json_decode($parking_lot['pl_geojson']);
        $cords = $obj->{'geometry'}->{'coordinates'};
        echo "map.flyTo([".$cords[1].",".$cords[0]."], 13);";
        echo "var geojsonLayer =L.geoJSON(JSON.parse('".$parking_lot['pl_geojson']."'));
                geojsonLayer.eachLayer(
                    function(l){
                        drawnItems.addLayer(l);
                });";
      ?>

      map.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;

        drawnItems.clearLayers();
        drawnItems.addLayer(layer);

        var shape = layer.toGeoJSON()
        var shape_for_db = JSON.stringify(shape);

        $('#pl_geojson').val(shape_for_db);
      });

</script>


<?php include_once 'includes/footer.php'; ?>
<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

$pl_id = filter_input(INPUT_GET, 'pl_id');
//Serve POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize input post if we want
    $data_to_update = filter_input_array(INPUT_POST);

    $db = getDbInstance();
    $db->where('pl_id', $pl_id);
    $row2 = $db->getOne('parking_lot');

    $current_time = strtotime( date('y-m-d H:i:s', strtotime('+2 hours')));

    $data_to_update['enter_date'] = str_replace("T", " ", $data_to_update['enter_date']);
    if (strtotime( $data_to_update['enter_date']) > $current_time ) {
        $_SESSION['failure'] = "Giriş Tarihi doğru girilmeli";
        header('location: pl_log.php?pl_id='.$pl_id);
        exit;
    }

    if($data_to_update['exit_date']){
        $data_to_update['exit_date'] = str_replace("T", " ", $data_to_update['exit_date']);
    
        $phpdate1 = strtotime( $data_to_update['enter_date'] );
        $phpdate2 = strtotime( $data_to_update['exit_date'] );
    
        if (!$row2 || $phpdate1 > $phpdate2 || $phpdate2 > $current_time) {
    
            $_SESSION['failure'] = "Giriş tarihi ve çıkış tarihi doğru girilmeli!";
    
            header('location: pl_log.php?pl_id='.$pl_id);
            exit;
        } 
    
        //Check whether the user name already exists ;
        $db = getDbInstance();
    
        $data = Array (
            'cpl_pl_id' => $pl_id,
            'cpl_car_plate' => $data_to_update['car_plate'],
            'cpl_enter_date' => $data_to_update['enter_date'],
            'cpl_exit_date' => $data_to_update['exit_date'],
            'cpl_total_payment' => (($phpdate2-$phpdate1)/3600)*$row2['pl_hourly_rate'],
        );
    
        $id = $db->insert ('car_parking_logs', $data);
        if ($id) {
            $_SESSION['success'] = "Otopark kaydı başarılı bir şekilde eklendi";
        } else {
            $_SESSION['failure'] = "Ekleme yapılırken hata alındı: " . $db->getLastError();
        }
    } else {
        $data = Array (
            'cpl_pl_id' => $pl_id,
            'cpl_car_plate' => $data_to_update['car_plate'],
            'cpl_enter_date' => $data_to_update['enter_date']
        );

        $db = getDbInstance();
        $db->startTransaction();
        $db->where('pl_id', $pl_id);
        $row3 = $db->update('parking_lot', Array ('pl_size' => $db->inc(1)));

        $id = $db->insert('car_parking_logs', $data);

        if ($row3 && $id) {
            $db->commit();
            
            $_SESSION['success'] = "Otopark kaydı başarılı bir şekilde eklendi";
        } else {
            $db->rollback();
            $_SESSION['failure'] = "Otopark kapasitesi dolu";
        }
    }

    header('location: pl_log.php?pl_id='.$pl_id);
    exit;

}

// import header
require_once 'includes/header.php';
?>


<div id="page-wrapper">

    <div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Yeni Otopark Ekle</h2>
        </div>

    </div>
    <?php include_once 'includes/flash_messages.php';?>
    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">
        <div class="form-group">
            <label for="car_plate">Araç Plakası</label>
            <input maxlength="8" name="car_plate" value="" placeholder="Plakayı Giriniz" class="form-control" required="required" id="car_plate">
        </div>

        <div class="form-group">
            <label for="enter_date">Otopark Giriş Tarihi</label>
            <input type="datetime-local" name="enter_date" class="form-control" required="required" id="enter_date">
        </div>

        <div class="form-group">
            <label for="exit_date">Otopark Çıkış Tarihi</label>
            <input type="datetime-local" name="exit_date" class="form-control" id="exit_date">
        </div>

        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning" >Oluştur <span class="glyphicon glyphicon-send"></span></button>
        </div>       
    </form>
</div>

<?php include_once 'includes/footer.php';?>
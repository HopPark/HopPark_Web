<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$cpl_id = filter_input(INPUT_POST, 'cpl_id');
$car_plate = filter_input(INPUT_POST, 'car_plate');
$db = getDbInstance();

// Delete a user using user_id
if ($cpl_id && $car_plate && $_SERVER['REQUEST_METHOD'] == 'POST') {

    try { 
        $data_to_update = array();
        $data_to_update['cpl_exit_date'] = date('y-m-d H:i:s', strtotime('+2 hours'));

        $db = getDbInstance();
        $db->where('cpl_id', $cpl_id);
        $db->where('cpl_car_plate', $car_plate);
        $db->where('cpl_exit_date', NULL, 'IS');
        $row = $db->getOne('car_parking_logs');

        if ($row != null) {
            $db = getDbInstance();
            $db->where('pl_id', $row['cpl_pl_id']);
            $row2 = $db->getOne('parking_lot');

            $phpdate1 = strtotime( $row['cpl_enter_date'] );
            $phpdate2 = strtotime( $data_to_update['cpl_exit_date'] );

            $db = getDbInstance();
            $db->startTransaction();
            $db->where('cpl_id', $row['cpl_id']);

            $data_to_update['cpl_total_payment'] = (($phpdate2-$phpdate1)/3600)*$row2['pl_hourly_rate'];
            $row3 = $db->update('car_parking_logs', $data_to_update);

            $db->where('pl_id', $row['cpl_pl_id']);
            $row4 = $db->update('parking_lot', Array ('pl_size' => $db->inc(-1)));

            if($row3 && $row4){
                $db->commit();
                
                $_SESSION['success'] = "Araç çıkışı yapıldı.";
                header('location: pl_log.php?pl_id='.$row['cpl_pl_id']);
                exit;
            } else {
                $db->rollback();
                $_SESSION['failure'] = "Hata alındı : " . $db->getLastError();
            }

        } else {
            $_SESSION['failure'] = 'Hata alındı! Kayıt bulunamadı';
        }

    } catch (Exception $e) {
        $_SESSION['failure'] = $e->getMessage().'Bilinmeyen hata oluştu! Destek kısmından iletişime geçin.';
    }

    header('location: pl_logs.php');
    exit;
}
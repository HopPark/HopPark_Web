<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
$passive = filter_input(INPUT_POST, 'passive');
 $db = getDbInstance();

// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($passive) {
        $data = Array (
            'pl_is_active' => $db->not()
        );
    } else {
        $data = Array (
            'pl_is_deleted' => 1
        );
    }

    $db->where('pl_id', $del_id);
    $stat = $db->update('parking_lot', $data);
    if ($stat) {
        if ($passive)
            $_SESSION['success'] = "Seçilen otoparkın aktiflik durumu güncellendi.";
        else
            $_SESSION['success'] = "Otopark silindi.";
    } else {
        $_SESSION['failure'] = "Hata alındı : " . $db->getLastError();
    }
    header('location: parking_lots.php');
    exit;
}
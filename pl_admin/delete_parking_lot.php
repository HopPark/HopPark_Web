<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
 $db = getDbInstance();

// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = Array (
        'pl_is_active' => 0
    );

    $db->where('pl_id', $del_id);
    $stat = $db->update('parking_lot', $data);
    if ($stat) {
        $_SESSION['success'] = "Otopark pasif hale getirilmiştir.";
    } else {
        $_SESSION['failure'] = "Hata alındı : " . $db->getLastError();
    }
    header('location: parking_lots.php');
    exit;
}
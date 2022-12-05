<?php
require_once './config/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = filter_input(INPUT_POST, 'username');
    $password = encode(filter_input(INPUT_POST, 'passwd'));

	//echo password_verify('admin', '$2y$10$RnDwpen5c8.gtZLaxHEHDOKWY77t/20A4RRkWBsjlPuu7Wmy0HyBu'); exit;

	//Get DB instance.
	$db = getDbInstance();

	$db->where("plo_username", $username);
    $db->where('plo_password', $password);

	$row = $db->getOne('pl_owners');

	if ($row != null) {
        $user_id = $row['plo_id'];

        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['admin_type'] = $row['admin_type'];
        $_SESSION['user_id'] = $user_id;

        //Authentication successfull redirect user
        header('Location:index.php');

		exit;
	} else {
		$_SESSION['toast_msg'] = "Kullanıcı Adı ya da şifre hatalı!";
		header('Location:login.php');
		exit;
	}

}
else {
	die('Method Not allowed');
}
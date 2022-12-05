<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE)
{
    header('Location:index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name');
    $mail = filter_input(INPUT_POST, 'mail');
    $phone = filter_input(INPUT_POST, 'phone');
    $username = filter_input(INPUT_POST, 'username');
    $password = encode(filter_input(INPUT_POST, 'passwd'));

    $db = getDbInstance();

    $db->where("plo_username", $username);
    $db->orwhere("plo_mobile", $phone);
    $db->orwhere("plo_email", $mail);

    $row = $db->getOne('pl_owners');

    if ($row == null) {
      $data = Array (
          'plo_name' => $name,
          'plo_mobile' => $phone,
          'plo_email' => $mail,
          'plo_username' => $username,
          'plo_password' => $password,
          'admin_type' => "admin",
      );

      $id = $db->insert ('pl_owners', $data);
      if ($id) {
          $_SESSION['toast_msg'] = "Kayıt başarılı bir şekilde gerçekleşti";
      } else {
          $_SESSION['toast_msg'] = "Kayıt yapılırken hata alındı: " . $db->getLastError();
      }
    } 
    else {
        $_SESSION['toast_msg'] = "Kullanıcı bilgileri kayıtlı!";
    }
}

//include BASE_PATH.'/includes/header.php';
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>HopPark Otopark Yönetici Girişi</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./styleToast.css">
</head>
<body>
<!-- partial:index.partial.html -->
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css"><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
  </head>
  <body>
        <?php if (isset($_SESSION['toast_msg'])): ?>
        <div id="toast"><div id="img"></div><div id="desc">
          <?php
          echo $_SESSION['toast_msg'];
          ?>
        </div></div>
        <?php endif; ?>

    <div class="main">
      <div class="container a-container is-txl" id="a-container">
        <form class="form" id="a-form" method="POST" action="">
          <h2 class="form_title title">Hesap Oluştur</h2>
          <input class="form__input" type="text" placeholder="İsim Soyisim" name="name" required="required">
          <input class="form__input" type="text" placeholder="Mail" name="mail" required="required">
          <input class="form__input" type="text" placeholder="Telefon Numarası" name="phone" required="required">
          <input class="form__input" type="text" placeholder="Kullanıcı Adı" name="username" required="required">
          <input class="form__input" type="password" placeholder="Şifre" name="passwd" required="required">
          <button type="submit" class="form__button button">KAYIT OL</button>
        </form>
      </div>
      <div class="container b-container is-txl is-z200" id="b-container">
        <form class="form" id="b-form" method="POST" action="authenticate.php">
          <h2 class="form_title title">HopPark'a Giriş</h2>
          <input class="form__input" type="text" placeholder="Kullanıcı Adı" name="username" required="required">
          <input class="form__input" type="password" placeholder="Şifre" name="passwd" required="required"><a class="form__link">Şifreni mi Unuttun?</a>
          <button type="submit" class="form__button button" >GİRİŞ YAP</button>
        </form>
      </div>
      <div class="switch is-txr" id="switch-cnt">
        <div class="switch__circle is-txr"></div>
        <div class="switch__circle switch__circle--t is-txr"></div>
        <div class="switch__container is-hidden" id="switch-c1">
          <h2 class="switch__title title">Hoşgeldiniz !</h2>
          <p class="switch__description description">Lütfen kişisel bilgilerinizle giriş yapın</p>
          <button class="switch__button button switch-btn">GİRİŞ YAP</button>
        </div>
        <div class="switch__container" id="switch-c2">
          <h2 class="switch__title title">Merhaba!</h2>
          <p class="switch__description description">Kişisel bilgilerinizi girin ve bizimle yolculuğa başlayın</p>
          <button class="switch__button button switch-btn">KAYIT OL</button>
        </div>
      </div>
    </div>
    <script src="main.js"></script>
  </body>
</html>
<!-- partial -->
  <script  src="./script.js"></script>
  <script type="text/javascript">
    function launch_toast() {
        var x = document.getElementById("toast")
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
    }
    <?php 
    if (isset($_SESSION['toast_msg']))
      echo "launch_toast();";
      unset($_SESSION['toast_msg']);
    ?>
    
  </script>

</body>
</html>

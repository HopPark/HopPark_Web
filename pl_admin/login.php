<?php
session_start();
require_once 'config/config.php';
$token = bin2hex(openssl_random_pseudo_bytes(16));

// If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE)
{
    header('Location:index.php');
}


//include BASE_PATH.'/includes/header.php';
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>HopPark Otopark Yönetici Girişi</title>
  <link rel="stylesheet" href="./style.css">

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
    <div class="main">
      <div class="container a-container" id="a-container">
        <form class="form" id="a-form" method="" action="">
          <h2 class="form_title title">Hesap Oluştur</h2>
          <input class="form__input" type="text" placeholder="İsim Soyisim">
          <input class="form__input" type="text" placeholder="Mail">
          <input class="form__input" type="password" placeholder="Şifre">
          <button class="form__button button submit">KAYIT OL</button>
        </form>
      </div>
      <div class="container b-container" id="b-container">
        <form class="form" id="b-form" method="POST" action="authenticate.php">
          <h2 class="form_title title">HopPark'a Giriş</h2>
          <input class="form__input" type="text" placeholder="Kullanıcı Adı" name="username">
          <input class="form__input" type="password" placeholder="Şifre" name="passwd"><a class="form__link">Şifreni mi Unuttun?</a>
          <button type="submit" class="form__button button" >GİRİŞ YAP</button>
        </form>
      </div>
      <div class="switch" id="switch-cnt">
        <div class="switch__circle"></div>
        <div class="switch__circle switch__circle--t"></div>
        <div class="switch__container" id="switch-c1">
          <h2 class="switch__title title">Hoşgeldiniz !</h2>
          <p class="switch__description description">Lütfen kişisel bilgilerinizle giriş yapın</p>
          <button class="switch__button button switch-btn">GİRİŞ YAP</button>
        </div>
        <div class="switch__container is-hidden" id="switch-c2">
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

</body>
</html>

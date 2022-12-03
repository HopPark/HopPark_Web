<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$edit = true;

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);

    $db = getDbInstance();
    $db->where('plo_username', $data_to_update['plo_username']);
    $db->where('plo_id', $_SESSION['user_id'], '!=');
    $row = $db->getOne('pl_owners');

    if (!empty($row['plo_username'])) {
        $_SESSION['failure'] = "Kullanıcı adı zaten kullanılıyor. Başka bir kullanıcı adı deneyiniz";
        header('location: profile.php' );
        exit;
    }

    if ($data_to_update['password'] == '')
        unset($data_to_update['password']);
    else{
        $data_to_update['plo_password'] = encode($data_to_update['password']);
        unset($data_to_update['password']);
    }

    $db = getDbInstance();
    $db->where('plo_id', $_SESSION['user_id']);
    $stat = $db->update('pl_owners', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Profil başarılı bir şekilde güncellendi!";
    }
    else
    {
        $_SESSION['failure'] = "Güncelleme başarısız: " . $db->getLastError();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db = getDbInstance();
    $db->where('plo_id', $_SESSION['user_id']);
    //Get data to pre-populate the form.
    $plo = $db->getOne("pl_owners");

} else {
    header('location: index.php');
    exit();
}
?>


<?php
    include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Profil Bilgilerini Güncelleme</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="contact_form">

        <div class="form-group">
            <label class="col-md-4 control-label" for="plo_name">İsim Soyisim</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                    <input maxlength="30" name="plo_name" value="<?php echo htmlspecialchars($edit ? $plo['plo_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="İsminizi Giriniz" class="form-control" required="required" id="plo_name">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="plo_mobile">Telefon Numarası</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                    <input maxlength="10" name="plo_mobile" value="<?php echo htmlspecialchars($edit ? $plo['plo_mobile'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Telefon Numarası Giriniz" class="form-control" required="required" id="plo_mobile">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="plo_email">Email</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input maxlength="40" name="plo_email" value="<?php echo htmlspecialchars($edit ? $plo['plo_email'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Email Giriniz" class="form-control" required="required" id="plo_email">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="plo_username">Kullanıcı Adı</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input maxlength="20" name="plo_username" value="<?php echo htmlspecialchars($edit ? $plo['plo_username'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Kullanıcı Adı Giriniz" class="form-control" required="required" id="plo_username">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Şifre</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input maxlength="20" name="password" value="" placeholder="Şifre Giriniz" class="form-control" id="password">
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning" >Kaydet <span class="glyphicon glyphicon-send"></span></button>
        </div>

    </form>
</div>




<?php include_once 'includes/footer.php'; ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>HopPark Administrator</title>

        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="assets/css/bootstrap.min.css"/>

        <!-- MetisMenu CSS -->
        <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="assets/js/jquery.min.js" type="text/javascript"></script>

        <?php echo (str_contains(CURRENT_PAGE, "add_parking_lot.php") || str_contains(CURRENT_PAGE, "edit_parking_lot.php")) ?
            '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
          crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin=""></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>' : ''; ?>

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true): ?>
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="">HopPark Otopark Yönetim Paneli</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <!-- /.dropdown -->

                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> Profil</a>
                                </li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Ayarlar</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Çıkış Yap</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Kontrol Paneli</a>
                                </li>

                                <li <?php echo (CURRENT_PAGE == "parking_lots.php" || CURRENT_PAGE == "add_parking_lot.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-user-circle fa-fw"></i> Otoparklarım<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="parking_lots.php"><i class="fa fa-list fa-fw"></i>Tümünü Listele</a>
                                        </li>
                                        <li>
                                            <a href="parking_lots.php?active=1"><i class="fa fa-plus-circle fa-fw"></i>Aktif Otoparkları Listele</a>
                                        </li>
                                        <li>
                                            <a href="parking_lots.php?active=-1"><i class="fa fa-minus-circle fa-fw"></i>Pasif Otoparkları Listele</a>
                                        </li>
                                        <li>
                                            <a href="add_parking_lot.php"><i class="fa fa-plus fa-fw"></i>Yeni Ekle</a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "pl_logs.php" || str_contains(CURRENT_PAGE, "pl_log.php")) ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-car fa-fw"></i> Otopark Kayıtları<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="pl_logs.php"><i class="fa fa-address-card-o fa-fw"></i> Otopark Seç</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
            <?php endif;?>
            <!-- The End of the Header -->
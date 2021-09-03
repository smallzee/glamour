<?php
    admin_is_required_to_login();
    $name = explode(" ",admin_detail('fname'))[0];
     $current_date = date('m/d/Y');
    $sn = 1;

    $sql_city = $db->query("SELECT id,state_id,name FROM ".DB_PREFIX."city ORDER BY name");
    while ($rs_city = $sql_city->fetch(PDO::FETCH_ASSOC)) {
        $all_cities[] = $rs_city;
    }

    $sql_area = $db->query("SELECT id,city_id,name FROM ".DB_PREFIX."area ORDER BY name");
    while ($rs_area = $sql_area->fetch(PDO::FETCH_ASSOC)){
        $all_areas[] = $rs_area;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta property="og:locale" content="en_US">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= page_title(@$page_title); ?></title>
    <!-- Font Awesome -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/morris.js/morris.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES ?>uploading-lib/dist/image-uploader.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>plugins/pace/pace.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES ?>dist/css/bootstrap-datepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.5.0/sweet-alert.css">
    <!-- folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('admin/css/style.css') ?>">
</head>
<?php
if(isset($_COOKIE['design-skin'])){
    $skin = $_COOKIE['design-skin'];
}else{
    $skin = "blue";
}
?>
<body class="hold-transition skin-<?= $skin ?> sidebar-mini" style="font-size: 15px;">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?= base_url() ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b><?= WEB_SUB_TITLE ?></b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b><?= WEB_TITLE ?></b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= adorable_avatar($name) ?>" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= admin_detail('fname') ?> (<?= role(admin_detail('role')) ?>)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= adorable_avatar($name) ?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= $name ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home text-blue"></i> <span>Dashboard</span></a></li>

                    <li><a href="<?= base_url('admin/role') ?>"><i class="fa fa-users text-grey"></i> <span>Role</span></a></li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-calendar-check-o text-warning"></i> <span>Events</span>
                            <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('admin/past-event')  ?>"><i class="fa fa-circle-o-notch"></i> Past Events</a></li>
                            <li><a href="<?= base_url('admin/create-event')  ?>"><i class="fa fa-circle-o-notch"></i>Create Event</a></li>
                            <li><a href="<?= base_url('admin/upcoming-event') ?>"><i class="fa fa-circle-o-notch"></i> Upcoming Event(s)</a></li>
                            <li><a href="<?= base_url('admin/upcoming-event-calendar') ?>"><i class="fa fa-circle-o-notch"></i> Upcoming Event(s) Calendar</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-calendar-check-o text-green"></i> <span>Events Venue</span>
                            <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('admin/event-venue')  ?>"><i class="fa fa-circle-o-notch"></i> Event Venue</a></li>
                            <li><a href="<?= base_url('admin/event-type')  ?>"><i class="fa fa-circle-o-notch"></i> Event Type</a></li>
                            <li><a href="<?= base_url('admin/venue-type') ?>"><i class="fa fa-circle-o-notch"></i> Venue Type</a></li>
                            <li><a href="<?= base_url('admin/amenities') ?>"><i class="fa fa-circle-o-notch"></i> Event Amenities</a></li>
                            <li><a href="<?= base_url('admin/create-event-venue') ?>"><i class="fa fa-circle-o-notch"></i> Create Event Venue</a></li>
                        </ul>
                    </li>


                    <li><a href="<?= base_url('admin/admin') ?>"><i class="fa fa-users text-purple"></i> <span>Administrative</span></a></li>


                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-calendar-o text-aqua"></i> <span> Event Professional</span>
                            <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('admin/professional-type')  ?>"><i class="fa fa-circle-o-notch"></i> Event Professional Type</a></li>
                            <li><a href=""><i class="fa fa-circle-o-notch"></i> All Event Professionals</a></li>
                            <li><a href="<?= base_url('admin/')  ?>"><i class="fa fa-circle-o-notch"></i>Create Event Professional</a></li>
                        </ul>
                    </li>

                    <li><a href="<?= base_url('admin/users') ?>"><i class="fa fa-users text-yellow"></i> <span>All Registered Users</span></a></li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-map-marker text-info"></i> <span> Event Venue Location</span>
                            <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('admin/city')  ?>"><i class="fa fa-circle-o-notch"></i> Cities</a></li>
                            <li><a href="<?= base_url('admin/state')  ?>"><i class="fa fa-circle-o-notch"></i> States</a></li>
                            <li><a href="<?= base_url('admin/area')  ?>"><i class="fa fa-circle-o-notch"></i> Area</a></li>
                        </ul>
                    </li>

                    <li><a href="<?= base_url('admin/users') ?>"><i class="fa fa-credit-card text-success"></i> <span>Venue Payment Transactions</span></a></li>
                    <li><a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out text-red"></i> <span>Logout</span></a></li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $page_title ?>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active"><?= $page_title ?></li>
                </ol>
            </section>
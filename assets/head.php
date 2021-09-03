<?php
    $name = explode(" ",user_details('fname'))[0];
    $user_id = user_details('id');
    $current_date = date('m/d/Y');
    $sn = 1;
    user_is_required_to_login();
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
    <title><?= page_title($page_title); ?></title>
   <!-- Font Awesome -->
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>dist/css/bootstrap-tagsinput.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.13.14/jquery.timepicker.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/morris.js/morris.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>plugins/pace/pace.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.5.0/sweet-alert.css">
    <!-- folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES?>uploading-library/dist/image-uploader.min.css">
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
                            <span class="hidden-xs"><?= user_details('fname') ?></span>
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
                <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-home text-blue"></i> <span>Dashboard</span></a></li>
                <li><a href="<?= base_url('join-event') ?>"><i class="fa fa-calendar-check-o text-yellow"></i> <span>Join Event</span></a></li>
                <li><a href="<?= base_url('past-event') ?>"><i class="fa fa-calendar text-green"></i> <span>Past Event</span></a></li>
                <li><a href="<?= base_url('my-event') ?>"><i class="fa fa-calendar-check-o"></i> My Event(s)</a></li>
                <li><a href="<?= base_url('gallery') ?>"><i class="fa fa-image text-white"></i> <span>My Gallery</span></a></li>         <li><a href="<?= base_url('my-event') ?>"><i class="fa fa-home text-purple"></i> <span>Requested Venues</span></a></li>
                <li><a href="<?= base_url('ongoing-event') ?>"><i class="fa fa-calendar text-aqua"></i> <span>Upcoming Events</span></a></li>
                <li><a href="<?= base_url('payment') ?>"><i class="fa fa-credit-card text-primary"></i> <span>Payment Transactions</span></a></li>
                <li><a href="<?= base_url('order-venue') ?>"><i class="fa fa-calendar-check-o"></i> Ordered Event Venue(s)</a></li>
                <li><a href="<?= base_url('calendar') ?>"><i class="fa fa-calendar-plus-o text-pink"></i> <span>Upcoming Events Calendar</span></a></li>
                <li><a href="<?= base_url('logout') ?>"><i class="fa fa-sign-out text-red"></i> <span>Logout</span></a></li>
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
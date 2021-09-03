<?php
    $sql_city = $db->query("SELECT id,state_id,name FROM ".DB_PREFIX."city ORDER BY name");
    while ($rs_city = $sql_city->fetch(PDO::FETCH_ASSOC)) {
        $all_cities[] = $rs_city;
    }

    $sql_area = $db->query("SELECT id,city_id,name FROM ".DB_PREFIX."area ORDER BY name");
    while ($rs_area = $sql_area->fetch(PDO::FETCH_ASSOC)){
        $all_areas[] = $rs_area;
    }
?>
<!Doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find and Book the best event venues, hotel halls, Conference and Meeting Rooms at the cheapest rate in any city across Nigeria" />
    <meta name="keywords" content="events in Nigeria, Free Venue, events venues in Nigeria, Finder, conference rooms in Nigeria, meeting rooms in Nigeria, event venues, search venues, weddings, events, venues, hotels, deals, engagement, cheap, wedding websites, discount, Event halls, fully Serviced Office Spaces, Coworking Spaces and meeting room" />
    <meta name="author" content="Tech4all" />
    <meta name="website" content="<?= WEB_TITLE ?>" />
    <title>
       <?= page_title(@$page_title); ?>
    </title>
    <!-- favicon -->
    <!-- Bootstrap -->
    <link href="<?= HTML_BASE_TEMPLATE ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="<?= HTML_BASE_TEMPLATE ?>css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.7/css/unicons.css">

    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATES ?>dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.13.14/jquery.timepicker.min.css">
    <!-- Magnific -->
    <link href="<?= HTML_BASE_TEMPLATE ?>css/magnific-popup.css" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATE ?>css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATE ?>css/owl.theme.default.min.css"/>
    <!-- FLEXSLIDER -->
    <link href="<?= HTML_BASE_TEMPLATE ?>css/flexslider.css" rel="stylesheet" type="text/css" />
    <!-- Date picker -->
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATE ?>css/flatpickr.min.css">
    <link rel="stylesheet" href="<?= HTML_BASE_TEMPLATE ?>lightslider/lightslider.css">
    <!-- Animation -->
    <link href="<?= HTML_BASE_TEMPLATE ?>css/animate.css" rel="stylesheet" />
    <link href="<?= HTML_BASE_TEMPLATE ?>css/animations-delay.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <!-- Main Css -->
    <link href="<?= HTML_BASE_TEMPLATE ?>css/style.css" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="<?= HTML_BASE_TEMPLATE ?>css/colors/default.css" rel="stylesheet" id="color-opt">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <style>
        #topnav.nav-sticky, #topnav{
            box-shadow: 0 0 9px rgba(60, 72, 88, 0.15);
            padding: 10px;
        }
    </style>
</head>
<body>

<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
</div>
<!-- Loader -->


<!-- Navbar STart -->
<header id="topnav" class="defaultscroll sticky bg-white">
    <div class="container">
        <!-- Logo container-->
        <div>
            <a class="logo" href="<?= base_url() ?>">
               <span><?= WEB_TITLE ?></span>
            </a>
        </div>

        <!-- End Logo container-->
        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <div class="buy-button">
            <?php if(!is_user_login()):  ?>
                <a href="<?= base_url('login') ?>" class="btn btn-primary"><i class="mdi mdi-account"></i> Login / Register</a>
            <?php endif; ?>
            <?php if (is_user_login()): ?>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-primary"><i class="mdi mdi-account"></i> <?= user_details('fname')  ?> (Dashboard)</a>
            <?php endif; ?>
        </div>

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li><a href="<?= base_url('') ?>"><i class="mdi mdi-home"></i> Home</a></li>
                <li><a href="<?= base_url('venues') ?>"><i class="mdi mdi-calendar"></i> Browse Event Venues</a></li>
                <li><a href="<?= base_url('about-us') ?>"><i class="mdi mdi-information-variant"></i> About Us</a></li>
                <li><a href="<?= base_url('contact-us'); ?>"><i class="mdi mdi-headphones-settings"></i> Contact Us</a></li>

            </ul><!--end navigation menu-->

        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->

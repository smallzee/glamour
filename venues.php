<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/1/2020
 * Time: 1:32 PM
 */
$page_title = "Event Venues Listing";
require_once 'core/core.php';
require_once 'libs/head.php';
?>

<!-- Hero Start -->
<section class="bg-half bg-light d-table w-100" style="background-image: url('<?=img_url('bg05.jpg') ?>')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <h4 class="title text-white"> <?= $page_title ?> </h4>
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= $page_title ?></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section><!--end section-->
<!--<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>-->
<!-- Hero End -->


<!--Blog Lists Start-->
<section class="section">
    <div class="container">
        <div class="row">

            <?php
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                } else {
                    $pageno = 1;
                }
                $no_of_records_per_page = 10;
                $offset = ($pageno-1) * $no_of_records_per_page;

                $sql_count_data = $db->query("SELECT * FROM ".DB_PREFIX."venue");
                $total_row = $sql_count_data->rowCount();

                $total_pages = ceil($total_row / $no_of_records_per_page);

                $sql_venue_data = $db->query("SELECT v.*, s.name as state_name, c.name as city_name, vt.name as venue_type_name FROM ".DB_PREFIX."venue as v INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."city as c INNER JOIN ".DB_PREFIX."venue_type as vt ON v.state_id = s.id and 
                v.city_id = c.id and v.venue_type = vt.id ORDER BY v.id DESC LIMIT $offset, $no_of_records_per_page");
                while ($rs = $sql_venue_data->fetch(PDO::FETCH_ASSOC)){
                    ?>

                    <div class="col-lg-6 col-12 mb-4 pb-2">
                        <div class="card blog rounded border-0 shadow overflow-hidden">
                            <div class="row align-items-center no-gutters">
                                <div class="col-md-6 order-2 order-md-1">
                                    <div class="card-body content">
                                        <h5><a href="<?= VIEW_VENUE.$rs['id'] ?>" class="card-title title text-dark"><?= limit_title($rs['title']) ?></a></h5>
                                        <p class="text-muted mb-0"><?= limit_title($rs['description']) ?></p>
                                        <div class="post-meta d-flex justify-content-between mt-3">
                                            <ul class="list-unstyled mb-0">
                                                <li class="list-inline-item mr-2 mb-0" style="font-size: 10px;"><a href="javascript:void(0)" class="text-muted like"><i class="mdi uil-users-alt"></i> Guests <?= number_format($rs['guest']) ?></a></li>
                                                <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="mdi mdi-map-marker mr-1"></i> <?= ucwords($rs['state_name']) ?></a></li>
                                            </ul>
                                        </div>
                                        <a href="<?= VIEW_VENUE.$rs['id'] ?>" style="margin-top: 20px;" class="text-muted readmore">Read More <i class="mdi mdi-chevron-right"></i></a>
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-6  order-1 order-md-2">
                                    <img src="<?= img_url($rs['image']) ?>" style="height: 200px; width: 100%" class="img-fluid" alt="">
                                    <div class="overlay bg-dark"></div>
                                    <div class="author">
                                        <small class="text-light user d-block"><i class="mdi mdi-account"></i> <?= ucwords($rs['state_name']. " , ". $rs['city_name']) ?></small>
                                        <small class="text-light date"><i class="mdi mdi-calendar-check"></i> <?= $rs['created_at']  ?></small>
                                    </div>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end blog post-->
                    </div><!--end col-->

                    <?php
                }

            ?>

            <div class="col-12">
                <ul class="pagination justify-content-center mb-0">

                </ul>
            </div><!--end col-->
        </div>
    </div>
</section>

<?php require_once 'libs/foot.php'?>

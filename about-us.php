<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/1/2020
 * Time: 3:22 PM
 */

$page_title = "About Developer";
require_once 'core/core.php';
require_once 'libs/head.php';
?>

<!-- Hero Start -->
<section class="bg-half bg-light d-table w-100" style="background-image: url('<?=img_url('background.jpg') ?>')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('')  ?>"><?= WEB_TITLE  ?></a></li>
                                <li class="breadcrumb-item"><a href="#"><?= $page_title ?></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section><!--end section-->
<!-- Hero End -->

<!-- Shape Start -->
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<!--Shape End-->

<!-- Start Contact -->
<section class="section pb-0">
    <div class="container mt-100 mt-60">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 mb-20">
                <div class="card shadow rounded border-0">
                    <div class="card-body py-5">
                        <h4 class="card-title text-center"><?= $page_title ?></h4>

                        <h5 >Supervisor Details</h5>

                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>Mrs. Onyeka N. C</td>
                            </tr>
                        </table>

                        <h5 >Student Details</h5>

                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>Olawale Segun Abayomi.</td>
                            </tr>
                            <tr>
                                <th>Matric Number</th>
                                <td>Hc20180104749</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td>Computer Science</td>
                            </tr>
                            <tr>
                                <th>Level</th>
                                <td>HND II DPT</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div><!--end col-->

        </div><!--end row-->
    </div><!--end container-->


    <?php require_once 'libs/foot.php';?>

<?php require_once 'libs/foot.php';?>

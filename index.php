<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/17/2020
 * Time: 2:15 PM
 */
require_once 'core/core.php';
require_once 'libs/head.php';
?>

<!-- Hero Start -->
<section class="main-slider">
    <ul class="slides">
        <?php
            $sql = $db->query("SELECT * FROM ".DB_PREFIX."venue ORDER BY RAND() LIMIT 0,3");
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                ?>
                <li class="bg-slider bg-animation-left d-flex align-items-center" style="background-image:url('<?= img_url($rs['image']) ?>')">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-7">
                                <div class="title-heading position-relative mt-4" style="z-index: 1;">
                                    <h1 class="heading mb-3"><?= $rs['title'] ?></h1>
                                    <p class="para-desc"><?= (strlen($rs['description']) > 150) ? substr($rs['description'],0,200).str_repeat(".",3) : $rs['description']; ?></p>
                                    <div class="watch-video mt-4 pt-2">
                                        <a href="book.php" class="btn btn-pills btn-soft-primary"><i class="mdi mdi-briefcase"></i> Event Book</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
            }
        ?>

    </ul>
</section><!--end section-->
<!-- Hero End -->



<div class="position-relative">
    <div class="shape overflow-hidden text-light">
        <svg viewBox="0 0 2880 250" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M720 125L2160 0H2880V250H0V125H720Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<section class="section bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-12 order-1 order-md-2">
                <img src="images/illustrator/user_interface.svg" class="img-fluid mx-auto d-block" alt="">
            </div><!--end col-->

            <div class="col-lg-7 col-md-7 col-12 order-2 order-md-1 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="section-title">
                    <h4 class="title mb-4">Available for your <br> Smartphones</h4>
                    <p class="text-muted para-desc mb-0">Start working with <span class="text-primary font-weight-bold"><?= WEB_TITLE  ?></span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                    <div class="my-4">
                        <a href="javascript:void(0)" class="btn btn-lg btn-dark mt-2"><i class="mdi mdi-google-play"></i> Play Store</a>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section>




<?php require_once 'libs/foot.php'?>

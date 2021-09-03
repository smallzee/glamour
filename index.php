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
                                        <a href="<?= VIEW_VENUE.$rs['id'];?>" class="btn btn-pills btn-soft-primary"><i class="mdi mdi-briefcase"></i> Book Now</a>
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

<!-- Partners start -->
<section class="section-two bg-light" id="bookroom">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form class="p-4 shadow bg-white rounded">
                    <h5 class="mb-3"><i class="mdi text-primary mdi-map-marker"></i> Find Event Centers in Nigeria !</h5>
                    <p><?= WEB_TITLE ?> venues is the best way to find & discover great local venues for your events!</p>
                    <div class="row text-left">
                        <div class="col-lg-6 col-md-6">
                            <div class="row align-content-center">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">State :</label>
                                        <select name="state" id="state" class="form-control">
                                            <option value="" disabled selected>Select</option>
                                            <?php
                                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."state ORDER BY name");
                                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">City :</label>
                                        <select class="form-control" required="" name="city" id="city">
                                            <option disabled="" selected="">Select</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Area :</label>
                                        <select name="area-id" id="area" required class="form-control">
                                            <option value="" selected disabled>Select</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div><!--end col-->

                        <div class="col-lg-5">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Number Of Guest : </label>
                                        <input type="number" min="0" autocomplete="off" id="adult" required="" class="form-control" placeholder="Number Of Guest">
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Event Venue Type : </label>
                                        <select name="event-type" class="form-control" required id="">
                                            <option value="" disabled selected>Select</option>
                                            <?php
                                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."venue_type ORDER BY name");
                                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-2 mt-2">
                                    <button class="searchbtn btn btn-pill btn-primary btn-block p" name="q" type="submit"><i class="fa fa-search"></i></button>
                                </div><!--end col-->
                            </div>
                        </div>
                    </div>
                </form>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- Partners End -->

<!-- News Start -->
<section class="section pt-5 pt-sm-0 pt-md-4 ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <div class="section-title mb-4 pb-2">
                    <h4 class="title mb-4" style="margin-top: 20px;" >Featured Event Venues</h4>
                    <div class="row">
                          <?php 
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."venue ORDER BY id DESC LIMIT 0,3");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                ?>

                                <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
                                    <div class="card blog rounded border-0 shadow overflow-hidden" style="height: 455px;">
                                        <div class="position-relative">
                                             <img src="<?= img_url($rs['image']);  ?>"  style="height: 240px;" class="card-img-top " alt="...">
                                            <div class="teacher d-flex align-items-center">
                                              <!--   <img src="images/client/01.jpg" class="avatar avatar-md-sm rounded-circle shadow" alt=""> -->
                                                <div class="ml-2">
                                                    <h6 class="mb-0"><a href="javascript:void(0)" class="text-light user">Dung Lewis</a></h6>
                                                    <p class="text-light small my-0">Professor</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body content">
                                            <h5 class="mt-2">
                                                <a href="<?= VIEW_VENUE.$rs['id']; ?>" class="title text-dark">
                                                <?= limit_title($rs['title'])  ?>
                                                </a>
                                            </h5>
                                            <p class="text-muted"><?=  limit_title($rs['description'])  ?></p>
                                            <a href="<?= VIEW_VENUE.$rs['id']; ?>" class="text-primary">Read More <i data-feather="chevron-right" class="fea icon-sm"></i></a>
                                            <ul class="list-unstyled d-flex justify-content-between border-top mt-3 pt-3 mb-0">
                                                <li class="text-muted small"><i data-feather="users" class="fea icon-sm text-info"></i> Guests <?= number_format($rs['guest']);  ?></li>
                                                <li class="text-muted small ml-3"> &#8358; <?= number_format($rs['price'])  ?></li>
                                            </ul>
                                        </div>
                                    </div> <!--end card / course-blog-->
                                </div><!--end col-->

                                <?php
                            }
                         ?>        
                    </div>
                
                </div>
            </div><!--end col-->
            <div class="row justify-content-center">
                <div class="col-12 text-center mt-4 pt-2">
                    <a href="<?= base_url('venues') ?>" class="btn btn-pills btn-soft-primary">See More <i class="mdi mdi-chevron-right"></i></a>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end row-->

    </div>
</section>

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

<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/1/2020
 * Time: 3:22 PM
 */

$page_title = "Contact Us";
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
                                        <li class="breadcrumb-item"><a href="#">Contact Us</a></li>
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
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card contact-detail text-center border-0">
                            <div class="card-body p-0">
                                <div class="icon">
                                    <img src="images/icon/bitcoin.svg" class="avatar avatar-small" alt="">
                                </div>
                                <div class="content mt-3">
                                    <h4 class="title font-weight-bold">Phone</h4>
                                    <p class="text-muted">Start working with <?= WEB_TITLE  ?> that can provide everything</p>
<!--                                    <a href="#" class="text-primary">+234</a>-->
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="card contact-detail text-center border-0">
                            <div class="card-body p-0">
                                <div class="icon">
                                    <img src="images/icon/Email.svg" class="avatar avatar-small" alt="">
                                </div>
                                <div class="content mt-3">
                                    <h4 class="title font-weight-bold">Email</h4>
                                    <p class="text-muted">Start working with <?= WEB_EMAIL  ?> that can provide you everything</p>
                                    <a href="mailto:contact@example.com" class="text-primary"><?= WEB_EMAIL  ?></a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                   
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0 order-2 order-md-1">
                        <div class="card shadow rounded border-0">
                            <div class="card-body py-5">
                                <h4 class="card-title">Get In Touch !</h4>
                                <div class="custom-form mt-4">
                                    <div id="message"></div>
                                    <form method="post" action="" name="contact-form" id="contact-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label>Your Name <span class="text-danger">*</span></label>
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input name="name" id="name" type="text" class="form-control pl-5" placeholder="First Name :">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label>Your Email <span class="text-danger">*</span></label>
                                                    <i data-feather="mail" class="fea icon-sm icons"></i>
                                                    <input name="email" id="email" type="email" class="form-control pl-5" placeholder="Your email :">
                                                </div> 
                                            </div><!--end col-->
                                            <div class="col-md-12">
                                                <div class="form-group position-relative">
                                                    <label>Subject</label>
                                                    <i data-feather="book" class="fea icon-sm icons"></i>
                                                    <input name="subject" id="subject" type="text" class="form-control pl-5" placeholder="Subject">
                                                </div>                                                                               
                                            </div><!--end col-->
                                            <div class="col-md-12">
                                                <div class="form-group position-relative">
                                                    <label>Comments</label>
                                                    <i data-feather="message-circle" class="fea icon-sm icons"></i>
                                                    <textarea name="comments" id="comments" rows="4" class="form-control pl-5" placeholder="Your Message :"></textarea>
                                                </div>
                                            </div>
                                        </div><!--end row-->
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary btn-block" value="Send Message">
                                                <div id="simple-msg"></div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form><!--end form--> 
                                </div><!--end custom-form-->
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-7 col-md-6 order-1 order-md-2">
                        <div class="card border-0">
                            <div class="card-body p-0">
                                <img src="images/contact.png" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->


<?php require_once 'libs/foot.php';?>

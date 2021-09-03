<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/1/2020
 * Time: 3:24 PM
 */

$page_title = "404";
require_once 'core/core.php';
require_once 'libs/head.php';
?>

<!-- COMING SOON PAGE -->
<section class="bg-home bg-animation-left dark-left d-flex align-items-center" data-jarallax='{"speed": 0.5}' style="background-image: url('images/comingsoon2.jpg');" id="home">
    <a id="video" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=NoZ8S3UgDh0',containment:'#home', showControls:false, autoPlay:true, loop:true, mute:true, startAt:0, opacity:1, quality:'default'}"></a>
    <div class="container position-relative text-md-left text-center" style="z-index: 1;">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-white">Error 404</h1>
                <h1 class="text-uppercase text-white title-dark mt-2 mb-4 coming-soon"><span class="element" data-elements="We're Coming soon..., We're Be Ready to, We're Connected with us "></span></h1>
                <p class="text-light para-dark para-desc">Start working with <span class="font-weight-bold"><?= WEB_TITLE ?></span> that can provide everything you need to for your events</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="countdown"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?= base_url('') ?>" class="btn btn-outline-primary mt-4"><i class="mdi mdi-backup-restore"></i> Go Back Home</a>
            </div>
        </div>
    </div> <!-- end container -->
</section>
<!-- COMING SOON PAGE -->



<?php require_once 'libs/foot.php';?>

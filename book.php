<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 10:03 AM
 */
$page_title = "Event Booking";
require_once 'core/core.php';
require_once 'assets/head.php';
?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page_title ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Event Type</label>
                            <select name="event_type" required id="event_type" class="form-control">
                                <option value="" disabled selected>Select</option>
                                <?php

                                    if (is_array($event_type_data) && count($event_type_data) > 0){
                                        foreach ($event_type_data as $value){
                                            ?>
                                            <option value="<?= $value['id'] ?>"><?= ucwords($value['name']) ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Event Planing Budget</label>
                            <input type="text" class="form-control" required readonly name="budget" id="budget" placeholder="Event Planing Budget">
                        </div>

                        <div class="form-group">
                            <label for="">Event Date</label>
                            <input type="date" min="<?= date('Y-m-d') ?>" class="form-control" name="event_date" placeholder="Event Date" id="">
                        </div>

                        <div class="form-group">
                            <label for="">Event Location</label>
                            <input type="text" name="location" class="form-control" required placeholder="Event Location" id="">
                        </div>

                        <div class="form-group">
                            <label for="">How Do You Want <?= WEB_TITLE ?> To Plan Your Event</label>
                            <textarea name="description" id="" required class="form-control" placeholder="How Do You Want <?= WEB_TITLE ?> To Plan Your Event" style="resize: none"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="plan" class="btn btn-primary" value="Proceed On Event Booking" id="">
                        </div>
                    </form>

                    <div class="text-center">
                        <img src="<?= image_url('remitaLogo.jpg') ?>" alt="">
                    </div>

                </div>
            </div>


        </div>
    </div>
</section>


<?php require_once 'assets/foot.php'?>



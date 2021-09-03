<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 10:03 AM
 */
$page_title = "Dashboard";
require_once 'core/core.php';
require_once 'assets/head.php';
?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-purple-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">My Events</h2>
                    <h4 class="info-box-number">
                        <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."manage_event WHERE user_id='$user_id'");
                            $total = $sql->rowCount();
                            echo $total;
                        ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-purple-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">My Active Events</h2>
                    <h4 class="info-box-number">
                        <?php
                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."manage_event WHERE user_id='$user_id' and event_date >='$current_date'");
                        $total = $sql->rowCount();
                        echo $total;
                        ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Upcoming Events</h2>
                    <h4 class="info-box-number">
                        <?= get_upcoming_events(); ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Past Events</h2>
                    <h4 class="info-box-number">
                        <?= get_past_events(); ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Ordered Event venues</h2>
                    <h4 class="info-box-number">
                        <?php
                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."order_venues WHERE user_id='$user_id' and verified !=0");
                        $total = $sql->rowCount();
                        echo $total;
                        ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>


    </div>
</section>
   

<?php require_once 'assets/foot.php'?>



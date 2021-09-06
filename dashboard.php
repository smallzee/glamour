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

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    Total Event Booking
                                </div>
                                <div class="panel-body">
                                    <h1 align="center">

                                        <?php
                                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."booking WHERE user_id='$user_id'");
                                            echo $sql->rowCount();
                                        ?>

                                    </h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    Total Event Booking Payment
                                </div>
                                <div class="panel-body">
                                    <h1 align="center">

                                        <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."transactions WHERE user_id='$user_id'");
                                        echo $sql->rowCount();
                                        ?>

                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
   

<?php require_once 'assets/foot.php'?>



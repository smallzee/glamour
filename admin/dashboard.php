<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 6:56 PM
 */

$page_title = "Dashboard";
require_once '../core/core.php';
require_once 'libs/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-sm-12"><?= flash(); ?></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-purple-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">All Registered Users</h2>
                    <h4 class="info-box-number">
                        <?php 
	                		$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role='1'");
	                		$total = $sql->rowCount();
	                		echo $total;
	                	 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">All Administrative</h2>
                    <h4 class="info-box-number">
                        <?php 
	                		$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role>1");
	                		$total = $sql->rowCount();
	                		echo $total;
	                	 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-green-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Role</h2>
                    <h4 class="info-box-number">
                       <?php 
	                		$sql = $db->query("SELECT * FROM ".DB_PREFIX."role");
	                		$total = $sql->rowCount();
	                		echo $total;
	                	 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Upcoming Event(s)</h2>
                    <h4 class="info-box-number">
                       <?php 
	                		$sql = $db->query("SELECT * FROM ".DB_PREFIX."manage_event WHERE event_date>='$current_date'");
	                		$total = $sql->rowCount();
	                		echo $total;
	                	 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-red-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Past Event(s)</h2>
                    <h4 class="info-box-number">
                       <?php 
	                		$sql = $db->query("SELECT * FROM ".DB_PREFIX."manage_event WHERE event_date<='$current_date'");
	                		$total = $sql->rowCount();
	                		echo $total;
	                	 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-green-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar-check-o"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">All Event(s)</h2>
                    <h4 class="info-box-number">
                       <?php 
	                		$sql = $db->query("SELECT * FROM ".DB_PREFIX."manage_event");
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

<?php require_once 'libs/foot.php'?>

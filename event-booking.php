<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-06
 * Time: 08:41
 */

$page_title = "Event Booking";
require_once 'core/core.php';
require_once 'assets/head.php';
?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $page_title ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>

            </div>
        </div>
        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Event Type</th>
                        <th>Event Date</th>
                        <th>Event Location</th>
                        <th>Description</th>
                        <th>Amount Paid</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Event Type</th>
                        <th>Event Date</th>
                        <th>Event Location</th>
                        <th>Description</th>
                        <th>Amount Paid</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $user_id = user_details('id');
                            $sn =1;
                            $sql = $db->query("SELECT b.*, et.name FROM ".DB_PREFIX."booking b INNER JOIN ".DB_PREFIX."event_type et ON b.event_type_id = et.id WHERE b.user_id='$user_id'");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $rs['name'] ?></td>
                                    <td><?= $rs['event_date'] ?></td>
                                    <td><?= $rs['event_location'] ?></td>
                                    <td><?= $rs['description'] ?></td>
                                    <td><?= $rs['amount_paid'] ?></td>
                                    <td><?= $rs['status'] ?></td>
                                    <td><a href="view-vendor.php?id=<?= $rs['id'] ?>" class="btn btn-primary btn-sm">View Vendors</a></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>


<?php require_once 'assets/foot.php';?>

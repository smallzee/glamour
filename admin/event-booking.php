<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-05
 * Time: 15:13
 */

$page_title = "Event Booking";
require_once '../core/core.php';
require_once 'libs/head.php';
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
                        <th>Client Name</th>
                        <th>Client Email Address</th>
                        <th>Client Phone Number</th>
                        <th>Event Type</th>
                        <th>Event Location</th>
                        <th>Event Date</th>
                        <th>Description</th>
                        <th>Amount Paid</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Client Name</th>
                        <th>Client Email Address</th>
                        <th>Client Phone Number</th>
                        <th>Event Type</th>
                        <th>Event Location</th>
                        <th>Event Date</th>
                        <th>Description</th>
                        <th>Amount Paid</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <?php
                    $sn =1;
                    $sql = $db->query("SELECT b.*, et.name, u.fname, u.phone, u.email FROM ".DB_PREFIX."booking b INNER JOIN ".DB_PREFIX."event_type et ON b.event_type_id = et.id INNER JOIN ".DB_PREFIX."users u ON b.user_id = u.id ");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= $rs['fname'] ?></td>
                            <td><?= $rs['email'] ?></td>
                            <td><?= $rs['phone'] ?></td>
                            <td><?= $rs['name'] ?></td>
                            <td><?= $rs['event_location'] ?></td>
                            <td><?= $rs['event_date'] ?></td>
                            <td><?= $rs['description'] ?></td>
                            <td><?= $rs['amount_paid'] ?></td>
                            <td><?= $rs['status']?></td>
                            <td><?= $rs['created_at'] ?></td>
                            <td><a href="view-event-booking.php?id=<?= $rs['id'] ?>" class="btn btn-primary btn-sm">View</a></td>
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

<?php require_once 'libs/foot.php';?>

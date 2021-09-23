<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-23
 * Time: 12:40
 */

$page_title = "Event Booking Information";
require_once 'core/core.php';
$id = $_GET['id'];
if (!isset($id)){
    redirect(base_url('dashboard.php'));
    return;
}

$user_id = user_details('id');
$sql = $db->query("SELECT b.*, et.name FROM ".DB_PREFIX."booking b INNER JOIN ".DB_PREFIX."event_type et ON b.event_type_id = et.id WHERE b.user_id='$user_id' and b.id='$id'");

if ($sql->rowCount() == 0){
    redirect(base_url('dashboard.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);
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

            <h5 class="page-header">Event Booking Information</h5>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Event Type</td>
                        <td><?= $data['name'] ?></td>
                    </tr>
                    <tr>
                        <td>Event Date</td>
                        <td><?= $data['event_date'] ?></td>
                    </tr>
                    <tr>
                        <td>Event Location</td>
                        <td><?= $data['event_location'] ?></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><?= $data['description'] ?></td>
                    </tr>
                    <tr>
                        <td>Amount Paid</td>
                        <td><?= amount_format($data['amount_paid']) ?></td>
                    </tr>
                   <tr>
                       <td>Status</td>
                       <td><?= $data['status'] ?></td>
                   </tr>
                </table>
            </div>

            <h5 class="page-header">Vendor Information</h5>

            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Profession</th>
                        <th>Venue Capacity</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Profession</th>
                        <th>Venue Capacity</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT vb.*, v.profession, v.capacity FROM ".DB_PREFIX."book_vendor vb INNER JOIN ".DB_PREFIX."vendor v ON vb.vendor_id = v.id WHERE vb.user_id='$user_id' and vb.booking_id='$id'");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= ucwords($rs['profession']) ?></td>
                                <td><?= $rs['capacity'] ?></td>
                                <td><?= amount_format($rs['amount']) ?></td>
                                <td><?= $rs['created_at'] ?></td>
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


<?php require_once 'assets/foot.php'?>

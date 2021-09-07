<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-05
 * Time: 15:13
 */

$page_title = "Event Booking";
require_once '../core/core.php';

$booking_id = $_GET['id'];
if (isset($booking_id) && empty($booking_id)){
    redirect(base_url('admin/dashboard.php'));
    return;
}

$sql = $db->query("SELECT b.*, et.name, u.fname, u.email, u.phone FROM ".DB_PREFIX."booking b
 INNER JOIN ".DB_PREFIX."event_type et ON b.event_type_id = et.id INNER JOIN ".DB_PREFIX."users u ON b.user_id = u.id
 WHERE b.id='$booking_id'");
if ($sql->rowCount() == 0){
    redirect(base_url('admin/dashboard.php'));
    return;
}

$rs = $sql->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['add'])){
    $vendor_id = $_POST['vendor_id'];
    $amount_paid = $_POST['amount_paid'];

    $db->query("INSERT INTO ".DB_PREFIX."vendor_event_booking (booking_id,vendor_id,amount_paid)VALUES('$booking_id','$vendor_id','$amount_paid')");
    set_flash("Vendor has been added for event successfully","info");
}

require_once 'libs/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Vendor</h4>
            </div>
            <div class="modal-body">

                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Vendor Name</label>
                        <select name="vendor_id" id="" class="form-control">
                            <option value="" disabled selected>Select</option>
                            <?php
                                $sql2 = $db->query("SELECT * FROM ".DB_PREFIX."vendor ORDER BY name");
                                while ($rs2 = $sql2->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $rs2['id'] ?>"><?= ucwords($rs2['name']) ?> ( <?= $rs2['profession'] ?>)</option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Amount Paid</label>
                        <input type="text" class="form-control" required placeholder="Amount Paid" name="amount_paid" id="">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit" id="">
                    </div>
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Main content -->
<section class="content">

    <?php flash() ?>
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

            <table class="table table-bordered" id="example1">
                <tr>
                    <td>Event Type</td>
                    <td><?= ucwords($rs['name']) ?></td>
                </tr>
                <tr>
                    <td>Event Location</td>
                    <td><?= $rs['event_location'] ?></td>
                </tr>
                <tr>
                    <td>Event Date</td>
                    <td><?= $rs['event_date'] ?></td>
                </tr>
                <tr>
                    <td>Client Name</td>
                    <td><?= $rs['fname'] ?></td>
                </tr>
                <tr>
                    <td>Client Email Address</td>
                    <td><?= $rs['email'] ?></td>
                </tr>
                <tr>
                    <td>Client Phone Number</td>
                    <td><?= $rs['phone'] ?></td>
                </tr>
                <tr>
                    <td>Event Description</td>
                    <td><?= $rs['description'] ?></td>
                </tr>
                <tr>
                    <td>Amount Paid</td>
                    <td><?= $rs['amount_paid'] ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?= $rs['status'] ?></td>
                </tr>
            </table>

            <a href="" class="btn btn-primary"  data-toggle="modal" data-target="#modal-default">Plan Event</a>

            <h5 class="page-header">Vendor Used For Event</h5>

            <div class="table-responsive">
                <table class="table table-bordered" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Vendor Name</th>
                        <th>Vendor Email Address</th>
                        <th>Vendor Phone Number</th>
                        <th>Vendor Address</th>
                        <th>Vendor Profession</th>
                        <th>Amount Paid For Vendor</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Vendor Name</th>
                        <th>Vendor Email Address</th>
                        <th>Vendor Phone Number</th>
                        <th>Vendor Address</th>
                        <th>Vendor Profession</th>
                        <th>Amount Paid For Vendor</th>
                        <th>Date</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sn =1;
                        $sql3 = $db->query("SELECT e_b.*, v.name, v.email, v.phone, v.address, v.profession FROM ".DB_PREFIX."vendor_event_booking e_b INNER JOIN ".DB_PREFIX."vendor v ON e_b.vendor_id = v.id ORDER BY e_b.id");
                        while ($rs3 = $sql3->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= $rs3['name'] ?></td>
                                <td><?= $rs3['email'] ?></td>
                                <td><?= $rs3['phone'] ?></td>
                                <td><?= $rs3['address'] ?></td>
                                <td><?= $rs3['profession'] ?></td>
                                <td><?= $rs3['amount_paid'] ?></td>
                                <td><?= $rs3['created_at'] ?></td>
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

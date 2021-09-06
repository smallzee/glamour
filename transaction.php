<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/16/2020
 * Time: 4:05 PM
 */

$page_title = "Payment Transactions";
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
                <table id="example1" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Event Type</th>
                        <th>Amount Paid</th>
                        <th>Reference</th>
                        <th>Payment Status</th>
                        <th>Created At</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Event Type</th>
                        <th>Amount Paid</th>
                        <th>Reference</th>
                        <th>Payment Status</th>
                        <th>Created At</th>
                        <th>Paid At</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT t.*, et.name FROM ".DB_PREFIX."transactions t INNER JOIN ".DB_PREFIX."booking b ON t.booking_id = b.id INNER JOIN ".DB_PREFIX."event_type et ON b.event_type_id = et.id WHERE t.user_id='$user_id'  ORDER BY t.id  DESC");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= $rs['name'] ?></td>
                                <td><?= amount_format($rs['amount']) ?></td>
                                <td><?= $rs['reference'] ?></td>
                                <td><?= $rs['status'] ?></td>
                                <td><?= $rs['created_at'] ?></td>
                                <td><?= $rs['paid_at'] ?></td>

                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<?php require_once 'assets/foot.php';?>

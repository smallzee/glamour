<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/26/2020
 * Time: 12:13 PM
 */

$page_title = "All Users";
require_once '../core/core.php';
require_permission('manage_users');
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
                <table id="datatables" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Account Status</th>
                        <th>Role</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Account Status</th>
                        <th>Role</th>
                        <th>Source</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role='1' ORDER BY id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= $rs['fname'] ?></td>
                            <td><?= $rs['email'] ?></td>
                            <td><?= $rs['phone'] ?></td>
                            <td><?= user_status($rs['status']) ?></td>
                            <td><?= role($rs['role']) ?></td>
                            <td><?= $rs['account_type'] ?></td>
                            <td><?= date('Y-m-d h:i:s:a',$rs['created_at']) ?></td>
                            <td><a href="<?= VIEW_PROFILE.$rs['id'] ?>" class="btn btn-primary btn-sm">View</a></td>
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


<?php require_once 'libs/foot.php';?>

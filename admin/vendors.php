<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-05
 * Time: 14:46
 */

$page_title = "All Registered Vendors";
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
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Profession</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Profession</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $sn =1;
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."vendor ORDER BY id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                        <td><?= $sn++ ?></td>
                                        <td><?= ucwords($rs['name']) ?></td>
                                        <td><?= $rs['email'] ?></td>
                                        <td><?= $rs['phone'] ?></td>
                                        <td><?= $rs['profession'] ?></td>
                                        <td><?= $rs['address'] ?></td>
                                        <td><?= $rs['created_at'] ?></td>
                                        <td><a href="edit-vendor.php?id=<?= $rs['id']; ?>" class="btn btn-primary btn-sm">Edit</a></td>
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
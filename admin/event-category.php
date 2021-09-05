<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:10 PM
 */
$page_title = "All Event Category";
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
                <table id="datatables" class="table table-bordered" >
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Budget</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Budget</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>

                    <tbody>
                    <?php
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type ORDER BY name");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= ucwords($rs['name']) ?></td>
                            <td><?= $rs['price'] ?></td>
                            <td><?= $rs['created_at'] ?></td>
                            <td><?= $rs['updated_at'] ?></td>
                            <td><a href="" class="btn btn-primary btn-sm">Edit</a></td>
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

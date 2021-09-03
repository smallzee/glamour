<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/16/2020
 * Time: 5:25 PM
 */
$page_title = "Event Professional Type";
require_once '../core/core.php';
require_permission('manage_event_professional');
require_once 'libs/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Event Professional Type</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Event Professional Type Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Event Professional Type Name" id="">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary btn-sm" value="Submit" id="">
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
            <button type="button" class="btn btn-primary" style="margin-bottom: 20px;" data-toggle="modal" data-target="#modal-default">
                Add New Event Professional Type
            </button>

            <div class="table-responsive">
                <table id="datatables" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_professional_type ORDER BY id DESC");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= ucwords($rs['name']) ?></td>
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

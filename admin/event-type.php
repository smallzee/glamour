<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:10 PM
 */
$page_title = "Event Type";
require_once '../core/core.php';
require_permission('manage_event_type');
if (isset($_POST['add'])){
    $name = strtolower($_POST['name']);
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type WHERE name='$name'");
    $num_row = $sql->rowCount();

    if ($num_row >= 1){
        set_flash("$name has already exist","danger");
    }else{
        $in = $db->query("INSERT INTO ".DB_PREFIX."event_type (name)VALUES('$name')");
        set_flash("$name has been added successfully","primary");
    }
        
}
require_once 'libs/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Event Type</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required="" placeholder="Name" name="name">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit" name="add">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


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

            <a href="#"  data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-sm" style="margin-bottom: 20px;">Add New Event Type</a>

            <?php flash(); ?>

            <div class="table-responsive">
                <table id="datatables" class="table table-bordered" >
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
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type ORDER BY name");
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

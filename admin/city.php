<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/26/2020
 * Time: 12:39 PM
 */

$page_title = "Event Venue Cities";
require_once '../core/core.php';
require_permission('manage_location');
if (isset($_POST['add'])){
   require_permission('create_new_city');
   $name = strtolower($_POST['name']);
   $state = $_POST['state'];
   $sql = $db->query("SELECT * FROM ".DB_PREFIX."city WHERE name='$name' and state_id='$state'");
   $num_row = $sql->rowCount();

   if ($num_row >= 1){
       set_flash("$name has already exist","danger");
   }else{
        $in = $db->query("INSERT INTO ".DB_PREFIX."city (name,state_id)VALUES('$name','$state')");
        set_flash("City has been added successfully","info");
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
                <h4 class="modal-title">Add New City</h4>
            </div>
            <div class="modal-body">
                <form method="post">

                    <div class="form-group">
                        <label>State</label>
                        <select class="form-control" name="state" required="">
                            <option disabled="" selected="">Select</option>
                            <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."state ORDER BY name");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $rs['id'] ?>"><?= ucfirst($rs['name'])  ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>City Name</label>
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

            <a href="#" data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-sm" style="margin-bottom: 20px;">Add New City</a>

            <?php flash(); ?>

            <div class="table-responsive">
                <table id="datatables" class="table  table-bordered ">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>State</th>
                        <th>City Name</th>
                        <th>Created At </th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>State</th>
                        <th>City Name</th>
                        <th>Created At </th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sql = $db->query("SELECT c.*, s.name as state_name 
                    FROM ".DB_PREFIX."city as c INNER JOIN ".DB_PREFIX."state as s ON c.state_id = s.id ORDER BY c.id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $sn++  ?></td>
                            <td><?= ucfirst($rs['state_name']) ?></td>
                            <td><?= ucfirst($rs['name'])  ?></td>
                            <td><?= $rs['created_at']  ?></td>
                            <td><?= $rs['updated_at']  ?></td>
                            <td><a href="<?= EDIT_CITY.$rs['id'] ?>" class="btn btn-primary btn-sm">Edit</a></td>
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

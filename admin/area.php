<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/26/2020
 * Time: 2:15 PM
 */

$page_title = "Event Venue Area";
require_once '../core/core.php';
require_permission('manage_location');
if (isset($_POST['add'])){
    require_permission('create_new_area');
    $state_id = $_POST['state'];
    $city_id = $_POST['city'];
    $name = $_POST['name'];

    if (empty($state_id) or empty($city_id) or empty($name)){
        $error[] = "All field(s) are required";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $in = $db->query("INSERT INTO ".DB_PREFIX."area (state_id,city_id,name)VALUES('$state_id','$city_id','$name')");
        set_flash("New area has been added successfully","info");

    }else{
        $err_msg = $error_count == 1 ? "An error occurred, please check and try again\n" :
            "Some errors occurred, please check and try again\n";
        foreach ($error as $value){
            $err_msg.='<p>'.$value.'</p>';
        }
        set_flash($err_msg,'danger');
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
                <h4 class="modal-title">Add New Area</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    
                   <div class="row">
                       <div class="col-sm-6">
                           <div class="form-group">
                               <label for="">State</label>
                               <select name="state" id="state" required class="form-control">
                                   <option value="" disabled selected>Select</option>
                                   <?php
                                   $sql = $db->query("SELECT * FROM ".DB_PREFIX."state ORDER BY name");
                                   while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                       ?>
                                       <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                       <?php
                                   }
                                   ?>
                               </select>
                           </div>
                       </div>
                       <div class="col-sm-6">
                           <div class="form-group">
                               <label for="">City</label>
                               <select name="city" id="city" required class="form-control">
                                   <option value="" disabled selected>Select</option>
                               </select>
                           </div>
                       </div>
                   </div>
                    
                    <div class="form-group">
                        <label>Area Name</label>
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
            <a href="#"  data-toggle="modal" data-target="#modal-default" class="btn btn-primary btn-sm" style="margin-bottom: 20px;">Add New Area</a>

            <?php flash(); ?>
            <div class="table-responsive">
                <table id="datatables" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Sn</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Area</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Sn</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Area</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $sql = $db->query("SELECT a.*, c.name as city, s.name as state FROM ".DB_PREFIX."area as a
                            LEFT JOIN ".DB_PREFIX."city as c ON a.city_id = c.id
                            LEFT JOIN ".DB_PREFIX."state as s ON a.state_id = s.id");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= ucwords($rs['state']) ?></td>
                                    <td><?= ucwords($rs['city']) ?></td>
                                    <td><?= ucwords($rs['name']) ?></td>
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

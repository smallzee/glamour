<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:29 PM
 */

$page_title = "Role";
require_once '../core/core.php';
require_permission('manage_role');
$permissions = array();
$sql = $db->query("SELECT * FROM ".DB_PREFIX."permissions");
while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
    $permissions[] = $rs;
}


if (isset($_POST['add'])){
    require_permission('create_new_role');
    $name = $_POST['name'];
    @$permission = json_encode($_POST['permission']);

    if (empty($name)){
        $error[] = "Name is required";
    }

    if (strlen($name) < 3 or strlen($name) > 50){
        $error[] = "Name should be between 3 - 50 characters long";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $in = $db->query("INSERT INTO ".DB_PREFIX."role (name,meta)VALUES('$name','$permission')");

        set_flash("Role has been added successfully","info");

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
                <h4 class="modal-title">Add New Role</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Name" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Permission (optional)</label><br>
                        <?php
                        if (is_array($permissions)){
                            foreach ($permissions as $value){
                                ?>
                                <div >
                                    <input type="checkbox" name="permission[]" value="<?= $value['name']; ?>" id="">
                                    <label for="<?= $value['name'] ?>"><?= $value['name'] ?></label>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-sm btn-primary" value="Submit" id="">
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
          <h3 class="box-title"><?= $page_title  ?></h3>
          <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i>
              </button>
          </div>
        </div>
        <div class="box-body">
          <?php flash(); ?>

            <button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 20px;" data-toggle="modal" data-target="#modal-default">
               Add New Role
            </button>

            <div class="table-responsive">
                
                 <table id="datatables" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."role");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $rs['name'] ?></td>
                                    <td> <a href="<?= EDIT_ROLE.$rs['id']; ?>" class="btn btn-primary btn-sm">Edit</a></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>

            </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->

<?php require_once 'libs/foot.php'?>

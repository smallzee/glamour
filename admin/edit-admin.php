<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/15/2020
 * Time: 11:43 AM
 */

$page_title = "Edit Profile : ";
require_once '../core/core.php';
require_permission('manage_view_admin');
@$user_id = $_GET['id'];
if (!isset($user_id)){
    redirect(base_url('admin/404'));
    return;
}

if (empty($user_id)){
    redirect(base_url('admin/404'));
    return;
}

$role_sql = $db->query("SELECT * FROM ".DB_PREFIX."role WHERE id > 1");
while ($rs = $role_sql->fetch(PDO::FETCH_ASSOC)){
    $role_array[] = $rs;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE id='$user_id'");
$num_row = $sql->rowCount();

$rs = $sql->fetch(PDO::FETCH_ASSOC);

if ($num_row == 0){
    redirect(base_url('admin/404'));
    return;
}
$page_title.=$rs['fname'];

if (isset($_POST['edit'])){
    $fname = $_POST['fname'];
    $status = $_POST['status'];
    $role = $_POST['role'];

    if (empty($fname) or empty($role)){
        $error[] = "All field(s) are required";
    }

    if (strlen($fname) < 5 or strlen($fname) > 100){
        $error[] = "Full name should be between 5 - 100 characters long";
    }

    for($ii =0; $ii < count($role_array); $ii++){
        $role_id[] = $role_array[$ii]['id'];
    }

    /*if (!in_array($role, $role_id)){
        $error[] = "Invalid role selected";
    }*/

    $error_count = count($error);
    if ($error_count == 0){

        $up = $db->query("UPDATE ".DB_PREFIX."users SET fname='$fname', role='$role', status='$status' WHERE id='$user_id'");
        set_flash("Admin account has been updated successfully","info");

        redirect(EDIT_ADMIN.$user_id);

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

            <?php flash(); ?>

            <form action="" method="post">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Full Name</label>
                            <input type="text" value="<?= $rs['fname'] ?>" name="fname" class="form-control" required placeholder="Full Name" id="">
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="role" class="form-control" required id="">
                                <option value="<?= role($rs['role']) ?>"><?= ucwords(role($rs['role'])) ?></option>
                                <?php
                                if (is_array($role_array)){
                                    foreach ($role_array as $value){
                                        if ($value['id'] != $rs['role']){
                                            ?>
                                            <option value="<?= $value['id'] ?>"><?= ucwords($value['name']) ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Account Status</label>
                            <select name="status" id="" class="form-control" required>
                                <?php if ($rs['status'] == 1): ?>
                                    <option value="<?= $rs['status'] ?>"><?= user_status($rs['status']) ?></option>
                                    <option value="0">Inactive</option>
                                <?php else: ?>
                                    <option value="<?= $rs['status'] ?>"><?= user_status($rs['status']) ?></option>
                                    <option value="1">Active</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" name="edit" class="btn btn-sm btn-info" value="Update" id="">
                </div>
            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<?php require_once 'libs/foot.php';?>

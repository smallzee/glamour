<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/15/2020
 * Time: 2:06 PM
 */
$page_title = "Edit State";
require_once '../core/core.php';
require_permission('edit_state');
@$state_id = $_GET['id'];
if (!isset($state_id)){
    redirect(base_url('admin/404'));
    return;
}

if (empty($state_id)){
    redirect(base_url('admin/404'));
    return;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."state WHERE id='$state_id'");
$num_row = $sql->rowCount();

$rs = $sql->fetch(PDO::FETCH_ASSOC);

if ($num_row == 0){
    redirect(base_url('admin/404'));
    return;
}

if (isset($_POST['edit'])){
    $name = strtolower($_POST['name']);;

    $update_at = date('Y-m-d H:m:s');

    if (empty($name)){
        $error[] = "State name is required";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $up = $db->query("UPDATE ".DB_PREFIX."state SET name='$name', updated_at='$update_at' WHERE id='$state_id'");
        set_flash("State name has been updated successfully","info");
        redirect(EDIT_STATE.$state_id);

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
                <div class="form-group">
                    <label for="">State Name</label>
                    <input type="text" class="form-control" name="name" required placeholder="State Name" value="<?= $rs['name'] ?>" id="">
                </div>

                <div class="form-group">
                    <input type="submit" name="edit" class="btn btn-primary btn-sm" value="Submit" id="">
                </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<?php require_once 'libs/foot.php'?>

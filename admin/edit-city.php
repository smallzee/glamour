<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/15/2020
 * Time: 1:31 PM
 */
$page_title = "Edit City ";
require_once '../core/core.php';
require_permission('edit_city');
@$city_id = $_GET['id'];
if (!isset($city_id)){
    redirect(base_url('admin/404'));
    return;
}

if (empty($city_id)){
    redirect(base_url('admin/404'));
    return;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."city WHERE id='$city_id'");
$num_row = $sql->rowCount();

$rs = $sql->fetch(PDO::FETCH_ASSOC);

if ($num_row == 0){
    redirect(base_url('admin/404'));
    return;
}

if (isset($_POST['edit'])){
    $name = strtolower($_POST['name']);
    $state = $_POST['state'];

    $update_at = date('Y-m-d H:m:s');

    if (empty($name) or empty($state)){
        $error[] = "All field(s) are required";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $up = $db->query("UPDATE ".DB_PREFIX."city SET name='$name', state_id='$state', updated_at='$update_at' WHERE id='$city_id'");

        set_flash("City has been updated successfully","info");
        redirect(EDIT_CITY.$city_id);

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
                    <label for="">City Name</label>
                    <input type="text" class="form-control" required value="<?= $rs['name'] ?>" placeholder="City name" name="name" id="">
                </div>

                <div class="form-group">
                    <label for="">State Name</label>
                    <select name="state" required id="" class="form-control">
                        <option value="<?= $rs['state_id'] ?>" selected><?= ucwords(state($rs['state_id'],'name')) ?></option>
                        <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."state ORDER BY name");
                            while ($rs2 = $sql->fetch(PDO::FETCH_ASSOC)){
                                if ($rs2['id'] != $rs['state_id']){
                                    ?>
                                    <option value="<?= $rs2['id'] ?>"><?= ucwords($rs2['name']) ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
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

<?php require_once 'libs/foot.php';?>

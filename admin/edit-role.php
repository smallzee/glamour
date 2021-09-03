<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:39 PM
 */

$page_title = "Edit Role";
require_once '../core/core.php';

require_permission('edit_role');

if (isset($_GET['id'])) {
    $role_id = $_GET['id'];

    if (empty($role_id)) {
        redirect(base_url('admin/404'));
        return;
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."role WHERE id='$role_id'");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    $num_row = $sql->rowCount();

    if ($num_row == 0) {
        redirect(base_url('admin/404'));
        return;
    }

}else{
    redirect(base_url('admin/404'));
}

$permission = $db->query("SELECT * FROM ".DB_PREFIX."permissions");
while ($perm = $permission->fetch(PDO::FETCH_ASSOC)){
    $permissions[] = $perm;
}


$role = $db->query("SELECT * FROM ".DB_PREFIX."role WHERE id ='$role_id'");
while ($rs_role = $role->fetch(PDO::FETCH_ASSOC)){
    $permissions2 = json_decode($rs_role['meta']);
    $role_data = $rs_role['meta'];
    $data['permissions'] = $permissions2;
    //$APP->assign('data', $role_data);
    //$data[] = $role_data;
}

if (isset($_POST['p'])){
    $required = array('name');
    $datas = $_POST;
    foreach($required as $r){
        if(!(in_array($r, array_keys($datas)) && $datas[$r])){
            set_flash($r.'_not_set', $r.'is required');
            $error = 1;
        }
    }

    $role_name = $datas['name'];
    @$role_meta = json_encode($datas['permissions']);

    $up = $db->query("UPDATE ".DB_PREFIX."role SET meta ='$role_meta', name='$role_name' WHERE id='$role_id'");
    set_flash("Role has been updated successfully","info");
    redirect(base_url('admin/role'));
}


require_once 'libs/head.php';
?>

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

              <form action="" method="post">

                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" value="<?= @$rs['name'] ?>" id="">
                </div>

                <?php if(is_array($permissions)):
                    foreach($permissions as $item): ?>

                        <div class="form-check">
                            <label class="form-check-label">
                                <input <?=is_array(@$data['permissions']) && in_array($item['name'],$data['permissions'])?'checked':'' ?> class="form-check-input" id="<?=$item['name']?>" name="permissions[]" value="<?=$item['name']?>" type="checkbox" >
                                <?= $item['name'] ?>
                                <span class="form-check-sign">
                                  <span class="check"></span>
                                </span>
                            </label>
                        </div>

                    <?php endforeach;
                endif; ?>

                <div class="form-group" style="margin-top: 20px;">
                    <input type="submit" name="p" class="btn btn-primary btn-sm" value="Submit" id="">
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once 'libs/foot.php';?>

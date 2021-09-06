<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:10 PM
 */
$page_title = "Edit Event Category";
require_once '../core/core.php';

$id = $_GET['id'];

if (!isset($id) or empty($id)){
    redirect(base_url('dashboard.php'));
    return;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type WHERE id='$id'");
$rs = $sql->fetch(PDO::FETCH_ASSOC);

if ($sql->rowCount() == 0){
    redirect(base_url('dashboard.php'));
    return;
}

if (isset($_POST['update'])){
    $name = strtolower($_POST['name']);
    $price = $_POST['price'];

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type WHERE name='$name'");
    $num_row = $sql->rowCount();

    $db->query("UPDATE ".DB_PREFIX."event_type SET name='$name', price='$price' WHERE id='$id'");

    set_flash("Event Category has been updated successfully","info");

    redirect(base_url('admin/edit-event-category.php?id='.$id));

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

            <form method="post">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" value="<?= $rs['name'] ?>" class="form-control" required="" placeholder="Name" name="name">
                </div>

                <div class="form-group">
                    <label for="">Budget</label>
                    <input type="text" value="<?= $rs['price'] ?>" class="form-control" name="price" required placeholder="Price" id="">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" name="update">
                </div>
            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->



<?php require_once 'libs/foot.php';?>

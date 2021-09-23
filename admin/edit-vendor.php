<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-05
 * Time: 14:46
 */

$page_title = "Edit Vendor";
require_once '../core/core.php';

$id = $_GET['id'];

if (!isset($id) or empty($id)){
    redirect(base_url('dashboard.php'));
    return;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."vendor WHERE id='$id'");
$rs = $sql->fetch(PDO::FETCH_ASSOC);
if ($sql->rowCount() == 0){
    redirect(base_url('dashboard.php'));
    return;
}

if (isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profession = $_POST['profession'];
    $price = $_POST['price'];
    $capacity = $_POST['capacity'];


    $db->query("UPDATE ".DB_PREFIX."vendor SET name='$name', phone='$phone', email='$email', phone='$phone', address='$address', price='$price', capacity='$capacity', profession='$profession' WHERE id='$id'");

    set_flash("Vendor profile has been updated successfully","info");
    redirect(base_url('admin/edit-vendor.php?id='.$id));
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
                        <label for="">Vendor Name</label>
                        <input type="text" value="<?= $rs['name'] ?>" class="form-control" required placeholder="Name" name="name" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Vendor Email Address</label>
                        <input type="email" value="<?= $rs['email'] ?>" class="form-control" required placeholder="Email Address" name="email" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Vendor Phone Number</label>
                        <input type="text" value="<?= $rs['phone'] ?>" class="form-control" required placeholder="Phone Number" name="phone" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Vendor Profession</label>
                        <input type="text" value="<?= $rs['profession'] ?>" class="form-control" required placeholder="Vendor Profession" name="profession" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Venue Capacity (optional)</label>
                        <input type="number" value="<?= $rs['capacity'] ?>" class="form-control" required placeholder="Event Capacity (optional)" name="capacity" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="text" value="<?= $rs['price'] ?>" class="form-control" placeholder="Price" name="price" id="">
                    </div>

                    <div class="form-group">
                        <label for="">Vendor Address</label>
                        <textarea name="address" class="form-control" required placeholder="Vendor Address" id="" style="resize: none"><?= $rs['address']?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update" name="add">
                    </div>
                </form>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

<?php require_once 'libs/foot.php';?>
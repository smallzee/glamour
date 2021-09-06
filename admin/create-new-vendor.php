<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-05
 * Time: 14:46
 */

$page_title = "Create New Vendor";
require_once '../core/core.php';

if (isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profession = $_POST['profession'];

    $db->query("INSERT INTO ".DB_PREFIX."vendor (name,email,phone,address,profession)VALUES('$name','$email','$phone','$address','$profession')");

    set_flash("New vendor has been created successfully","info");
    redirect(base_url('admin/create-new-vendor.php'));
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
            <input type="text" class="form-control" required placeholder="Name" name="name" id="">
        </div>

        <div class="form-group">
            <label for="">Vendor Email Address</label>
            <input type="email" class="form-control" required placeholder="Email Address" name="email" id="">
        </div>
        
        <div class="form-group">
            <label for="">Vendor Phone Number</label>
            <input type="text" class="form-control" required placeholder="Phone Number" name="phone" id="">
        </div>
        
        <div class="form-group">
            <label for="">Vendor Profession</label>
            <input type="text" class="form-control" required placeholder="Vendor Profession" name="profession" id="">
        </div>

        <div class="form-group">
            <label for="">Vendor Address</label>
            <textarea name="address" class="form-control" required placeholder="Vendor Address" id="" style="resize: none"></textarea>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit" name="add">
        </div>
    </form>

</div>
<!-- /.box-body -->
</div>
<!-- /.box -->

</section>
<!-- /.content -->

<?php require_once 'libs/foot.php';?>
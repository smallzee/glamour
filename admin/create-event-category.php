<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:10 PM
 */
$page_title = "Create Event Category";
require_once '../core/core.php';
if (isset($_POST['add'])){
    $name = strtolower($_POST['name']);
    $price = $_POST['price'];
    $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type WHERE name='$name'");
    $num_row = $sql->rowCount();

    if ($num_row >= 1){
        set_flash("$name has already exist","danger");
    }else{
        $in = $db->query("INSERT INTO ".DB_PREFIX."event_type (name,price)VALUES('$name','$price')");
        set_flash("$name has been added successfully","primary");
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

            <form method="post">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" required="" placeholder="Name" name="name">
                </div>

                <div class="form-group">
                    <label for="">Budget</label>
                    <input type="text" class="form-control" name="price" required placeholder="Price" id="">
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

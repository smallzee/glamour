<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/26/2020
 * Time: 12:13 PM
 */

$page_title = "Administrative";
require_once '../core/core.php';


if (isset($_POST['add'])){
    //require_permission('create_new_admin');

    $fname = trim( $_POST['fname']);
    $email = strtolower($_POST['email']);
    $role = $_POST['role'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
    $num_row = $sql->rowCount();

    if ($num_row >= 1){
        $error[] = "Email address has been used by another user";
    }

    if (empty($fname) or empty($email) or empty($role) or empty($password) or empty($password2)){
        $error[] = "All field(s) are required";
    }

    if (strlen($fname) < 5 or strlen($fname) > 100){
        $error[] = "Full name should be between 5 - 100 characters long";
    }

    if (strlen($email) < 10 or strlen($email) > 200){
        $error[] = "Email address should be between 10 - 200 characters";
    }


    $error_count = count($error);
    if ($error_count == 0){

        $pass = hash_password($password);

        $in = $db->query("INSERT INTO ".DB_PREFIX."users(password,email,fname,role)
        VALUES('$pass','$email','$fname',2)");


        set_flash("Account created successfully check $email for admin account details", "info");

        redirect(base_url('admin/admin'));

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
                <h4 class="modal-title">Add New Admin</h4>
            </div>
            <div class="modal-body">

                <form action="" method="post">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Full Name</label>
                                <input type="text" name="fname" class="form-control" required placeholder="Full Name" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" required placeholder="Email Address" id="">
                            </div>
                        </div>


<!--                        <div class="col-sm-12">-->
<!--                            <div class="form-group">-->
<!--                                <label for="">Role</label>-->
<!--                                <select name="role" class="form-control" required id="">-->
<!--                                    --><?php
//                                    if (is_array($role_array)){
//                                        foreach ($role_array as $value){
//                                            ?>
<!--                                            <option value="--><?//= $value['id'] ?><!--">--><?//= ucwords($value['name']) ?><!--</option>-->
<!--                                            --><?php
//                                        }
//                                    }
//                                    ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required placeholder="Password" id="">
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" name="password2" class="form-control" required placeholder="Confirm Password" id="">
                            </div>
                        </div>
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
            <h3 class="box-title"><?= $page_title ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <button type="button" class="btn btn-primary btn-sm" style="margin-bottom: 20px;" data-toggle="modal" data-target="#modal-default">
                Add New Admin
            </button>

            <?php flash(); ?>

            <div class="table-responsive">
                <table id="datatables" class="table table-bordered " >
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Account Status</th>
                        <th>Date</th>
<!--                        <th>Actions</th>-->
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Account Status</th>
                        <th>Date</th>
<!--                        <th>Actions</th>-->
                    </tr>
                    </tfoot>

                    <tbody>
                    <?php
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role>'1' ORDER BY id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= $rs['fname'] ?></td>
                            <td><?= $rs['email'] ?></td>
                            <td><?= $rs['phone'] ?></td>
                            <td><?= user_status($rs['status']) ?></td>
                            <td><?= date('Y-m-d h:i:s:a',$rs['created_at']) ?></td>
<!--                            <td>-->
<!--                                <a href="--><?//= EDIT_ADMIN.$rs['id'] ?><!--" class="btn btn-primary btn-sm">Edit</a>-->
<!--                            </td>-->
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

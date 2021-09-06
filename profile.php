<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 10:03 AM
 */
$page_title = "My Profile";
require_once 'core/core.php';
user_is_required_to_login();
$user_id = user_details('id');
if (isset($_POST['update-account'])){
    $fname = $_POST['fname'];
    $phone = $_POST['phone'];

    if (strlen($fname) < 8 or strlen($fname) > 100){
        $error[] = "Your full name should be between 8 - 100 characters";
    }

    if (validate_phone_number($phone) != true){
        $error[] = "Invalid phone number entered";
    }

    $err_count = count($error);
    if ($err_count == 0){

        $up = $db->query("UPDATE ".DB_PREFIX."users SET fname='$fname', phone='$phone' WHERE id='$user_id'");
        set_flash("Your account has been updated successfully","info");

    }else{
        $msg = $error_count == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');

    }

}
require_once 'assets/head.php';
?>

<!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

              <div class="box">
                  <div class="box-header with-border">
                      <h3 class="box-title">Account Details</h3>
                      <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>
                      </div>
                  </div>
                  <div class="box-body">

                      <?php flash(); ?>

                      <form method="post">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group position-relative">
                                      <label>Email Address</label>
                                      <input name="email" value="<?= user_details('email') ?>" disabled id="email" type="email" class="form-control " placeholder="Your email">
                                      <small>Please note : your email address cannot be changed</small>
                                  </div>
                              </div><!--end col-->
                              <div class="col-md-6">
                                  <div class="form-group position-relative">
                                      <label>Full Name</label>
                                      <input name="fname" value="<?= user_details('fname') ?>" id="fname" type="text" class="form-control" placeholder="Full Name ">
                                  </div>
                              </div><!--end col-->
                              <div class="col-md-6">
                                  <div class="form-group position-relative">
                                      <label>Phone Number</label>
                                      <input name="phone" type="text" class="form-control " value="<?= user_details('phone') ?>" placeholder="Phone Number">
                                  </div>
                              </div><!--end col-->

                              <div class="col-sm-12">
                                  <input type="submit" id="submit" name="update-account" class="btn btn-info" value="Submit">
                              </div>
                      </form><!--end form-->

                  </div>
              </div>
          </div>

      </div>

        <div class="col-md-12">
            <!-- Default box -->

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Password</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <form method="post">
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="form-group position-relative">
                                    <label>Old password :</label>
                                    <input type="password" class="form-control" placeholder="Old password" required="">
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-6">
                                <div class="form-group position-relative">
                                    <label>New password :</label>
                                    <input type="password" class="form-control" placeholder="New password" required="">
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-6">
                                <div class="form-group position-relative">
                                    <label>Re-type New password :</label>
                                    <input type="password" class="form-control" placeholder="Re-type New password" required="">
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-12 mt-2 mb-0">
                                <button class="btn btn-info" type="submit" name="change-password">Submit</button>
                            </div><!--end col-->
                        </div><!--end row-->
                    </form>

                </div>
            </div>

        </div>
    </section>


<?php require_once 'assets/foot.php'?>



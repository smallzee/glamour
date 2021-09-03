<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/23/2020
 * Time: 11:24 AM
 */
$page_title = "Register";
require_once 'core/core.php';
if (isset($_POST['register'])){
   $fname = $_POST['fname'];
   $email = strtolower($_POST['email']);
   $phone = $_POST['phone'];
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];

   $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
   $num_row = $sql->rowCount();

   if ($num_row >= 1){
       $error[] = "Email address has already been used by another user";
   }

   if (strlen($email) < 8 or strlen($email) > 100 ){
       $error[] = "Your email address should be between 8 - 100 characters";
   }

   if (strlen($fname) < 8 or strlen($fname) > 100){
       $error[] = "Your full name should be between 8 - 100 characters";
   }

   if (strlen($password) < 6){
       $error[] = "Your password should more than 6 characters";
   }

   if ($password != $cpassword){
       $error[] = "Your password did not match confirm password";
   }

   if (validate_phone_number($phone) != true){
       $error[] = "Invalid phone number entered";
   }

   $error_count = count($error);
   if ($error_count == 0){

       $password2 = hash_password($password);
       $created_at = time();

        $in = $db->query("INSERT INTO ".DB_PREFIX."users (fname,email,password,phone,created_at)
        VALUES('$fname','$email','$password2','$phone','$created_at')");

        set_flash("Account created successfully, please login to continue","info");
        redirect("login");

   }else{
       $msg = $error_count == 1 ? "An error occurred, please check and try again\n" : "Some errors occured, please check and try again\n";
       foreach ($error as $value){
           $msg.='<p>'.$value.'</p>';
       }
       set_flash($msg,'danger');
   }
}
require_once 'libs/head.php';
?>

!-- Hero Start -->
<section class="bg-half bg-light d-table w-100" style="background-image: url('<?=img_url('case.jpg') ?>')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <h4 class="title text-white"> Register </h4>
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Register</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section><!--end section-->
<!-- Hero End -->

<!-- Shape Start -->
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>
<!--Shape End-->

<!-- Feature Start -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-3 ml-auto mr-auto">
                <div class="card login-page border-0" style="z-index: 1">
                    <div class="card-body">
                        <h4 class="card-title text-center">Register</h4>

                        <?php flash(); ?>

                        <form class="login-form mt-4" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input type="text" value="<?= data_post('fname') ?>" class="form-control pl-5" placeholder="First Name" name="fname" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <i data-feather="phone" class="fea icon-sm icons"></i>
                                        <input type="text" value="<?= data_post('phone') ?>" class="form-control pl-5" placeholder="Phone Number" name="phone" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                        <input type="email" value="<?= data_post('email') ?>" class="form-control pl-5" placeholder="Email" name="email" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                        <input type="password" class="form-control pl-5" placeholder="Password" name="password" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                        <input type="password" class="form-control pl-5" placeholder="Confirm Password" name="cpassword" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" required class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">I Accept <a href="#" class="text-primary">Terms And Condition</a></label>
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-block" name="register" type="submit">Register</button>
                                </div><!--end col-->


                                <div class="mx-auto">
                                    <p class="mb-0 mt-3"><small class="text-dark mr-2">Already have an account ?</small> <a href="<?= base_url('login') ?>" class="text-dark font-weight-bold">Login</a></p>
                                </div>
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once 'libs/foot.php';?>

<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/17/2020
 * Time: 2:15 PM
 */
$page_title = "Login";
//require_once 'core/core.php';
require_once 'googleclient.php';

$continue_with_google = "";
if (!isset($_SESSION[GOOGLE_USER_ACCESS_TOKEN])){
    $continue_with_google = $google_client->createAuthUrl();
}else{
    $continue_with_google = $google_client->createAuthUrl();
}

if (isset($_POST['login'])){
    $email = $_POST['email'];
    $password = hash_password($_POST['password']);

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email' and password ='$password'");
    $num_row = $sql->rowCount();

    $rs = $sql->fetch(PDO::FETCH_ASSOC);

    if ($num_row == 0){
        set_flash("Invalid login details, try again","danger");
    }else if($rs['status'] == 0){
        set_flash("Access denied","danger");
    }else if ($rs['role'] > 1){
        set_flash("You are not allow to access this page","danger");
    }else{
        $_SESSION['loggedin'] = true;
        $data = $rs;
        if ($data['password'] == true){
            $data['password'] = 'xxx';
        }
        $_SESSION[USER_SESSION_HOLDER] = $data;
        redirect(base_url('dashboard'));
    }
}
require_once 'libs/head.php';
?>

<!-- Modal -->
<!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="exampleModalLabel">Recover Password</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                ...-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Hero Start -->
<section class="bg-half bg-light d-table w-100" style="background-image: url('<?=img_url('background.jpg') ?>')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level">
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Login</li>
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
<!--<div class="position-relative">-->
<!--    <div class="shape overflow-hidden text-white">-->
<!--        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>-->
<!--        </svg>-->
<!--    </div>-->
<!--</div>-->
<!--Shape End-->

<!-- Feature Start -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 offset-3 ml-auto mr-auto">

                <div class="card login-page border-0" style="z-index: 1">
                    <div class="card-body p-0">
                        <h4 class="card-title text-center">Login</h4>

                        <?php flash(); ?>

                        <form class="login-form mt-4" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input type="email" class="form-control pl-5" placeholder="Email" name="email" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <div class="form-group position-relative">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                        <input type="password"  name="password" class="form-control pl-5" placeholder="Password" required="">
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                                            </div>
                                        </div>
<!--                                        <p class="forgot-pass mb-0"><a href="#" data-toggle="modal" data-target="#exampleModal" class="text-dark font-weight-bold">Forgot password ?</a></p>-->
                                    </div>
                                </div><!--end col-->

                                <div class="col-lg-12 mb-0">
                                    <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
                                </div><!--end col-->
<!---->
<!--                                <div class="col-sm-12">-->
<!--                                  <p>  <center><h5>OR</h5></center></p>-->
<!--                                  <a href="--><?//= $continue_with_google ?><!--" class="btn btn-danger btn-block"><i class="fa fa-google-plus"></i> Continue with your gmail</a>-->
<!--                                </div>   -->

                                <div class="col-12 text-center">
                                    <p class="mb-0 mt-3"><small class="text-dark mr-2">Don't have an account ?</small> <a href="<?= base_url('register') ?>" class="text-dark font-weight-bold">Register</a></p>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'libs/foot.php'?>

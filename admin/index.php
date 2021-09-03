<?php 
    $page_title = "Admin";
	require_once '../core/core.php';

	if (is_admin_login()){
	    redirect(base_url('admin/dashboard'));
	    return;
    }

	if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$password = sha1($_POST['password']);

		$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email' and password='$password'");
		$num_row = $sql->rowCount();

		$rs = $sql->fetch(PDO::FETCH_ASSOC);

		if ($num_row == 0) {
			set_flash("Invalid login details entered try again","danger");
		}elseif ($rs['status'] == 0) {
			set_flash("Access denied","danger");
		}else if ($rs['role'] == 1){
		    set_flash("You are not allow to access this page","info");
        }else{
            $_SESSION['loggedin'] = true;
            $data = $rs;
            if ($data['password'] == true) {
                $data['password']  = 'xxx';
            }
            $_SESSION[USER_SESSION_HOLDER] = $data;
            redirect("dashboard");
        }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta property="og:locale" content="en_US">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= page_title(@$page_title); ?></title>
    <link rel="stylesheet" type="text/css" href="<?= HTML_BASE_TEMPLATE ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= HTML_BASE_TEMPLATE ?>css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?= HTML_BASE_TEMPLATE ?>css/iofrm-theme4.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <style>
        .form-control{
            height: 45px;
        }
    </style>
</head>
<body>

<div class="form-body">
    <div class="website-logo">
        <a href="<?= base_url() ?>">
            <div class="logo">
                <img class="logo-size" src="<?= image_url('graphic1.svg') ?>" alt="">
            </div>
        </a>
    </div>
    <div class="row">
        <div class="img-holder">
            <div class="bg"></div>
            <div class="info-holder">
                <img src="<?= image_url('graphic1.svg') ?>" alt="">
            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Get more things done with Loggin platform.</h3>
                    <p>Access to the most powerfull tool in the entire design and web industry.</p>
                    <div class="page-links">
                        <a href="#" class="active">Login</a>
                    </div>
                    <?php flash(); ?>
                    <form method="post">
                        <input class="form-control" style="border: #ccc solid thin; background: #fff;" value="<?= @$_POST['email'] ?>" type="email" name="email" placeholder="E-mail Address" required>
                        <input class="form-control" style="border: #ccc solid thin; background: #fff;" type="password" name="password" placeholder="Password" required>
                        <div class="form-button">
                            <button id="submit" type="submit" name="login" class="ibtn">Login</button> <a href="#">Forget password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
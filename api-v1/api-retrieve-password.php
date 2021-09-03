<?php 
require_once '../core/header.php';

@$email = strtolower($param['email']);
@$action = $param['action'];

if ($action != "ping-retrieve-password") {
	api_error_status();
	return;
}

if (empty($email)) {
	api_error_status();
	return;
}

$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
$num_row = $sql->rowCount();

$rs = $sql->fetch(PDO::FETCH_ASSOC);

if ($num_row == 0) {
	$data['error'] = 0;
	$error[] = "Invalid email address entered";
}

if ($rs['role'] > 1) {
	$data['error'] = 0;
	$error[] = "You are not eligible to change your password";
}

$err_count = count($error);

if ($err_count == 0) {
	
	$code = substr(rand(1000,9999), 0, 4);
	$user_id = $rs['id'];
	$email = $rs['email'];

	$up = $db->query("UPDATE ".DB_PREFIX."users SET code='$code' WHERE id='$user_id'");

	$subject = "Retreive Password";
    $msg_body = "<p>Dear ".ucwords($rs['fname'])."</p>";
    $msg_body.= "<p> Your verification code is $code </p>";
    $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';

    $data['error'] = 1;
    $data['msg'] = "Your verification code was sent to your mail";
    $data['forget_user_id'] = $rs['id'];

    send_mail($msg_body,$subject,$email);

}else{
	 $err_msg = $err_count == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
	  foreach ($error as $value) {
	  	$err_msg.="$value\n";
	  }
	  $data['msg'] = $err_msg;
}
echo json_encode($data);
exit();
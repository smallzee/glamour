<?php 

/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/28/2020
 * Time: 7:07 AM
 */

require_once '../core/header.php';


@$npassword = $param['np'];
@$cpassword = $param['cp'];
@$ppassword = $param['pp'];
@$user_id = $param['user-id'];

if (@$param['action'] != "ping-change-password") {
	api_error_status();
	return;
}

if (empty($npassword) or empty($cpassword) or empty($user_id) or empty($ppassword)) {
	api_error_status();
	return;
}

$pp = sha1($ppassword);
$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE password='$pp' and id='$user_id'");
$num_row = $sql->rowCount();

if ($num_row == 0) {
	$data['error'] =0;
	$error[] = "Invalid previous password entered \n";
}

if (strlen($npassword) < 6) {
	$data['error'] =0;
	$error[] = "Your new password should more than 6 characters \n";
}

if ($npassword != $cpassword) {
	$data['error'] =0;
	$error[] = "Your new password did not match confirm new password \n";
}

$err_count = count($error);
if ($err_count == 0) {
	$np = sha1($npassword);

	$up = $db->query("UPDATE ".DB_PREFIX."users SET password='$np' WHERE id='$user_id'");
	$data['error'] =1;
	$data['msg'] = "Your password has been changed successfully";

}else{
	 $err_msg = $err_count == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
	  foreach ($error as $value) {
	  	$err_msg.="$value\n";
	  }
	  $data['msg'] = $err_msg;
}

echo json_encode($data);
exit();

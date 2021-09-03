<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/28/2020
 * Time: 7:07 AM
 */

require_once '../core/header.php';

@$phone = $param['phone'];
@$fname = $param['fname'];
@$user_id = $param['user-id'];

if (@$param['action'] != "ping-update-account"){
    api_error_status();
    return;
}

if (empty($phone) or empty($fname) or empty($user_id)){
    api_error_status();
    return;
}

if (strlen($fname) < 8 or strlen($fname) > 100) {
	$data['error'] = 0;
	$error[] = "Full name should be between 8 - 100 characters \n";
}

if (validate_phone_number($phone) != true){
    $data['error'] =0;
    $error[] = "Invalid phone number entered\n";
}

$err_count = count($error);

if ($err_count == 0) {
	$data['error'] = 1;
	$up = $db->query("UPDATE ".DB_PREFIX."users SET fname='$fname', phone='$phone' WHERE id='$user_id'");
	
	$data['msg'] = "Account has been updated successfully";
	$data['user_info'] = array('fname'=>$fname,'phone'=>$phone);

}else{
	  $err_msg = $err_count == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
	  foreach ($error as $value) {
	  	$err_msg.="$value\n";
	  }
	  $data['msg'] = $err_msg;
}

echo json_encode($data);
exit();

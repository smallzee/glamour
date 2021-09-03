<?php 

require_once '../core/header.php';

@$action = $param['action'];
@$code = $param['code'];
@$user_id = $param['user_id'];

if ($action != "ping-join-event") {
	api_error_status();
	return;
}

if (empty($code) or empty($user_id)) {
	api_error_status();
	return;
}

$sql = $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as e 
    INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
    INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
    ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id WHERE e.code='$code'");

$num_row = $sql->rowCount();

$rs = $sql->fetch(PDO::FETCH_ASSOC);

$create_event_user_id = $rs['user_id'];
$event_id = $rs['id'];
$event_date = $rs['event_date'];
$guest = $rs['guest'];

if ($num_row == 0) {
	$data['error'] = 0;
	$error[] = "Invalid event code entered";
}

if ($create_event_user_id == $user_id) {
	$data['error'] = 0;
	$error[] = "Ops, sorry you cannot join the event created by you";
}

$sql_join = $db->query("SELECT * FROM ".DB_PREFIX."join_event WHERE user_id='$user_id' and event_id='$event_id'");
$num_row2 = $sql_join->rowCount();

if ($num_row2 >= 1) {
	$data['error']= 0;
	$error[] = "You have already joined this event";
}

$current_date = date('m/d/Y');

if ($current_date >= $event_date) {
	$data['error'] =0;
	$error[] = "The event date has already passed away";
}

$sql_join_1 = $db->query("SELECT * FROM ".DB_PREFIX."join_event WHERE event_id='$event_id'");
$total = $sql_join_1->rowCount();

if ($total > $guest) {
	$data['error'] = 0;
	$error[] = "No available guest space";
}

$err_count = count($error);

if ($err_count == 0) {
	
	$data['error'] = 1;
	$data['msg'] = "Successful";
	$address = $rs['state']." ".$rs['city'].", ".$rs['area'];
	$data['info'] = array(
		'id'=>$rs['id'],
		'address'=>$address,
		'event_title'=>$rs['event_title'],
		'event_type_name'=>$rs['event_type_name'],
		'description'=>$rs['description'],
		'image'=>$rs['image'],
		'event_date'=>$rs['event_date']
	);

}else{
	 $err_msg = $err_count == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
	  foreach ($error as $value) {
	  	$err_msg.="$value\n";
	  }
	  $data['msg'] = $err_msg;
}

echo json_encode($data);
exit();
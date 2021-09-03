<?php 
	require_once '../core/header.php';
 
 	@$action = $param['action'];
 	@$event_id = $param['event_id'];

 	if ($action != "ping-event-guest") {
 		api_error_status();
 		return;
 	}

 	if (empty($event_id)) {
 		api_error_status();
 		return;
 	}

 	$sql = $db->query("SELECT j.*,u.fname, u.id as user_id, u.email, u.phone FROM ".DB_PREFIX."join_event as j INNER JOIN ".DB_PREFIX."users as u ON j.user_id = u.id WHERE j.event_id='$event_id'");
 	$num_row = $sql->rowCount();

 	if ($num_row == 0) {
 		$data['error'] =0;
 		$data['msg'] = "No available guest(s)";
 	}else{
 		$data['error'] = 1;
 		$data['page_title'] = "My Guest(s)";

 		$data['response_status'] =
            array(
                'data_status'=>'true',
                'status'=>'preview'
            );

 		while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
 			$data[] = array(
 			        'id'=>$rs['id'],
 					'user_id'=> $rs['user_id'],
 					'event_id'=>$rs['event_id'],
 					'fname'=>$rs['fname'],
 					'seat'=>$rs['seat'],
 					'email'=>$rs['email'],
 					'phone'=>$rs['phone']
 				);
 		}
 	}

 	echo json_encode($data);
 	exit();
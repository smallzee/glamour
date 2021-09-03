<?php 
	require_once '../core/header.php';

	@$action = $param['action'];
	@$event_id = $param['event_id'];
	@$user_id = $param['user_id'];

	if ($action != "ping-verifying-event") {
		api_error_status();
		return;
	}

	if (empty($event_id) or empty($user_id)) {
		api_error_status();
		return;
	}

	$sql = $db->query("SELECT * FROM ".DB_PREFIX."join_event WHERE event_id='$event_id'");
	$total = $sql->rowCount();

	$sql_event =  $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as 
    event_type_name FROM ".DB_PREFIX."manage_event as e INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
    INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
    ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id 
    WHERE e.id='$event_id'");

	$sql2_check_error = $db->query("SELECT * FROM ".DB_PREFIX."join_event WHERE user_id='$user_id' and event_id='$event_id'");
	$num_row = $sql2_check_error->rowCount();

	$rs = $sql->fetch(PDO::FETCH_ASSOC);
    $rs2 = $sql_event->fetch(PDO::FETCH_ASSOC);
    $guest = $rs2['guest'];

    if ($guest == $total) {
    	$data['error'] = 0;
    	$error[] = "No available space for you";
    }

	$seat = 1;
	if ($total == 0) {
		$seat2 = $seat;
	}else{
		$seat2 = $total+$seat;
	}

	if ($num_row >= 1){
        $data['error'] =0;
        $error[] = "You have already join this event";
    }

	$err_count = count($error);

	$fname = user_info($user_id,'fname');
	$email = user_info($user_id,'email');

	if ($err_count == 0) {
		
		$in = $db->query("INSERT INTO ".DB_PREFIX."join_event (user_id,event_id,seat,status)
		VALUES('$user_id','$event_id','$seat2','1')");

        $subject = $rs2['event_title'];
        $msg_body = "<p>Dear ".ucwords($fname)."</p>";
        $msg_body.= "<p> Event details are stated below! </p>";

        $msg_body.='<img src="'.HOME_DIR.'images/'.$rs2['image'].'" style="withd:50px; height:50px; margin-right:auto; margin-left:auto">';

        $msg_body.="<ol>".
                    "<li> Event Title : ".$rs2['event_title']."</li>".
                    "<li> Event Type  : ".$rs2['event_type_name']."</li>".
                    "<li> Event Date : ".$rs2['event_date']."</li>".
                    "<li> State : ".$rs2['state']."</li>".
                    "<li> City : ".$rs2['city']."</li>".
                    "<li> Your seat number : ".$seat2."</li>".
                    "<li> Address : ".$rs2['area']."</li>".
                    "<li> Event Description : ".$rs2['description']."</li>"
            ."</ol>";

        $msg_body.='<p>Thanks for joining Mr/Mrs '.$rs2['fname'].' event  </p>';
        $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';
        send_mail($msg_body,$subject,$email);

		$data['error'] = 1;
		$address = $rs2['state']." ".$rs2['city'].", ".$rs2['area'];

		$data['info'] = array(
			'address'=>$address,
			'seat'=>$seat2,
			'event_title'=>$rs2['event_title'],
			'event_type_name'=>$rs2['event_type_name'],
			'description'=>$rs2['description'],
			'image'=>$rs2['image'],
			'event_date'=>$rs2['event_date']
		);

		$data['msg'] = "Congratulations";

	}else{
		 $err_msg = $err_count == 1 ? "An error occurred, please check and try again\n" : "Some errors occured, please check and try again\n";
		  foreach ($error as $value) {
		  	$err_msg.="$value\n";
		  }
		  $data['msg'] = $err_msg;
	}

	echo json_encode($data);
	exit();

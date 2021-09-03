<?php 
	require_once '../core/header.php';
	@$action = $param['action'];

	if ($action != "ping-ongoing-event") {
		api_error_status();
		return;
	}

	@$user_id = $param['user_id'];

	if (empty($user_id)) {
		api_error_status();
		return;
	}

	$current_date = date('m/d/Y');

	$sql = $db->query("SELECT j.*,e.id as event_id,e.event_title,e.event_date,c.name as city, s.name as state, e_t.name as event_type_name,
	e.event_date, e.image, e.description, e.area, u.fname FROM ".DB_PREFIX."join_event as j INNER JOIN 
		".DB_PREFIX."manage_event as e INNER JOIN ".DB_PREFIX."city as c INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."users as u
		ON j.event_id = e.id and e.city_id and e.state_id = s.id = c.id and e.event_type = e_t.id and e.user_id = u.id 
		WHERE j.user_id='$user_id' and e.event_date >='$current_date'");

	$num_row = $sql->rowCount();
	if ($num_row == 0) {
		$data['error'] =0;
		$data['msg'] = "No available upcoming events";
	}else{
		$data['error'] = 1;
		$data['page_title'] = "Upcoming Events";
		while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
			$address = $rs['state']." ".$rs['city'].", ".$rs['area'];

			$data[] = array(
				'id'=>$rs['id'],
				'event_id'=>$rs['event_id'],
				'event_created_by'=>$rs['fname'],
				'address'=>$address,
				'is_event_exist'=>true,
				'guest_number'=>$rs['seat'],
				'event_title'=>ucwords($rs['event_title']),
				'event_type_name'=>ucwords($rs['event_type_name']),
				'description'=>$rs['description'],
				'image'=>$rs['image'],
				'event_date'=>$rs['event_date']
			);

		}
	}

	echo json_encode($data);
	exit();
<?php 
	require '../core/header.php';

	@$action = $param['action'];

	if ($action != "ping-venue") {
		 api_error_status();
		return;
	}

	$sql = $db->query("SELECT v.*, s.name as state_name, c.name as 
    city_name, vt.name as venue_type_name FROM ".DB_PREFIX."venue as v INNER JOIN "
        .DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."city as c INNER JOIN 
        ".DB_PREFIX."venue_type as vt  ON v.state_id = s.id and v.city_id = c.id and v.venue_type = vt.id ORDER BY v.id DESC");

	if ($sql->rowCount() == 0) {
		$data['error'] = 0;
		$data['msg'] = "No available venue";
	}else{
		$data['error'] = 1;
		while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array(
			   'id'=>$rs['id'],
               'image'=>$rs['image'],
               'title'=>$rs['title'],
               'description'=>strip_tags($rs['description']),
                'amenities'=>$rs['amenities'],
                'area'=>$rs['area'],
                'price'=>number_format($rs['price']),
                'created_at'=>$rs['created_at'],
                'state'=>$rs['state_name'],
                'city'=>$rs['city_name'],
                'all_images'=>$rs['all_images'],
                'guest'=>$rs['guest'],
                'venue_type_name'=>$rs['venue_type_name']
            );
		}
	}
	
	echo json_encode($data);
	exit();
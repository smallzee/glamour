<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/8/2020
 * Time: 4:21 PM
 */

require_once '../core/header.php';

if (@$param['action'] != "ping-my-event"){
    api_error_status();
    return;
}

@$user_id = $param['user_id'];
if (empty($user_id)){
    api_error_status();
    return;
}

$sql = $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as e 
    INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
    INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
    ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id
    WHERE e.user_id ='$user_id' ORDER BY e.id DESC");

$num_row = $sql->rowCount();
$current_date = date('m/d/Y');

if ($num_row == 0){
    $data['error'] = 0;
    $data['msg'] = "No available event";
}else{
    $data['error'] = 1;
    $data['page_title'] = "My Events";
    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
        $address = $rs['state']." ".$rs['city'].", ".$rs['area'];

        if ($current_date >= $rs['event_date'] ) {
            $status = false;
        }else{
            $status = true;
        }

        $event_id = $rs['id'];
        $sql_guest = $db->query("SELECT * FROM ".DB_PREFIX."join_event WHERE event_id='$event_id'");
        $total_guest = $sql_guest->rowCount();

        $data[] = array(
            'id'=>$rs['id'],
            'event_id'=>$event_id,
            'total_guest'=>$total_guest,
            'guest_number'=>$rs['guest'],
            'state'=>$rs['state'],
            'city'=>$rs['city'],
            'status'=>$status,
            'event_created_by'=>$rs['fname'],
            'address'=>$address,
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
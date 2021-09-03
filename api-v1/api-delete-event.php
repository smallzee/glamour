<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 8/12/2020
 * Time: 10:12 AM
 */

require_once '../core/header.php';
@$action = $param['action'];

if ($action != "ping-delete-event") {
    api_error_status();
    return;
}

@$event_id = $param['event_id'];

if (empty($event_id)){
    api_error_status();
    return;
}

// delete manage event
$e_delete = true; //$db->query("DELETE FROM ".DB_PREFIX."manage_event WHERE id='$event_id'");
// delete join event
$j_event = true; //$db->query("DELETE FROM ".DB_PREFIX."join_event  WHERE event_id='$event_id'");

if ($e_delete == true && $j_event == true){
    $data['error'] = 1;
    $data['msg'] = "Event has been deleted successfully";

    $data['response_status'] =
        array(
            'data_status'=>'true',
            'status'=>'delete'
        );

}else{
    $data['error'] = 0;
    $data['msg'] = "Error(s)";
}

echo json_encode($data);
exit();


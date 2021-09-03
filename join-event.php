<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/13/2020
 * Time: 12:24 PM
 */

$page_title = "Join Event";
require_once 'core/core.php';
$user_id = user_details('id');

if (isset($_GET['code'])) {
    $code = $_GET['code'];
}

if (isset($_POST['join'])){
    $code = $_POST['code'];
    $current_date = date('m/d/Y');

    $sql = $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as e 
    INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
    INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
    ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id
     WHERE e.code='$code'");

    $num_row = $sql->rowCount();

    $rs = $sql->fetch(PDO::FETCH_ASSOC);

    $create_event_user_id = $rs['user_id'];
    $event_id = $rs['id'];
    $event_date = $rs['event_date'];
    $guest = $rs['guest'];

    $sql_join = $db->query("SELECT * FROM ".DB_PREFIX."join_event 
    WHERE user_id='$user_id' and event_id='$event_id'");
    $num_row2 = $sql_join->rowCount();

    $sql_join_1 = $db->query("SELECT * FROM ".DB_PREFIX."join_event WHERE event_id='$event_id'");
    $total = $sql_join_1->rowCount();

    if (empty($code)){
        $data['error'] = 0;
        $error[] = "Event code is required";
    }elseif (!is_numeric($code)){
        $data['error'] = 0;
        $error[] = "Invalid event code entered";
    }elseif ($num_row2 >= 1){
        $data['error'] = 0;
        $error[] = "You have already joined this event";
    }elseif ($current_date >= $event_date){
        $data['error'] =0;
        $error[] = "Unable to join this event";
    }elseif ($create_event_user_id == $user_id){
        $data['error'] = 0;
        $error[] = "Ops, sorry you cannot join the event created by you";
    }elseif ($total > $guest){
        $data['error'] = 0;
        $error[] = "No available";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $data['error'] = 1;
        $data['msg'] = 'Success';
        $address = $rs['state']." ".$rs['city'].", ".$rs['area'];
        $data['info'] = array(
            'id'=>$rs['id'],
            'address'=>$address,
            'created_by'=>user_info($rs['user_id'],'fname'),
            'event_title'=>$rs['event_title'],
            'event_type_name'=>$rs['event_type_name'],
            'description'=>$rs['description'],
            'image'=>$rs['image'],
            'event_date'=>$rs['event_date']
        );

    }else{
        $err_msg = $error_count > 1 ? "Some error(s) are occurred" : "An error is occurred";
        foreach ($error as $value){
            $err_msg.='</p>'.$value.'</p>';
        }
        $data['msg'] = $err_msg;
    }

    echo json_encode($data);
    exit();
}

if (isset($_POST['verify-join-event'])){
    $event_id = $_POST['event_id'];


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

    $fname = user_details('fname'); //user_info($user_id,'fname');
    $email =  user_details('email'); //user_info($user_id,'email');

    if ($err_count == 0) {

        $in = $db->query("INSERT INTO ".DB_PREFIX."join_event (user_id,event_id,seat,status)
		VALUES('$user_id','$event_id','$seat2','1')");

        $subject = $rs2['event_title'];
        $msg_body = "<p>Dear ".ucwords($fname)."</p>";
        $msg_body.= "<p> Event details are stated below! </p>";

        $msg_body.='<img src="'.image_url($rs2['image']).'" style="withd:50px; height:50px; margin-right:auto; margin-left:auto">';

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
        $msg_body.= '<p style="text-align:right;">Best Regards <br> '.WEB_TITLE.' - Admin </p>';

        $data['error'] = 1;
        $data['join_event_id'] = $db->lastInsertId();
        $data['msg'] = "Congratulations";
        send_mail($msg_body,$subject,$email);


    }else{
        $err_msg = $error_count > 1 ? "Some error(s) are occurred" : "An error is occurred";
        foreach ($error as $value){
            $err_msg.='</p>'.$value.'</p>';
        }
        $data['msg'] = $err_msg;
    }

    echo json_encode($data);
    exit();
}

require_once 'assets/head.php';
?>


 <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">


              <div class="box">
                  <div class="box-header with-border">
                      <h3 class="box-title"><?= $page_title ?></h3>
                      <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>
                      </div>
                  </div>
                  <div class="box-body">
                      <form action="" method="post">
                          <div class="form-group">
                              <label for="">Enter the code provided by the event organizer</label>
                              <input type="text" name="code" class="form-control" required placeholder="Event Code" id="code">
                          </div>

                          <div class="form-group">
                              <input type="submit" name="join" class="btn btn-info" value="Submit" id="join">
                          </div>
                      </form>
                  </div>
                  <div class="overlay hide preloading">
                      <i class="fa fa-refresh fa-spin"></i>
                  </div>
                  <!-- /.box-body -->
              </div>
              <!-- /.box -->
        </div>
      </div>
</section>

<?php require_once 'assets/foot.php'?>
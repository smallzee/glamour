<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 10:03 AM
 */
$page_title = "Upcoming Events Calendar";
require_once 'core/core.php';

$user_id = user_details('id');
$current_date = date('m/d/Y');
$sql = $db->query("SELECT j.*,m.event_title, e_t.name as event_type_name, 
  m.event_time, m.event_date FROM ".DB_PREFIX."join_event as j 
  INNER JOIN ".DB_PREFIX."manage_event as m
  INNER JOIN ".DB_PREFIX."event_type as e_t
  ON j.event_id = m.id and m.event_type = e_t.id 
  WHERE j.user_id='$user_id' and m.event_date >='$current_date'");

while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
    $event_date = strtotime($rs['event_date']);
    $day = date('d',$event_date);
    $month = date('M',$event_date);
    $year = date('Y',$event_date);

    $event_date = $month. ' '.$day.' '.$year;

    $data[] = array(
        'id'=>$rs['id'],
        'event_id'=>$rs['event_id'],
        'event_date'=>$event_date,
        'event_time'=>$rs['event_time'],
        'event_type_name'=>ucwords($rs['event_type_name']),
        'event_title'=>ucwords($rs['event_title'])
      );
}
require_once 'assets/head.php';
?>

 <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="box box-border">
                  <div class="box-body no-padding">
                      <!-- THE CALENDAR -->
                      <div id="calendar"></div>
                  </div>
                  <!-- /.box-body -->
              </div>
          </div>
      </div>
    </section>
   

<?php require_once 'assets/foot.php'?>



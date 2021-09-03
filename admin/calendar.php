<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/15/2020
 * Time: 12:40 PM
 */

$page_title = "Upcoming Event Calendar";
require_once '../core/core.php';
require_permission('manage_event_calendar');
$current_date = date('m/d/Y');
$sql = $db->query("SELECT m.*, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as m
    INNER JOIN ".DB_PREFIX."event_type as e_t ON m.event_type = e_t.id
    WHERE m.event_date>='$current_date'");
while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
    $event_date = strtotime($rs['event_date']);
    $day = date('d',$event_date);
    $month = date('M',$event_date);
    $year = date('Y',$event_date);

    $event_date = $month. ' '.$day.' '.$year;

    $data[] = array(
        'event_id'=>$rs['id'],
        'event_date'=>$event_date,
        'event_time'=>$rs['event_time'],
        'event_type_name'=>ucwords($rs['event_type_name']),
        'event_title'=>ucwords($rs['event_title'])
    );
}
require_once 'libs/head.php';
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


<?php require_once 'libs/foot.php';?>

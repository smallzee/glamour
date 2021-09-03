<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/10/2020
 * Time: 3:41 PM
 */

$page_title = "";
require_once 'core/core.php';
@$event_id = $_GET['id'];
if (!isset($event_id)){
    redirect(base_url('404'));
    return;
}

if (empty($event_id)){
    redirect(base_url('404'));
    return;
}

$sql = $db->query("SELECT m.*, u.fname, et.name as event_type_name FROM ".DB_PREFIX."manage_event as m 
INNER JOIN ".DB_PREFIX."users as u ON m.user_id = u.id 
INNER JOIN ".DB_PREFIX."event_type as et ON m.event_type = et.id
WHERE m.id='$event_id'");
$num_row = $sql->rowCount();

if ($num_row == 0){
    redirect(base_url('404'));
    return;
}

$rs = $sql->fetch(PDO::FETCH_ASSOC);

$page_title.= $rs['event_title'];

$event_date = strtotime($rs['event_date']);

$duration = date('Y/m/d H:i:s',$event_date);

$sql2 = $db->query("SELECT * FROM ".DB_PREFIX."join_event whERE event_id='$event_id' and status IN ('1')");
$total2 = $sql2->rowCount();

if (isset($_POST['invite'])){
    @$email = explode(",",$_POST['email']);

    $total = count($email);


    if ($total > 0){
        for ($ii=0; $ii < $total; $ii++){
            if (!filter_var($email[$ii], FILTER_VALIDATE_EMAIL)){
                $error[] ="Invalid email address [".$email[$ii]."]"; //var_dump("error");
            }
        }
    }


    $error_count = count($error);

    if ($error_count == 0){

        for ($j =0; $j < count($email); $j++){
            $subject = "Event Invitation";//$rs['event_title'];

            $msg_body="<p>Dear, sir/ma </p>";
            $msg_body."<p>Event Details are listed below</p>";
            $msg_body.="<ol>".
                    "<li> Event Title : ".$rs['event_title']."</li>".
                    "<li> Event time : ".$rs['event_time']."</li>".
                    "<li> Event date : ".$rs['event_date']."</li>".
                    "<li> Event Address : ".$rs['address']."</li>".
                    "<li> Event Invitation link : ".INVITE.$rs['code'].'/'.$email[$j]."</li>".
                    "<li> Event Organizer : ".$rs['fname']."</li>";
              "</ol>";

            $msg_body.= '<p style="text-align:right;">Best Regards <br> Cant wait to have you </p>';
            send_mail($msg_body,$subject,$email[$j]);
        }

        set_flash("Event invitation has been sent successfully","info");

    }else{
        $msg = $error_count == 1 ? "An error occurred, please check and try again\n" : "Some errors occured, please check and try again\n";
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }

}

require_once 'assets/head.php';
?>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Invite friends/family to your event</h4>
            </div>
            <div class="modal-body">
                <form action="" class="form-group" method="post">
                    <div class="form-group ">
                        <label for="">Email Address</label>
                        <div class="bs-example">
                            <input type="text" name="email" value="<?= @$_POST['email'] ?>" data-role="tagsinput" class="form-control" required placeholder="Email Address" id="">
                        </div>
                        <small>Please Note : Please press enter to add more email address</small>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="invite" class="btn btn-primary" value="Invite" id="">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <?php flash(); ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-purple-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Venue Guest(s) Capacity</h2>
                    <h4 class="info-box-number">
                        <?= $rs['guest'] ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-purple-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Event Date</h2>
                    <h4 class="info-box-number">
                        <?= $rs['event_date'] ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">No Of Invited Guest(s)</h2>
                    <h4 class="info-box-number">
                        <?= $total2 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-green-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-code"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Event Code</h2>
                    <h4 class="info-box-number">
                        <?= $rs['code'] ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Available Of Guest(s) Capacity</h2>
                    <h4 class="info-box-number">
                        <?=  $rs['guest'] - $total2 ?>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box bg-blue-gradient elevation-3">
                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <h2 class="info-box-text">Days Left To The Event</h2>
                    <h4 class="info-box-number">
                       <div id="event-date-countdown"></div>
                    </h4>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">List Of Invited Guest(s)</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li>
                    <li class="pull-right"><a href="#" data-toggle="modal" data-target="#modal-default" class="text-muted"><i class="fa fa-user-plus"></i> Invite Friends/Family</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Email Address</th>
                                    <th>Full Name</th>
                                    <th>Phone Number</th>
                                    <th>Seat Number</th>
                                    <td>Join Date</td>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Email Address</th>
                                    <th>Full Name</th>
                                    <th>Phone Number</th>
                                    <th>Seat Number</th>
                                    <th>Join Date</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $sql = $db->query("SELECT j.*, u.fname, u.email, u.phone FROM ".DB_PREFIX."join_event as j 
                                        INNER JOIN ".DB_PREFIX."users as u ON j.user_id = u.id
                                        WHERE j.event_id='$event_id'");
                                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <tr>
                                                <td><?= $sn++ ?></td>
                                                <td><?= $rs['email'] ?></td>
                                                <td><?= $rs['fname'] ?></td>
                                                <td><?= $rs['phone'] ?></td>
                                                <td><?= $rs['seat'] ?></td>
                                                <td><?= $rs['join_date']  ?></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        The European languages are members of the same family. Their separate existence is a myth.
                        For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                        in their grammar, their pronunciation and their most common words. Everyone realizes why a
                        new common language would be desirable: one could refuse to pay expensive translators. To
                        achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                        words. If several languages coalesce, the grammar of the resulting language is more simple
                        and regular than that of the individual languages.
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                        sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                        like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>

    </div>
</section>

<?php require_once 'assets/foot.php';?>

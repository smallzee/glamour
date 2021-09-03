<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/17/2020
 * Time: 2:18 PM
 */

$page_title = "";
require_once 'core/core.php';

@$order_venue_id = $_GET['id'];
if (!isset($order_venue_id)){
    redirect(base_url('404'));
    return;
}

if (empty($order_venue_id)){
    redirect(base_url('404'));
    return;
}

$user_id = user_details('id');

$sql = $db->query("SELECT o.*, t.amount, v.title, 
v_t.name as venue_type, s.name as state, c.name as city, a.name as area, 
v.address, v.image, v.id as venue_id, v.guest, v.state_id, v.city_id, v.area_id 
FROM ".DB_PREFIX."order_venues as o 
INNER JOIN ".DB_PREFIX."transactions as t ON o.payment_id = t.id
INNER JOIN ".DB_PREFIX."venue as v ON o.venue_id = v.id 
INNER JOIN ".DB_PREFIX."venue_type as v_t ON v.venue_type = v_t.id   
INNER JOIN ".DB_PREFIX."state as s ON v.state_id = s.id
INNER JOIN ".DB_PREFIX."city as c ON v.city_id = c.id 
INNER JOIN ".DB_PREFIX."area as a ON v.area_id = a.id 
WHERE o.user_id='$user_id' and o.id='$order_venue_id' and o.verified != 0");

$num_row = $sql->rowCount();

if ($num_row == 0){
    redirect(base_url('404'));
    return;
}

$rs = $sql->fetch(PDO::FETCH_ASSOC);

$page_title = "Venue Details";//$rs['title'];


if (isset($_POST['add'])){
    $data = $_POST;
    $event_title = $data['title'];
    $event_type = $data['event-type'];
    $description = $data['description'];
    $event_time = $data['event-time'];

    $address = $rs['address'];
    $state_id = $rs['state_id'];
    $city_id = $rs['city_id'];
    $area_id = $rs['area_id'];
    $guest = $rs['guest'];
    $event_date = $rs['event_date'];
    $venue_id = $rs['venue_id'];
    $event_code = substr(rand(1000,9999), 0, 4);

    $current_date = date('m/d/Y');

    $sql2 = $db->query("SELECT * FROM ".DB_PREFIX."manage_event WHERE user_id='$user_id' and venue_id='$venue_id' and event_date='$event_date'");
    $num_row = $sql2->rowCount();

    if ($num_row >= 1){
        $error[] = "Event has already created";
    }

    if ($current_date >= $event_code){
        $error[] = "Unable to create an event";
    }

    if (isset($_FILES['card-image'])){
        $files = $_FILES['card-image'];
        $img_name = $files['name'];
        $path = pathinfo($img_name,PATHINFO_EXTENSION);
        $allowed = array('jpg','png','jpeg');

        if (!in_array($path, $allowed)){
            $error[] = "Invalid image format, it should be between jpg, jpeg, or png";
        }

        $filezise = $files['size'];

        if ($filezise > 1048576){
            $error[] = "Your image should not exceed 1MB";
        }

        $folder = "images/";
        $img = time().$img_name;
        $destination = $folder.$img;

    }

    $error_count = count($error);
    if ($error_count == 0){


        if (move_uploaded_file($files['tmp_name'],$destination)){
            $in = $db->query("INSERT INTO ".DB_PREFIX."manage_event (image,user_id,
            event_title,event_date,event_time,state_id,city_id,area_id,guest,description,address,code,venue_id,event_type)
            VALUES('$img','$user_id','$event_title','$event_date','$event_time','$state_id','$city_id','$area_id',
            '$guest','$description','$address','$event_code','$venue_id','$event_type')");

            $subject = "Event Details";
            $msg_body = "<p>Dear ".ucwords(user_details('fname'))."</p>";
            $msg_body.= "<p> Your event details are stated below! </p>";

            $msg_body.="<ol>".
                        "<li> Event Title : ".$event_title."</li>".
                        "<li> Event Date : ".$event_date."</li>".
                        "<li> Event Code : ".$event_code."</li>".
                        "<li> Venue Guest(s) Capacity : ".$guest."</li>".
                        "<li> Event Venue State : ".$rs['state']."</li>".
                        "<li> Event Venue City : ".$rs['city']."</li>".
                        "<li> Event Venue Area : ".$rs['area']."</li>".
                        "<li> Event Venue Address : ".$rs['address']."</li>".
                        "<li> Event Description : ".$destination."</li>"
                ."</ol>";
            $msg_body.='<p>Thanks for creating event with us </p>';
            $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';

            $email = user_details('email');
            send_mail($msg_body,$subject,$email);

            set_flash("Your event has been created successfully","info");

            redirect(VIEW_USER_VENUE.$order_venue_id);
        }
        
    }else{
        $msg = $error_count == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

require_once 'assets/head.php';
?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
   <div class="row">
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <?php flash(); ?>
           <div class="box">
               <div class="box-header with-border">
                   <h3 class="box-title"><?= $page_title ?></h3>
                   <div class="box-tools pull-right">
                       <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                               title="Collapse">
                           <i class="fa fa-minus"></i>
                       </button>
                   </div>
               </div>
               <div class="box-body">
                   Start creating your amazing application!
               </div>
               <!-- /.box-body -->

           </div>
       </div>

       <div class="col-lg-12 dol-md-12 col-sm-12 col-xs-12">
           <div class="box">
               <div class="box-header with-border">
                   <h3 class="box-title">Create Event</h3>
                   <div class="box-tools pull-right">
                       <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                               title="Collapse">
                           <i class="fa fa-minus"></i>
                       </button>
                   </div>
               </div>
               <div class="box-body">
                   <form action="" method="post" enctype="multipart/form-data">
                       <div class="row">
                           <div class="col-sm-12">
                               <div class="form-group">
                                   <label for="">Event Title</label>
                                   <input type="text" name="title" value="<?= @$_POST['title']; ?>" class="form-control" placeholder="Event Title" id="">
                               </div>
                           </div>

                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="">Event Type</label>
                                   <select name="event-type" id="" class="form-control" required>
                                       <option value="" disabled selected>Select</option>
                                       <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type ORDER BY name");
                                        while ($rs2 = $sql->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <option value="<?= $rs2['id'] ?>"><?= ucwords($rs2['name']) ?></option>
                                            <?php
                                        }
                                       ?>
                                   </select>
                               </div>
                           </div>

                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="">Event Time</label>
                                   <input type="text" class="form-control timepicker" placeholder="Event Time" value="<?= @$_POST['event-time'] ?>" required name="event-time" >
                               </div>
                           </div>

                           <div class="col-sm-12">
                               <div class="form-group">
                                   <label for="">Event Description</label>
                                   <textarea name="description" class="form-control" required style="resize: none" placeholder="Event Description"><?= @$_POST['description'] ?></textarea>
                               </div>
                           </div>

                          <div class="col-sm-12">
                              <div class="form-group">
                                  <label for="">Invitation Image</label>
                                  <div id="upload">
                                      <div id="image-preview">
                                          <label for="image-upload" id="image-label" style="background-image: url(images/author.jpg); width: 100%; background-repeat: no-repeat; background-position: center"></label>
                                          <input type="file" name="card-image" accept="image/*" id="image-upload">
                                      </div>
                                  </div>
                              </div>
                          </div>

                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="">Venue Guest(s) Capacity</label>
                                   <input type="text" disabled value="<?= $rs['guest'] ?>" class="form-control" name="" id="">
                               </div>
                           </div>

                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="">Event Date</label>
                                   <input type="text" class="form-control" value="<?= ucwords($rs['event_date']) ?>" disabled name="" id="">
                               </div>
                           </div>

                           <div class="col-sm-12">
                               <div class="form-group">
                                   <label for="">Venue State</label>
                                   <input type="text" class="form-control" value="<?= ucwords($rs['state']) ?>" disabled name="" id="">
                               </div>
                           </div>

                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="">venue Area</label>
                                   <input type="text" class="form-control" value="<?= ucwords($rs['area']) ?>" disabled name="" id="">
                               </div>
                           </div>


                           <div class="col-sm-6">
                               <div class="form-group">
                                   <label for="">Venue City</label>
                                   <input type="text" class="form-control" value="<?= ucwords($rs['city']) ?>" disabled name="" id="">
                               </div>
                           </div>


                           <div class="col-sm-12">
                               <div class="form-group">
                                   <label for="">Venue Address</label>
                                   <textarea class="form-control" disabled><?= $rs['address'] ?></textarea>
                               </div>
                           </div>
                       </div>

                       <div class="form-group">
                           <input type="submit" class="btn btn-primary" value="Submit" name="add" id="">
                       </div>
                   </form>
               </div>
               <!-- /.box-body -->
           </div>
       </div>
   </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<?php require_once 'assets/foot.php';?>

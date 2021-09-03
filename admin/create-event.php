<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/1/2020
 * Time: 4:25 PM
 */

  $page_title = "Create Event";
  require_once '../core/core.php';
  if (isset($_POST['add'])) {
      $event_title = $_POST['event-title'];
      $event_type = $_POST['event-type'];
      $event_date = $_POST['event-date'];
      $request = $_POST['request'];
      $state_id = $_POST['state'];
      $city_id = $_POST['city'];
      $guest = $_POST['guest'];
      $area = $_POST['area'];
      $status = $_POST['status'];
      $description = $_POST['description'];

      @$fname = $_POST['fname'];
      @$email = strtolower($_POST['email']);
      @$user_id = $_POST['user-id'];
      @$phone = $_POST['phone'];

      switch ($request){
          case "" :
          $error[]  = "s";
          break ;
          case 0 :
                  $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
                  $num_row = $sql->rowCount();

                  if ($num_row >= 1){
                      $error[] = "Email address has already exits";
                  }

                  if (strlen($fname) < 8 or strlen($fname) > 100) {
                      $error[] = "Full name should be between 8 - 100 characters";
                  }

                  if (strlen($email) < 8 or strlen($email) > 200) {
                      $error[] = "Email address should be between 8 - 200 characters";
                  }

                  if (!validate_phone_number($phone) != true){
                      $error[] = "Invalid phone number";
                  }

              break;
          case 1 :

          if (empty($user_id)){
              $error[] = "You must selected ";
          }

          break;
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

          $folder = "../images/";
          $img = time().$img_name;
          $destination = $folder.$img;

      }

      $error_count = count($error);
      if ($error_count == 0){

          if (move_uploaded_file($files['tmp_name'], $destination)){

              switch ($request){
                  case 0 :
                      $fn = explode(" ",$fname);
                      $password = strtolower($fn[0]);

                      $hash_password = sha1($password);

                      $created_at = time();
                      $in = $db->query("INSERT INTO ".DB_PREFIX."users (fname,email,phone,password,created_at)
                      VALUES('$fname','$email','$phone','$hash_password','$created_at')");

                      $last_user_id = $db->lastInsertId();

                      $subject = "Account Details";
                      $msg_body = "<p>Dear ".ucwords($fname)."</p>";
                      $msg_body.= "<p> Your account details are stated below! </p>";

                      $msg_body.="<ol>".
                              "<li> Full Name : ".$fname."</li>".
                              "<li> Email Address : ".$email."</li>".
                              "<li> Phone Number : ".$phone."</li>".
                               "<li>Password : ".$password."</li>".
                              "<li> Account status : Approved</li>"
                          ."</ol>";
                      $msg_body.='<p>Thanks for creating account with us </p>';
                      $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';
                      send_mail($msg_body,$subject,$email);

                      break;
                  case 1 :
                      $last_user_id = $user_id;
                      break;
              }

              $code = substr(rand(1000,9999), 0, 4);

              $in2 = $db->query("INSERT INTO ".DB_PREFIX."manage_event (image,user_id,event_title,
              event_type,event_date,state_id,city_id,area,guest,description,code,status)
              VALUES('$img','$last_user_id','$event_title','$event_type','$event_date','$state_id','$city_id',
              '$area','$guest','$description','$code','$status')");

              $sql1 = $db->query("SELECT id,email,fname FROM ".DB_PREFIX."users WHERE id='$last_user_id'");
              $rs = $sql1->fetch(PDO::FETCH_ASSOC);

              $email2 = $rs['email'];
              $fname2 = $rs['fname'];

              $sql2 = $db->query("SELECT c.name as city, s.name as state FROM ".DB_PREFIX."city as c INNER JOIN ".DB_PREFIX."state as s 
              ON c.state_id = s.id WHERE c.id ='$city_id'");
              $rs2 = $sql2->fetch(PDO::FETCH_ASSOC);

              $subject = "Event Details";
              $msg_body = "<p>Dear ".ucwords($fname)."</p>";
              $msg_body.= "<p> Your event details are stated below! </p>";

              $msg_body.="<ol>".
                          "<li> Event Title : ".$event_title."</li>".
                          "<li> Event Date : ".$event_date."</li>".
                          "<li> Event Code : ".$code."</li>".
                          "<li> Number of guest : ".$guest."</li>".
                          "<li> State : ".$rs2['state']."</li>".
                          "<li> City : ".$rs2['city']."</li>".
                          "<li> Area : ".$area."</li>".
                          "<li> Event Description : ".$destination."</li>"
                  ."</ol>";
              $msg_body.='<p>Thanks for creating event with us </p>';
              $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';
              send_mail($msg_body,$subject,$email2);

              set_flash("Event hs been created successfully","info");

              redirect(base_url('admin/create-event'));

          }


      }else{
          $err_msg = count($error_count) == 1 ? "An error occured, please check and try again\n" : "Some errors occured, please check and try again\n";
          foreach ($error as $value){
              $err_msg.='<p>'.$value.'</p>';
          }
          set_flash($err_msg,'danger');
      }
  }
  require_once 'libs/head.php';
  ?>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12">
        <!-- DIRECT CHAT -->
        <div class="card ">
          <div class="card-header">
            <h3 class="card-title"><?= $page_title  ?></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <!--   <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button> -->
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

              <?php flash(); ?>

              <form action="" method="post" enctype="multipart/form-data">
                  <div class="row">

                      <div class="col-sm-12">
                          <div class="form-group">
                              <label for="">Event Title</label>
                              <input type="text" class="form-control" value="<?= @$_POST['event-title'] ?>" name="event-title" placeholder="Event Title" id="">
                          </div>
                      </div>

                      <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Event Type</label>
                                <select name="event-type" class="form-control" required id="">
                                    <option value="" disabled selected>Select</option>
                                    <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type ORDER BY name");
                                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                      </div>
                      
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Event Date</label>
                              <input type="text" value="<?= @$_POST['event-date'] ?>" class="form-control" data-toggle="datepicker" placeholder="Event Date" required name="event-date" id="">
                          </div>
                      </div>

                      <div class="col-sm-12">
                          <div class="form-group">
                              <label>State</label>
                              <select class="form-control" required="" name="state" id="state">
                                  <option disabled="" selected="">Select</option>
                                  <?php
                                  $sql_state = $db->query("SELECT * FROM ".DB_PREFIX."state ORDER BY name");
                                  while ($rs = $sql_state->fetch(PDO::FETCH_ASSOC)) {
                                      ?>
                                      <option value="<?= $rs['id']  ?>"><?= ucfirst($rs['name'])  ?></option>
                                      <?php
                                  }
                                  ?>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>City</label>
                              <select class="form-control" required="" name="city" id="city">
                                  <option disabled="" selected="">Select</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-6">
                          <div class="form-group">
                              <label>Area</label>
                              <input type="text" value="<?= @$_POST['area'] ?>" name="area" class="form-control" required="" placeholder="Area">
                          </div>
                      </div>

                      <div class="col-sm-12">
                          <div class="form-group">
                              <label for="">Number of guests</label>
                              <input type="number" value="<?= @$_POST['guest'] ?>" class="form-control" min="1" autocomplete="off" name="guest" required placeholder="Number of guest" id="">
                          </div>
                      </div>

                      <div class="col-sm-6">
                        <label>I am creating this event on behalf of someone else </label>
                          <div class="form-group">
                             <label class="switch">
                                  <input type="radio" class="request" value="0" name="request">
                                  <span class="slider round"></span>
                              </label>
                          </div>
                      </div>

                      <div class="col-sm-6">
                        <label>I am creating this event on behalf of registered user</label>
                        <div class="form-group">
                             <label class="switch">
                                  <input type="radio" class="request" value="1" name="request">
                                  <span class="slider round"></span>
                              </label>
                          </div>
                      </div>

                      <div class="col-sm-12">
                         <div class="hidden-1">
                           <div class="row">
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="fname" value="<?= @$_POST['fname'] ?>" class="form-control"  placeholder="Full Name">
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" value="<?= @$_POST['email'] ?>" class="form-control"  placeholder="Email Address">
                              </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" value="<?= @$_POST['phone'] ?>" class="form-control" placeholder="Phone Number">
                                </div>
                            </div>
                          </div>
                        </div>  

                         <div class="form-group hidden-2">
                            <label>Select User</label>
                            <select class="form-control" name="user-id">
                              <option disabled="" selected="">Select</option>
                              <?php 
                                $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role =1 ORDER BY id DESC");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                  ?>
                                  <option value="<?= $rs['id']  ?>"><?= ucwords($rs['fname'])  ?> (<?= $rs['email'] ?> )</option>
                                  <?php
                                }
                               ?>
                            </select>
                          </div>    
                      </div>

                      <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Event Status</label>
                              <select name="status" class="form-control" required id="">
                                  <option value="" disabled selected>Select</option>
                                  <option value="public">Public</option>
                                  <option value="private">Private</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Event Destination</label>
                              <div class="input-group">
                                  <input type="text" class="form-control" name="" id="" placeholder="Destination">
                                  <span class="input-group-btn">
                                      <button class="btn btn-info" style="border-radius: 0;" type="submit"><i class="fa fa-map-marker"></i></button>
                                  </span>
                              </div>
                          </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Event Description</label>
                          <textarea class="form-control" required="" name="description" placeholder="Description" style="resize: none;"><?= @$_POST['description'] ?></textarea>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Event Invitation Card</label>
                          <div id="upload">
                              <div id="image-preview">
                                  <label for="image-upload" id="image-label" style="background-image: url(../images/author.jpg); width: 100%; background-repeat: no-repeat; background-position: center"></label>
                                  <input type="file" name="card-image" accept="image/*" id="image-upload">
                              </div>
                          </div>

                            <small>Maximum uploading filesize 1MB</small>
                            <br>
                            <small>Allowed file format jpg, jpeg or png</small>
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <input type="submit" class="btn btn-info" name="add" value="Submit">
                  </div>
              </form>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'libs/foot.php';?>

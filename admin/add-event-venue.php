<?php 
	$page_title = "Create Event Venue";
	require_once '../core/core.php';
	  if (isset($_POST['add'])) {
	  	  $title = $_POST['title'];
	  	  $guest = $_POST['guest'];
	  	  $amenities = json_encode($_POST['amenities']);
	  	  $venue_type = $_POST['venue-type'];
	  	  $price = $_POST['price'];
	  	  $area_id = $_POST['area-id'];
	  	  $address = $_POST['address'];
	  	  $state_id = $_POST['state'];
	  	  $city_id = $_POST['city'];
	  	  $description = $_POST['description'];

	  	  // var_dump($amenities);
	  	  // exit();

	  	  if (!isset($_FILES['images'])) {
	  	  	  $error[] = "Venue image is required";
	  	  }

  	  	 $files = $_FILES['images'];
  	  	 $image = $files['name'];
  	  	 $total = count($image);
  	  	 $pri_image = $files['name'][0];

  	  	 $allowed = array('jpg','png','jpeg');

  	  	 foreach ($image as  $value) {
  	  	 	$path = pathinfo($value[0], PATHINFO_EXTENSION);
  	  	 	if(!in_array($path, $allowed)){
  	  			$error[] = $value[0]."  should be jpg, png, or jpeg format";
  	  		}	
  	  	 }

  	  	 $folder = "../images/";
  	  	 // upload primary image
  	  	 $pri_image2 = time().$pri_image[0];
  	  	 $destination = $folder.$pri_image2;
  	  	 $tmp_name = $files['tmp_name'][0][0];

	 	$err_count = count($error);
	 	if ($err_count == 0) {
	 	 

	 	 if (move_uploaded_file($tmp_name, $destination)) {

             $in = $db->query("INSERT INTO ".DB_PREFIX."venue (image,title,description,
             venue_type,guest,amenities,state_id,city_id,area_id,price,address)
 	 		VALUES('$pri_image2','$title','$description','$venue_type','$guest','$amenities','$state_id'
 	 		,'$city_id','$area_id','$price','$address')");

             $venue_id = $db->lastInsertId();

             for($ii=0; $ii < count($total);$ii++){
		 	 	$image_name = $files['name'];
		 	 	$tmp_name2 = $files['tmp_name'];
		 	 	
		 	 	for($j =0; $j < count($image_name);$j++){
		 	 		$image_name2 = $image_name[$j][0];
		 	 		
		 	 		$temp_name = $tmp_name2[$j][0];
		 	 		$img_names = time().$image_name2;

		 	 		$destination2 = $folder.$img_names;

		 	 		move_uploaded_file($temp_name, $destination2);

		 	 		$in2 = $db->query("INSERT INTO ".DB_PREFIX."venue_images (venue_id,image)VALUES('$venue_id','$img_names')");
		 	 		$all_images[] = $img_names;
		 	 	}
		 	 }


		 	 $all_images2 = json_encode($all_images);

             // update venue for all images fetch for app
             $up = $db->query("UPDATE ".DB_PREFIX."venue SET all_images='$all_images2' WHERE id='$venue_id'");

	 	 }

	 	
	 	 set_flash("Venue has been uploaded successfully","info");

	 	 } else{
	 	 	$err_msg = $err_count == 1 ? "An error occurred, please check and try again\n" : "Some errors occured, please check and try again\n";
	 	 	foreach ($error as $value) {
	 	 		$err_msg.='<p>'.$value.'</p>';
	 	 	}
	 	 	set_flash($err_msg,'danger');
	 	 }
	  }
	require_once 'libs/head.php';
 ?>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php flash(); ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Event Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Venue Name</label>
                                    <input type="text" class="form-control" id="title" required="" placeholder="Venue Name" name="title">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Number Of Occupied Guest</label>
                                    <input type="number" min="0" autocomplete="off" class="form-control" placeholder="Number of guest" name="guest">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Event Amenities</label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" name="amenities[]" data-placeholder="Select a event amenities" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                            <?php
                                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."amenities ORDER BY name");
                                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <option><?= ucwords($rs['name']);  ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Venue Type</label>
                                    <select class="form-control" style="width: 100%;" required="" name="venue-type" data-placeholder="Select venue type">
                                        <option selected="" disabled="">Select</option>
                                        <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."venue_type ORDER BY name");
                                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?= $rs['id']  ?>"><?= ucwords($rs['name'])  ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Venue Price</label>
                                    <input type="number" min="0" class="form-control" required="" name="price" placeholder="Venue Price">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description"  id="compose-textarea" required="" placeholder="Description" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Event Venue Location</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="row">
                            <div class="col-sm-6">
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

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Area</label>
                                    <select name="area-id" id="area" required class="form-control">
                                        <option value="" selected disabled>Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Venue Location</label>
                                    <textarea name="address" class="form-control" required placeholder="Address" id="" ></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Event Venue Image</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="input-field">
                                <div class="input-images-1" style="padding-top: .5rem;"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" id="add" class="btn btn-primary"  value="Submit" name="add">
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>


        </div>
    </form>
    <!-- /.box -->
</section>
<!-- /.content -->



 <?php require_once 'libs/foot.php'; ?>                                                                                                                                                                                                                                                           
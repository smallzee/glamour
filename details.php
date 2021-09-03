<?php 
	$page_title = "";
	require_once 'initialize.php';

    $venue_id = $_GET['id'];
	if (!isset($venue_id)){
	    redirect(base_url('404'));
	    return;
    }

    if (empty($venue_id)){
        redirect(base_url('404'));
        return;
    }

    $sql = $db->query("SELECT v.*, s.name as state_name,
    c.name as city_name, vt.name as venue_type_name, a.name as area FROM ".DB_PREFIX."venue as v 
    INNER JOIN ".DB_PREFIX."state as s 
    INNER JOIN ".DB_PREFIX."city as c INNER JOIN ".DB_PREFIX."venue_type as vt 
    ON v.state_id = s.id and v.city_id = c.id and v.venue_type = vt.id
    LEFT JOIN ".DB_PREFIX."area as a  ON v.area_id = a.id 
    WHERE v.id ='$venue_id'");

    $num_row = $sql->rowCount();

    if ($num_row == 0) {
        redirect(base_url('404'));
        return;
    }

    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    $page_title.= $rs['title'];
    $amenities = json_decode($rs['amenities'], true);
    $all_images = json_decode($rs['all_images'],true);


	if (isset($_POST['book-venue'])) {
		user_is_required_to_login();
		$data = @$_POST;
		$data['amount'] = $rs['price'];
		$data['user_id'] = user_details('id');
		$data['email'] = user_details('email');
		$data['venue_id'] = $venue_id;

		if (empty($data['event-date'])){
		    $error[] = "All field(s) are required";
        }

        $event_date = $data['event-date'];

		$sql = $db->query("SELECT * FROM ".DB_PREFIX."order_venues 
		WHERE event_date='$event_date' and venue_id='$venue_id' and verified !=0");

		$num_row = $sql->rowCount();

		if ($num_row >= 1){
		    $error[] = "Venue has already been booked on ".$event_date.", you may change your event date";
        }

        $error_count = count($error);
        if ($error_count == 0){

            redirect_paystack($data);

        }else{
            $msg = $error_count == 1 ? "An error occurred while booking venue, please check and try again\n" : "Some errors occurred while, please check and try again\n";
            foreach ($error as $value){
                $msg.='<p>'.$value.'</p>';
            }
            $data['msg'] = $msg;
            set_flash($msg,'danger');
        }
	}

	require_once 'libs/head.php';
 ?>

     <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Book Event Centre</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <form method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Event Date</label>
                            <input name="event-date" type="text" required value="<?= @$_POST['event-date'] ?>" readonly class="flatpickr flatpickr-input form-control" data-toggle="datepicker" placeholder="Event Date">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Proceed" name="book-venue">
                </div>
           </form>
          </div>
        </div>
      </div>
    </div>

   <!-- Hero Start -->
        <section class="bg-half bg-light d-table w-100" style="background-image: url('<?=img_url($rs['image']) ?>')">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="page-next-level">
                            <h2 class="text-white"><?= $rs['title']  ?> </h2>
                            <div class="page-next">
                                <nav aria-label="breadcrumb" class="d-inline-block">
                                    <ul class="breadcrumb bg-white rounded shadow mb-0">
                                        <li class="breadcrumb-item"><a href="<?= base_url('') ?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="#"><?= ucwords($rs['state_name']) ?></a></li>
                                        <li class="breadcrumb-item"><a href="#"><?= ucwords($rs['city_name'])  ?></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $rs['area']  ?></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div> <!--end container-->
        </section><!--end section-->
        <!-- Hero End -->


        <!-- Blog STart -->
        <section class="section">
            <div class="container">
                <div class="row">
                	<div class="col-lg-12">
                		<?php flash(); ?>
                	</div>
                    <!-- BLog Start -->
                    <div class="col-lg-8 col-md-6">
                       <div class="card blog blog-detail border-0 shadow rounded">
                            <div class="item">            
						            <div class="clearfix" >
						                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
						                    <?php 
						                    	for($ii =0; $ii < count($all_images);$ii++){
						                    		?>
						                    		<li data-thumb="<?= img_url($all_images[$ii])  ?>"> 
							                       		 <img src="<?= img_url($all_images[$ii])  ?>" class="img-fluid rounded-top" />
							                         </li>
						                    		<?php
						                    	}
						                     ?>
						                </ul>
						            </div>
						        </div>
                            <div class="card-body content">
                                <!-- <h6><i class="mdi mdi-tag text-primary mr-1"></i><a href="javscript_3Avoid(0)" class="text-primary">Software</a>, <a href="javscript_3Avoid(0)" class="text-primary">Application</a></h6> -->
                                
                                <div class="post-meta mt-3">
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item mr-2">
                                        	<a href="javascript:void(0)" class="text-muted like">
                                        		<i class="mdi uil-users-alt"></i> Guest(s) Capacity  : <?= number_format($rs['guest'])  ?></a>
                                        </li>
                                        <li class="list-inline-item">
                                        	<a href="javascript:void(0)" class="text-muted comments">
                                        		<i class="mdi mdi-home mr-1"></i>Venue Type : <?= ucwords($rs['venue_type_name'])  ?></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0)" class="text-muted comments">
                                                <i class="mdi mdi-home mr-1"></i>Venue Price : <?= amount_format($rs['price'])  ?></a>
                                        </li>
                                    </ul>

                                    <p class="text-muted">
                                        <h5>Event Venue Location</h5>
                                         <hr>
                                        <?= $rs['address'] ?>
                                    </p>

	                                <p class="text-muted">
	                                	<h5>Event Venue Description</h5>
                                        <hr>
	                                	<?= $rs['description']  ?>
	                                </p>
	                            </div>


                                <div id="map"></div>
                                <input type="hidden" value="120 Rue Louise, Longueuil, QC J4J 2S9" id="end" />


                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Book Now</a>
                            </div>
                        </div>

                         <div class="card shadow rounded border-0 mt-4">
                            <div class="card-body">
                                <h5 class="card-title mb-0" style="padding-bottom: 20px">Related venues in : <?= ucwords($rs['state_name']) ." , ". ucwords($rs['city_name']) ?></h5>

                                <hr>
                                	 <div class="row">
		                                <?php 
		                                	$state_id = $rs['state_id'];
		                                	$city_id = $rs['city_id'];

		                                	$sql2 = $db->query("SELECT * FROM ".DB_PREFIX."venue WHERE state_id='$state_id' and city_id='$city_id' and id!='$venue_id' ORDER BY RAND() LIMIT 0,2");

		                                	if ($sql2->rowCount() == 0) {
		                                		?>
		                                		<div class="col-sm-12">
		                                			<?php alert("No related venue available for ".$rs['state_name'].' , '.$rs['city_name'],"info"); ?>
		                                		</div>
		                                		<?php

												}else{

		                                	while ($rs4 = $sql2->fetch(PDO::FETCH_ASSOC)) {
		                                		?>
		                                		        <div class="col-lg-6 col-md-6 mt-4 pt-2">
				                                        <div class="card blog rounded border-0 shadow">
				                                            <div class="position-relative">
				                                                <img src="<?= img_url($rs4['image']);  ?>" class="card-img-top rounded-top" alt="...">
				                                            <div class="overlay rounded-top bg-dark"></div>
				                                            </div>
				                                            <div class="card-body content">
				                                                <h6>
				                                                    <a href="<?= VIEW_VENUE.$rs4['id']; ?>" class="card-title title text-dark"><?= $rs4['title']  ?></a>
				                                                </h6>
				                                                <div class="post-meta d-flex justify-content-between mt-3">
				                                                    <ul class="list-unstyled mb-0">
				                                                        <li class="list-inline-item mr-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="mdi uil-user-md mr-1"></i>Guests <?= number_format($rs4['guest']);  ?></a></li>
				                                                        <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="mdi mdi-comment-outline mr-1"></i>08</a></li>
				                                                    </ul>
				                                                    <a href="<?= VIEW_VENUE.$rs4['id']; ?>" class="text-muted readmore">Read More <i class="mdi mdi-chevron-right"></i></a>
				                                                </div>
				                                            </div>
				                                            <div class="author">
				                                                <small class="text-light user d-block"><i class="mdi mdi-account"></i> Calvin Carlo</small>
				                                                <small class="text-light date"><i class="mdi mdi-calendar-check"></i> <?= $rs4['created_at']  ?></small>
				                                            </div>
				                                        </div>
				                                    </div><!--end col-->
		                                		<?php
		                                	}}
		                                 ?>
		                        	 </div>

                            </div>
                        </div>

                    </div>
		<!-- START SIDEBAR -->
                    <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="card border-0 sidebar sticky-bar rounded shadow">
                            <div class="card-body">
                                <!-- SEARCH -->
                                <div class="widget mb-4 pb-2">
                                    <h4 class="widget-title">Search</h4>
                                    <div id="search2" class="widget-search mt-4 mb-0">
                                        <form role="search" method="get" id="searchform" class="searchform">
                                            <div>
                                                <input type="text" class="border rounded" name="s" id="s" placeholder="Search Keywords...">
                                                <input type="submit" id="searchsubmit" value="Search">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- SEARCH -->
    
     							<!-- SOCIAL -->
                                <div class="widget">
                                    <h5 class="widget-title">Share</h5>
                                    <ul class="list-unstyled social-icon mb-0 mt-4">
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                        <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                                    </ul><!--end icon-->
                                </div>
                                <!-- SOCIAL -->
                                
  
                                <!-- TAG CLOUDS -->
                                <div class="widget mb-4 pb-2">
                                    <h4 class="widget-title">Event Venue Amenities</h4>
                                    <div class="tagcloud mt-4">
                                    	<?php 
                                    		for($ii =0; $ii < count($amenities);$ii++){
	                                			?>
	                                    			<a href="#" class="rounded"><?= $amenities[$ii];  ?></a>
	                                			<?php
                                    		}
                                    	 ?>
                                    </div>
                                </div>
                                <!-- TAG CLOUDS -->
                                
                               
                            </div>
                        </div>
                    </div><!--end col-->
                    <!-- END SIDEBAR -->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Blog End -->



 <?php require 'libs/foot.php'; ?>
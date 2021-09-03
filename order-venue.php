<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/17/2020
 * Time: 1:38 PM
 */

$page_title = "Ordered Venues";
require_once 'core/core.php';
require_once 'assets/head.php';
?>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
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
           <div class="table-responsive">
               <table class="table table-bordered" id="example1">
                   <thead>
                   <tr>
                       <th>SN</th>
                       <th>Image</th>
                       <th>Venue Title</th>
                       <th>Venue Type</th>
                       <th>Event Date</th>
                       <th>Amount Paid</th>
                       <th>State</th>
                       <th>City</th>
                       <th>Area</th>
                       <th>Address</th>
                       <th>Created At</th>
                       <th>Actions</th>
                   </tr>
                   </thead>
                   <tfoot>
                   <tr>
                       <th>SN</th>
                       <th>Image</th>
                       <th>Venue Title</th>
                       <th>Venue Type</th>
                       <th>Event Date</th>
                       <th>Amount Paid</th>
                       <th>State</th>
                       <th>City</th>
                       <th>Area</th>
                       <th>Address</th>
                       <th>Created At</th>
                       <th>Actions</th>
                   </tr>
                   </tfoot>
                   <?php
                    $sql = $db->query("SELECT o.*, t.amount, v.title, 
                    v_t.name as venue_type, s.name as state, c.name as city, a.name as area, 
                    v.address, v.image, v.id as venue_id 
                    FROM ".DB_PREFIX."order_venues as o 
                    INNER JOIN ".DB_PREFIX."transactions as t ON o.payment_id = t.id
                    INNER JOIN ".DB_PREFIX."venue as v ON o.venue_id = v.id 
                    INNER JOIN ".DB_PREFIX."venue_type as v_t ON v.venue_type = v_t.id   
                    INNER JOIN ".DB_PREFIX."state as s ON v.state_id = s.id
                    INNER JOIN ".DB_PREFIX."city as c ON v.city_id = c.id 
                    INNER JOIN ".DB_PREFIX."area as a ON v.area_id = a.id 
                    WHERE o.user_id='$user_id' and o.verified > 0");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><img src="<?= image_url($rs['image']) ?>" class="img-thumbnail img-size" alt=""></td>
                            <td><?= $rs['title'] ?></td>
                            <td><?= $rs['venue_type'] ?></td>
                            <td><?= $rs['event_date'] ?></td>
                            <td><?= amount_format($rs['amount']) ?></td>
                            <td><?= $rs['state'] ?></td>
                            <td><?= $rs['city'] ?></td>
                            <td><?= $rs['area'] ?></td>
                            <td><?= $rs['address'] ?></td>
                            <td><?= $rs['created_at'] ?></td>
                            <td><a href="<?= VIEW_USER_VENUE.$rs['id'] ?>" class="btn btn-primary btn-sm">View</a></td>
                        </tr>
                        <?php
                    }
                   ?>
               </table>
           </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<?php require_once 'assets/foot.php';?>

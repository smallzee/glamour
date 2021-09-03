<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/10/2020
 * Time: 3:26 PM
 */

$page_title = "My Events";
require_once 'core/core.php';
user_is_required_to_login();
$user_id = user_details('id');
$sn=1;
require_once 'assets/head.php';
?>

 <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm1-12 col-xs-12">
              <div class="box">
                  <div class="box-header with-border">
                      <h3 class="box-title"><?= $page_title ?></h3>
                      <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                              <i class="fa fa-minus"></i></button>
                      </div>
                  </div>
                  <div class="box-body">
                      <div class="table-responsive">
                          <table class="table table-bordered" id="example1">
                              <thead>
                              <tr>
                                  <th>Sn</th>
                                  <th>Image</th>
                                  <th>Event Title</th>
                                  <th>Event Date</th>
                                  <th>Event Type</th>
                                  <th>Guest</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Area</th>
                                  <th>Actions</th>
                              </tr>
                              </thead>
                              <tfoot>
                              <tr>
                                  <th>Sn</th>
                                  <th>Image</th>
                                  <th>Event Title</th>
                                  <th>Event Date</th>
                                  <th>Event Type</th>
                                  <th>Guest</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Area</th>
                                  <th>Actions</th>
                              </tr>
                              </tfoot>
                              <tbody>
                              <?php
                              $sql1 = $db->query("SELECT e.*, c.name as city, s.name as 
                                state, e_t.name as event_type_name, a.name as area
                                FROM ".DB_PREFIX."manage_event as e 
                                INNER JOIN ".DB_PREFIX."event_type as e_t 
                                INNER JOIN ".DB_PREFIX."city as c 
                                INNER JOIN ".DB_PREFIX."state as s
                                INNER JOIN ".DB_PREFIX."area as a
                                ON e.event_type = e_t.id and e.state_id = s.id 
                                and e.city_id = c.id and e.area_id = a.id
                                WHERE e.user_id='$user_id' ORDER BY e.id DESC");
                              while ($rs = $sql1->fetch(PDO::FETCH_ASSOC)){
                                  ?>
                                  <tr>
                                      <td><?= $sn++ ?></td>
                                      <td><a href="<?= img_url($rs['image']) ?>"><img src="<?= img_url($rs['image']) ?>" class="img-thumbnail " style="width: 50px; height: 50px;" alt=""></a></td>
                                      <td><?= $rs['event_title'] ?></td>
                                      <td><?= $rs['event_date'] ?></td>
                                      <td><?= ucwords($rs['event_type_name']) ?></td>
                                      <td><?= $rs['guest'] ?></td>
                                      <td><?= $rs['state'] ?></td>
                                      <td><?= $rs['city'] ?></td>
                                      <td><?= $rs['area'] ?></td>
                                      <td><a href="<?= VIEW_USER_EVENT.$rs['id']; ?>" class="btn btn-primary btn-sm"> View</a></td>
                                  </tr>
                                  <?php
                              }
                              ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
                  <!-- /.box-body -->
              </div>
              <!-- /.box -->

        </div>
      </div>
    </section>
 

<?php require_once 'assets/foot.php';?>

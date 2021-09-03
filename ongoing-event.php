<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/11/2020
 * Time: 3:31 PM
 */

$page_title = "Upcoming Events";
require_once 'core/core.php';
require_once 'assets/head.php';
?>

 <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
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
                                  <th>Seat Number</th>
                                  <th>Event Title</th>
                                  <th>Event Date</th>
                                  <th>Event Type</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Actions</th>
                              </tr>
                              </thead>
                              <tfoot>
                              <tr>
                                  <th>Sn</th>
                                  <th>Image</th>
                                  <th>Seat Number</th>
                                  <th>Event Title</th>
                                  <th>Event Date</th>
                                  <th>Event Type</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Actions</th>
                              </tr>
                              </tfoot>
                              <tbody>

                              <?php
                              @$data = get_upcoming_events(TRUE);
                              if (is_array($data) && count($data) > 0) {
                                  for($ii =0; $ii < count($data); $ii++){
                                      ?>
                                      <tr>
                                          <td><?= $sn++  ?></td>
                                          <td></td>
                                          <td><?= $data[$ii]['seat']  ?></td>
                                          <td><?= $data[$ii]['event_title']  ?></td>
                                          <td><?= $data[$ii]['event_date']  ?></td>
                                          <td><?= $data[$ii]['event_type_name']  ?></td>
                                          <td><?= $data[$ii]['state']  ?></td>
                                          <td><?= $data[$ii]['city']  ?></td>
                                          <td><a href="<?= VIEW_USER_EVENT.$data[$ii]['event_id'].'&page=upcoming-event'; ?>" class="btn btn-outline-info btn-sm"><i class="fa fa-eye"></i> View</a></td>
                                      </tr>
                                      <?php
                                  }
                              }
                              ?>

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <!-- /.box -->
          </div>
              <!-- /.card-footer-->
      </div>
    </section>

<?php require_once 'assets/foot.php'?>


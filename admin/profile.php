<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/8/2020
 * Time: 1:11 PM
 */

$page_title = "User Profile";
require_once '../core/core.php';
if (isset($_GET['id'])){
    $user_id = $_GET['id'];
    if (empty($user_id)){
        redirect(base_url('admin/404'));
        return;
    }

    $sql = $db->query("SELECT u.*, r.name as role FROM ".DB_PREFIX."users as u INNER JOIN ".DB_PREFIX."role as r ON u.role = r.id WHERE u.id='$user_id'");
    $num_row = $sql->rowCount();

    if ($num_row = 0){
        redirect(base_url('admin/404'));
        return;
    }

    $rs = $sql->fetch(PDO::FETCH_ASSOC);

}else{
    redirect(base_url('admin/404'));
}
require_permission('manage_users');
require_once 'libs/head.php';
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header  elevation-3 bg-gradient-purple">
                        <h3 class="widget-user-username"><?= $rs['fname'] ?></h3>
                        <h5 class="widget-user-desc"><?= $rs['role'] ?></h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="<?= img_url('author.jpg') ?>" alt="User Avatar">
                    </div>
                    <div class="card-footer bg-white">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <span class="description-text text-capitalize" style="font-weight: bold">Email Address</span>
                                    <h5 class="description-header" style="font-weight: normal"><?= $rs['email'] ?></h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <span class="description-text text-capitalize" style="font-weight: bold">Registered Date</span>
                                    <h5 class="description-header" style="font-weight: normal"><?= date('Y-m-d',$rs['created_at']) ?></h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <span class="description-text text-capitalize" style="font-weight: bold">Phone Number</span>
                                    <h5 class="description-header" style="font-weight: normal"><?= $rs['phone'] ?></h5>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>

            <div class="col-lg-4 col-sm-12">
                <!-- small card -->
                <div class="small-box bg-gradient-purple elevation-3">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Ongoing Events</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <!-- small card -->
                <div class="small-box bg-gradient-pink elevation-3">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Past Events</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <!-- small card -->
                <div class="small-box bg-gradient-purple elevation-3">
                    <div class="inner">
                        <h3>150</h3>
                        <p>My Events</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            <div class="col-md-12 col-lg-12 col-sm-12">
                <!-- DIRECT CHAT -->
                <div class="card  card-tabs">
                    <div class="card-header  p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">My Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Messages</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatables">
                                        <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Image</th>
                                            <th>Event Title</th>
                                            <th>Event Date</th>
                                            <th>Event Type</th>
                                            <th>Event Code</th>
                                            <th>Guest</th>
                                            <th>State</th>
                                            <th>City</th>
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
                                            <th>Event Code</th>
                                            <th>Guest</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Actions</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                        $sql1 = $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as e 
                                    INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
                                    INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
                                    ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id
                                    WHERE e.user_id='$user_id' ORDER BY e.id DESC");
                                        while ($rs = $sql1->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <tr>
                                                <td><?= $sn++ ?></td>
                                                <td><a href="<?= img_url($rs['image']) ?>"><img src="<?= img_url($rs['image']) ?>" class="img-thumbnail img-size-50 img-circle" alt=""></a></td>
                                                <td><?= $rs['event_title'] ?></td>
                                                <td><?= $rs['event_date'] ?></td>
                                                <td><?= ucwords($rs['event_type_name']) ?></td>
                                                <td><?= $rs['code']  ?></td>
                                                <td><?= $rs['guest'] ?></td>
                                                <td><?= ucwords($rs['state']) ?></td>
                                                <td><?= ucwords($rs['city']) ?></td>
                                                <td><a href="<?= VIEW_EVENT.$rs['id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php require_once 'libs/foot.php';?>

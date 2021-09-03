<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/8/2020
 * Time: 1:09 PM
 */

$page_title = "Event Details";
require_once '../core/core.php';
if (isset($_GET['id'])){
    $event_id = $_GET['id'];
    if (empty($event_id)){
        redirect(base_url('admin/404'));
        return;
    }

    $sql = $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as e 
        INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
        INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
        ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id
        WHERE e.id ='$event_id' ORDER BY e.id DESC");
    $num_row = $sql->rowCount();

    if ($num_row == 0){
        redirect(base_url('admin/404'));
        return;
    }

    $rs = $sql->fetch(PDO::FETCH_ASSOC);

    //$page_title.= ucwords($rs['event_title']);

}else{
    redirect(base_url('admin/404'));
}
require_once 'libs/head.php';
?>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invite guest</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Email address</label>
                        <input type="email" name="email" class="form-control" required placeholder="Email Address" id="">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-info" value="Submit" id="">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-sm-12">
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
                        
                        <img src="qrcode.php?code=<?=$rs['code']?>">

                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-8 col-sm-12">
                <!-- DIRECT CHAT -->
                <div class="card  card-tabs">
                    <div class="card-header  p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Invited Guests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Event Professional</a>
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

                                <a href="" class="btn btn-info" data-toggle="modal" data-target="#modal-default" style="margin-bottom: 20px;"><i class="fa fa-plus"></i> Invite Guest</a>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatables">
                                        <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Seat Number</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                        <tr>
                                            <th>Sn</th>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Seat Number</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                        </tfoot>
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

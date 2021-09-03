<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/8/2020
 * Time: 12:39 PM
 */

$page_title = "Upcoming Events";
require_once '../core/core.php';
require_permission('manage_ongoing_event');
require_once 'libs/head.php';
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
                <table class="table table-bordered" id="datatables">
                    <thead>
                    <tr>
                        <th>Sn</th>
                        <th>IV-Image</th>
                        <th>Organized By</th>
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
                        <th>IV-Image</th>
                        <th>Organized By</th>
                        <th>Event Title</th>
                        <th>Event Date &amp; Time</th>
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
                    $sql = $db->query("SELECT e.*, u.fname, c.name as city, s.name as state, e_t.name as event_type_name FROM ".DB_PREFIX."manage_event as e 
                    INNER JOIN ".DB_PREFIX."event_type as e_t INNER JOIN ".DB_PREFIX."city as c 
                    INNER JOIN ".DB_PREFIX."state as s INNER JOIN ".DB_PREFIX."users as u
                    ON e.event_type = e_t.id and e.state_id = s.id and e.city_id = c.id and e.user_id = u.id
                    WHERE e.event_date >='$current_date' ORDER BY e.id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><a href="<?= img_url($rs['image']) ?>"><img src="<?= img_url($rs['image']) ?>" class="img-thumbnail img-size img-circle" alt=""></a></td>
                            <td><?= $rs['fname'] ?></td>
                            <td><?= $rs['event_title'] ?></td>
                            <td><?= $rs['event_date']." ".$rs['event_time'] ?></td>
                            <td><?= ucwords($rs['event_type_name']) ?></td>
                            <td><?= $rs['code']  ?></td>
                            <td><?= $rs['guest'] ?></td>
                            <td><?= ucwords( $rs['state']) ?></td>
                            <td><?= ucwords($rs['city']) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= VIEW_EVENT.$rs['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                    <a href="" class="btn btn-danger btn-sm">Cancel</a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>



<?php require_once 'libs/foot.php';?>

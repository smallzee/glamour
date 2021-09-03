<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 6:56 PM
 */

$page_title = "Event Venue";
require_once '../core/core.php';
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
                        <th>SN</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Venue Type</th>
                        <th>Guests</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Area</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Venue Type</th>
                        <th>Guests</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Area</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sql = $db->query("SELECT v.*, s.name as state_name, c.name as city_name, vt.name as 
                      venue_type_name, a.name as area FROM ".DB_PREFIX."venue as v INNER JOIN ".DB_PREFIX."state 
                      as s INNER JOIN ".DB_PREFIX."city as c INNER JOIN ".DB_PREFIX."venue_type as vt
                      ON v.state_id = s.id and v.city_id = c.id and v.venue_type = vt.id
                      LEFT JOIN ".DB_PREFIX."area as a ON v.area_id = a.id
                      ORDER BY v.id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $sn++  ?></td>
                            <td><a href="<?= img_url($rs['image']) ?>"><img src="<?= img_url($rs['image']) ?>" class="img-thumbnail img-circle" style="width: 50px; height: 50px;"></a></td>
                            <td><?= $rs['title']  ?></td>
                            <td><?= ucwords($rs['venue_type_name'])  ?></td>
                            <td><?= $rs['guest']  ?></td>
                            <td><?= ucwords($rs['state_name'])  ?></td>
                            <td><?= ucwords($rs['city_name'])  ?></td>
                            <td><?= $rs['area'] ?></td>
                            <td><?= amount_format($rs['price']);  ?></td>
                            <td><?= $rs['created_at']  ?></td>
                            <td><a href="" class="btn btn-primary btn-sm">View</a></td>
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
</section>
<!-- /.content -->

<?php require_once 'libs/foot.php'?>

<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 10:03 AM
 */
$page_title = "Event Booking";
require_once 'core/core.php';

if (isset($_POST['plan'])){
    $data = $_POST;
    $data['user_id'] = user_details('id');
    $data['email'] = user_details('email');
    @$vendor = $data['vendor_id'];

    if (!isset($vendor)){
        $error[] = "Vendor is required";
    }

    $event_date = $data['event_date'];

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."booking WHERE event_date='$event_date'");
    if ($sql->rowCount() >= 1){
        $error[] = "Someone have already booked that date";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $vendor_amount = 0;

        for ($i =0; $i < count($vendor); $i++){
            $vendor_id = $vendor[$i];
            $vendor_amount+=vendor_details($vendor_id,'price');
        }

        $data['event_type_id'] = $data['event_type'];
        $data['amount'] = $vendor_amount;
        redirect_paystack($data);

    }else{
        $msg = ($error_count == 1) ? 'An error occurred': 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }

}

require_once 'assets/head.php';
?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <?php flash() ?>

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $page_title ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">

                    <form action="" method="post">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Select</th>
                                    <th>Professional</th>
                                    <th>Capacity</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Select</th>
                                    <th>Professional</th>
                                    <th>Capacity</th>
                                    <th>Price</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $sn =1;
                                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."vendor ORDER BY id DESC");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <tr>
                                            <td><?= $sn++ ?></td>
                                            <td><input type="checkbox" value="<?= $rs['id'] ?>" name="vendor_id[]" id=""></td>
                                            <td><?= ucwords($rs['profession']) ?></td>
                                            <td><?= $rs['capacity'] ?></td>
                                            <td><?= amount_format($rs['price']) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Event Type</label>
                                    <select name="event_type" required id="" class="form-control">
                                        <option value="" disabled selected>Select</option>
                                        <?php
                                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type");
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
                                    <input type="date" min="<?= date('Y-m-d') ?>" class="form-control" name="event_date" required placeholder="Event Date" id="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Event Location</label>
                            <input type="text" name="location" class="form-control" required placeholder="Event Location" id="">
                        </div>

                        <div class="form-group">
                            <label for="">How Do You Want <?= WEB_TITLE ?> To Plan Your Event</label>
                            <textarea name="description" id=""  required class="form-control" placeholder="How Do You Want <?= WEB_TITLE ?> To Plan Your Event" style="resize: none"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="plan" class="btn btn-primary" value="Proceed On Event Booking" id="">
                        </div>
                    </form>

                    <div class="text-center">
                        <img src="<?= image_url('remitaLogo.jpg') ?>" alt="">
                    </div>

                </div>
            </div>


        </div>
    </div>
</section>


<?php require_once 'assets/foot.php'?>



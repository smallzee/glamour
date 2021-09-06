<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 6:56 PM
 */

$page_title = "Dashboard";
require_once '../core/core.php';
require_once 'libs/head.php';
?>

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <?= flash(); ?>
        </div>

        <div class="col-sm-12">
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

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">Total Registered Client</div>
                                <div class="panel-body">
                                    <h1 align="center">
                                        <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role='1'");
                                        $total = $sql->rowCount();
                                        echo $total;
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">Total Glamour Admin</div>
                                <div class="panel-body">
                                    <h1 align="center">
                                        <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE role>1");
                                        $total = $sql->rowCount();
                                        echo $total;
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">Total Glamour Vendors</div>
                                <div class="panel-body">
                                    <h1 align="center">
                                        <?php
                                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."vendor ");
                                        $total = $sql->rowCount();
                                        echo $total;
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">Total Event Category</div>
                                <div class="panel-body">

                                    <h1 align="center">
                                        <?php
                                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."event_type");
                                            echo $sql->rowCount();
                                        ?>
                                    </h1>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once 'libs/foot.php'?>

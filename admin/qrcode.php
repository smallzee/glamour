<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 7/8/2020
 * Time: 3:33 PM
 */
//require_once '../core/core.php';
require_once '../phpqrcode/qrlib.php';
$code = $_GET['code'];
QRcode::png($code);
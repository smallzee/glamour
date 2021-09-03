<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/23/2020
 * Time: 12:53 PM
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Content-Type:application/json");
define("API_ENV", "online");
require_once 'core.php';

if (API_ENV == "onlin"){

    if(isset($_POST)){
        $param = @$_POST;
    }
    return;
}

if (isset($_GET)){
    $param = @$_GET;
}

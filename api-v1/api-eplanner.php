<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/23/2020
 * Time: 3:00 PM
 */

require_once '../core/header.php';

@$phone = $param['phone'];
@$event_code = $param['event_code'];

if (@$param['action'] != "eplanner-login"){
    api_error_status();
    return;
}

if (empty($phone) or empty($event_code)) {
	api_error_status();
	return;
}












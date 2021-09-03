<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 7:05 PM
 */

require_once '../core/core.php';
unset($_SESSION['logged']);
unset($_SESSION[ADMIN_SESSION_HOLDER]);
set_flash("You have successfully logged out","info");
redirect(base_url("admin"));
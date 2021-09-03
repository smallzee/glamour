<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 6/24/2020
 * Time: 6:47 PM
 */

require_once 'core/core.php';
unset($_SESSION['loggedin']);
unset($_SESSION[USER_SESSION_HOLDER]);
set_flash("You have successfully logged out","info");
redirect('login');
<?php 
	session_start();
	require_once 'func.php';
	//ini_set('', newvalue)
	define('Env', 'online');

    define( 'TIMEBEFORE_NOW','Just now' );
    define( 'TIMEBEFORE_MINUTE','{num} minute ago' );
    define( 'TIMEBEFORE_MINUTES','{num} minutes ago' );
    define( 'TIMEBEFORE_HOUR', '{num} hour ago' );
    define( 'TIMEBEFORE_HOURS', '{num} hours ago' );
    define( 'TIMEBEFORE_YESTERDAY', 'yesterday' );
    define( 'TIMEBEFORE_FORMAT',  '%e %b' );
    define( 'TIMEBEFORE_FORMAT_YEAR', '%e %b, %Y' );

    define( 'TIMEBEFORE_DAYS',    '{num} days ago' );
    define( 'TIMEBEFORE_WEEK',    '{num} week ago' );
    define( 'TIMEBEFORE_WEEKS',   '{num} weeks ago' );
    define( 'TIMEBEFORE_MONTH',   '{num} month ago' );
    define( 'TIMEBEFORE_MONTHS',  '{num} months ago' );

    date_default_timezone_set("Africa/Lagos");

    define("HOME_DIR", "http://projects.io/web/glamour/");
    define("WEB_EMAIL","support@glamourevent.com");
    define("WEB_TITLE","Glamour");
    define("WEB_SUB_TITLE", "GL");
    define("HTML_BASE", HOME_DIR.'template/');
    define("HTML_BASE_TEMPLATE",HTML_BASE."assets/");
    define("HTML_BASE_TEMPLATES", HTML_BASE.'libs/');
    define("DB_PREFIX", "kt_");
    define("IMG_LOCATION",HOME_DIR.'images/');
    define("HTML_BASE_TEMP", HTML_BASE."temp/");

    define("LIVE_POINT", "https://api.paystack.co/transaction/initialize");
    define("PUBLIC_KEY", "pk_test_17bb6dbb22ba8726507755d62b517dd9c29e894f");
    define("SECRET_KEY", "sk_test_16a5ceec1c517ad727ba7c742b71f0466c824205");
    define("LIVE_VERIFY_URL", "https://api.paystack.co/transaction/verify/");

    define("ADORABLE_AVATAR_API","https://api.adorable.io/avatars/");

     // google api client
    define("GOOGLE_CLIENT_ID","756743513962-fbtbmeb2d6eg8vurf0udms5tg5t2mo0o.apps.googleusercontent.com");
    define("GOOGLE_CLIENT_SECRET_KEY","fhvEQ1GE0yj_ThPkDuDjUZlb");
    define("GOOGLE_USER_ACCESS_TOKEN", "access_token");
    // end google api client

    define("USER_SESSION_HOLDER","kt_user");
    define("ADMIN_SESSION_HOLDER","kt_admin");

	if (Env == "onlin") {
		define('DB_HOST', 'localhost');
	    define('DB_TABLE', 'datawcxv_kentalevent');
	    define('DB_USER', 'datawcxv_kentalevent');
	    define('DB_PASSWORD', '!]AZIimC8a3A');

	    define("EVENT_CATEGORY",base_url('event-category/'));
	    define("JOIN_EVENT", base_url('joint-event/'));
	    define("EDIT_ROLE", base_url('admin/edit-role/'));
	    define("VIEW_VENUE", base_url('details/'));
	    define("VIEW_PROFILE", base_url('profile/'));
	    define("VIEW_USER_EVENT", base_url('view-event/'));
	    define("VIEW_USER_VENUE", base_url('view-venue/'));
	    define("INVITE", base_url("invite"));

	    // admin
        define("VIEW_EVENT",base_url('admin/view/'));
        define("EDIT_CITY",base_url('admin/edit-city/'));
        define('EDIT_ADMIN', base_url('admin/edit-admin/'));
        define('EDIT_STATE',base_url('admin/edit-state/'));
	}else{
		define('DB_HOST', 'localhost');
	    define('DB_TABLE', 'fpe_web_glamour');
	    define('DB_USER', 'root');
	    define('DB_PASSWORD', '');

	    define("EVENT_CATEGORY",base_url('event-category.php?slug='));
	    define("EDIT_ROLE", base_url('admin/edit-role.php?id='));
	    define("VIEW_VENUE", base_url('details.php?id='));
	    define("JOIN_EVENT", base_url('join-event.php?code='));
	    define("VIEW_PROFILE", base_url('profile.php?id='));
	    define("VIEW_USER_EVENT", base_url('view-event.php?id='));
	    define("VIEW_USER_VENUE", base_url("view-venue.php?id="));
	    define("INVITE", base_url('invite.php?'));

	    //admin
        define("VIEW_EVENT",base_url('admin/view.php?id='));
        define("EDIT_CITY",base_url('admin/edit-city.php?id='));
	    define('EDIT_ADMIN', base_url('admin/edit-admin.php?id='));
	    define('EDIT_STATE',base_url('admin/edit-state.php?id='));
	}

	try {
	    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_TABLE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}
	
	catch (PDOException $e){
	    die('<br/><center><font size="15">Could not connect with database</font></center>');
	}
 ?>
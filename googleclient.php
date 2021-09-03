<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 8/15/2020
 * Time: 12:08 PM
 */

require_once 'core/core.php';
require_once 'client/google/vendor/autoload.php';

$google_client = new Google_Client();

$google_client_id = $google_client->setClientId(GOOGLE_CLIENT_ID);
$google_client_secret = $google_client->setClientSecret(GOOGLE_CLIENT_SECRET_KEY);
$google_redirect = $google_client->setRedirectUri(base_url("googleclient.php"));

$google_client_email = $google_client->addScope("email");
$google_client_profile = $google_client->addScope("profile");

$gclient_user_data = array();

if (isset($_GET['code'])){
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION[GOOGLE_USER_ACCESS_TOKEN] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);
        $user_data = $google_service->userinfo->get();

        if (!empty($user_data['given_name'])){
            $gclient_user_data['fname'] = $user_data['given_name'];
        }

        if (!empty($user_data['family_name'])){
            $gclient_user_data['last_name'] = $user_data['family_name'];
        }

        if (!empty($user_data['email'])){
            $gclient_user_data['email'] = $user_data['email'];
        }

        $email = strtolower($gclient_user_data['email']);
        $fname = $gclient_user_data['fname']." ".$gclient_user_data['last_name'];

        $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $num_row = $sql->rowCount();

        if ($num_row > 0 or $rs['account_type'] == "Website"){
            set_flash("You have already created an account, please login to continue", "warning");
            redirect(base_url("login"));
            return;
        }

        if (empty($email) or empty($fname)){
            set_flash("Unable to access your credential","warning");
            redirect(base_url("login"));
            return;
        }

        if ($num_row > 0 or $rs['account_type'] == "Google"){
            $_SESSION['loggedin'] = true;
            $_SESSION[USER_SESSION_HOLDER] = $rs;
            redirect(base_url("dashboard"));
            return;
        }

        if ($num_row == 0){
            $verification_code = 0; //substr(rand(1000,9999), 0, 4);
            $referral_code2 = substr(strtoupper(md5(uniqid(rand(), true))), 0, 8);

            $in = $db->query("INSERT INTO ".DB_PREFIX."users (fname,email,account_type)
            VALUES('$fname','$email','Google')");

            $last_user_id = $db->lastInsertId();
            $in2 = $db->query("INERT INTO ".DB_PREFIX."wallet (user_id)VALUES('$last_user_id')");

            $subject = "Account Details";
            $msg_body = "<p>Dear, ".ucwords($fname)."</p>";
            $msg_body.= "<p> Your account details are stated below! </p>";

            $msg_body.="<ol>".
                    "<li> Full Name : ".$fname."</li>".
                    "<li> Email Address : ".$email."</li>".
                    "<li> Account status : Active</li>"
                ."</ol>";
            $msg_body.='<p>Thanks for creating account with us </p>';
            $msg_body.= '<p style="text-align:right;">Best Regards <br> '.WEB_TITLE.' - Team </p>';

            set_flash("Account created successfully and your account details has been sent to $email","info");
            send_mail($msg_body,$subject,$email);

            $sql2 = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE id ='$last_user_id'");
            $rs2 = $sql2->fetch(PDO::FETCH_ASSOC);

            $_SESSION['loggedin'] = true;
            $_SESSION[USER_SESSION_HOLDER] = $rs2;
            unset($_SESSION[GOOGLE_USER_ACCESS_TOKEN]);
            redirect(base_url("dashboard"));

        }


    }
}


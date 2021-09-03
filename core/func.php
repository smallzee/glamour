<?php 
    $curl = curl_init();
    $error = $data = array();

    function time_ago($time){
        $out    = ''; // what we will print out
        $now    = time(); // current time
        $diff   = $now - $time; // difference between the current and the provided dates

        if( $diff < 60 ) // it happened now
            return TIMEBEFORE_NOW;

        elseif( $diff < 3600 ) // it happened X minutes ago
            return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? TIMEBEFORE_MINUTE : TIMEBEFORE_MINUTES );

        elseif( $diff < 3600 * 24 ) // it happened X hours ago
            return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? TIMEBEFORE_HOUR : TIMEBEFORE_HOURS );

        elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
            return TIMEBEFORE_YESTERDAY;

        elseif( $diff < 3600 * 24 * 7 )
        return str_replace( '{num}', round( $diff / ( 3600 * 24 ) ), TIMEBEFORE_DAYS );

        elseif( $diff < 3600 * 24 * 7 * 4 )
            return str_replace( '{num}', ( $out = round( $diff / ( 3600 * 24 * 7 ) ) ), $out == 1 ? TIMEBEFORE_WEEK : TIMEBEFORE_WEEKS );

        elseif( $diff < 3600 * 24 * 7 * 4 * 12 )
            return str_replace( '{num}', ( $out = round( $diff / ( 3600 * 24 * 7 * 4 ) ) ), $out == 1 ? TIMEBEFORE_MONTH : TIMEBEFORE_MONTHS );


        else // falling back on a usual date format as it happened later than yesterday
            return strftime( date( 'Y', $time ) == date( 'Y' ) ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time );
    }

     function set_flash ($msg,$type){
       $_SESSION['flash'] = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>'.$msg.'</div>';
    }

    function flash(){
        if (isset($_SESSION['flash'])) {
            echo $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
    }

    function page_title($page_title = ""){
        if($page_title == ""){
            $title = WEB_TITLE;
        }else{
            $title = $page_title." - ".WEB_TITLE;
        }

        return $title;
    }

 	function admin(){
 		if (isset($_SESSION['admin'])) {
 			return true;
 		}else{
 			return false;
 		}
 	}

    function base_url($url_path = ""){
        if ($url_path == ""){
            $base_url = HOME_DIR;
        }else{
            $base_url = HOME_DIR.$url_path;
        }
        return $base_url;
    }

    function image_url($img_name){
        return base_url("images/".$img_name);
    }

 	function admin_detail($value){
 		global $db;
 		$email = $_SESSION[ADMIN_SESSION_HOLDER]['email'];
 		$sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email ='$email'");
 		$rs = $sql->fetch(PDO::FETCH_ASSOC);
 		return $rs[$value];
 	}

     function user_type($id){
        global $db;
        $sql = $db->prepare("SELECT * FROM user_type WHERE id=:id");
        $sql->execute(array(
            'id'=>$id
        ));
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return ucwords($rs['name']);
    }

    function user_info($id,$value){
        global $db;
        $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE id='$id'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return $rs[$value];
    }


    function send_mail($msg_body,$subject,$email){
        $email_tmp =  file_get_contents(base_url('email-template.html'));

        $subject_1 = "<h4>".$subject."</h4>";

        $subject_2 = str_replace("{{TITLE}}", $subject_1, $email_tmp);
        $dates = str_replace("{{DATE}}", date('Y'), $subject_2);
        $message = str_replace("{{MESSAGE}}", $msg_body, $dates);

        $full_name = WEB_TITLE;
        $email_from = WEB_EMAIL;
        //$from = "$full_name<$email_from>";
        $headers ="From:".$full_name."<".$email_from.">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        @$mails = mail($email, $subject, $message,$headers);

        return $mails;
    }

    function send_multiple_email($subject,$to,$message,$cc = FALSE){
        $email_tmp =  file_get_contents(base_url('email-template.html'));
        $message2 = str_replace("{{TITLE}}", $subject, $email_tmp);

        $message = str_replace("{{MESSAGE}}", $message, $message2);
        $message3 = str_replace("{{DATE}}", date('Y'), $message);
        //str_replace(search, replace, subject)

        $full_name = WEB_TITLE;
        $email_from = WEB_EMAIL; //"support@coolbtcminer.com";

        $from = "$full_name <$email_from>";
        $headers = 'From:'.$full_name.'<'.$email_from.'>'."\r\n";
        if($cc != FALSE)
        {
            $headers .= 'BCC: '. implode(",", $cc) . "\r\n";
        }
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $returnpath = "-f" . $email_from;

        @mail($to, $subject, $message3, $headers,$returnpath);
    }

    function event_detail($id,$value){
        global $db;
        $sql = $db->prepare("SELECT * FROM event WHERE id =:id");
        $sql->execute(array('id'=>$id));
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return $rs[$value];
    }

    function user_details($value){
        global $db;
        @$email = $_SESSION[USER_SESSION_HOLDER]['email'];
        $sql = $db->query("SELECT * FROM ".DB_PREFIX."users WHERE email='$email'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return $rs[$value];
    }


    function admin_detail_info($id,$value){
        global $db;
        $sql = $db->prepare("SELECT * FROM admin WHERE id =:id");
        $sql->execute(array('id'=>$id));
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return $rs[$value];
    }

    function redirect($url){
        header("location:$url");
        exit();
    }

    function get_user_permissions($user_id){
        global $db;
        $role_id = admin_detail('role');
        $role = $db->query("SELECT * FROM ".DB_PREFIX."role WHERE id='$role_id'");
        while ($rs = $role->fetch(PDO::FETCH_ASSOC)){
            return json_decode($rs['meta']);
        }
    }

    function require_permission($permission){
        $permissions = get_user_permissions(admin_detail('id'));
        if (is_array($permissions) && in_array($permission, $permissions)) {
            return true;
        } else {
            set_flash('You do not have permission for that operation.<br/>Please contact the Super Admin!', 'danger');
            redirect(base_url('admin'));
        }
    }


    function img_url($img){
        return IMG_LOCATION.$img;
    }

    function validate_phone_number($phone){
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 11 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return true;
        }
    }

    function api_error_status(){
        $error_status = array('status'=> array('type'=>'error','msg' => 'No valid action specified'));
        echo json_encode($error_status);
        exit();
    }

    function role($id){
        global $db;
        $sql = $db->query("SELECT * FROM ".DB_PREFIX."role WHERE id='$id'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return $rs['name'];
    }

    function user_status($status){
        if ($status == 1){
            return "Active";
        }else{
            return "Inactive";
        }
    }

    function data_post($data){
        return @$_POST[$data];
    }

    function is_user_login(){
        if (isset($_SESSION['loggedin'])){
            return true;
        }else{
            return false;
        }
    }

    function is_admin_login(){
        if (isset($_SESSION['loggedin'])){
            return true;
        }else{
            return false;
        }
    }

    function admin_is_required_to_login(){
        if (!is_admin_login() or admin_detail('status') != 1){
            unset($_SESSION['logged']);
            unset($_SESSION[ADMIN_SESSION_HOLDER]);
            redirect(base_url('admin/login'));
        }
    }

    function user_is_required_to_login(){
        if (!is_user_login()){
            set_flash("Please login to continue","info");
            redirect(base_url('login'));
        }
    }

    function amount_format($amount){
        return " &#8358; ".number_format($amount,2);
    }

    function hash_password($password){
        return sha1($password);
    }

    function watermark($image){
        $imageURL = img_url($image);
        $path = pathinfo($imageURL, PATHINFO_EXTENSION);
        
        if ($path == "jpg") {
            $targetLayer = imagecreatefromjpeg($imageURL);
        }else{
            $targetLayer = imagecreatefrompng($imageURL);   
        }
        
        $imagetobewatermark= $targetLayer;
        $font="../fonts/BerkshireSwash-Regular.ttf";
        $fontsize="50";
        
        $watermarktext= WEB_TITLE; // text to be printed on image
        $white = imagecolorallocate($imagetobewatermark, 255, 255, 255);

        imagettftext($imagetobewatermark, $fontsize, 0, 350, 300, $white, $font, $watermarktext);
        header("Content-type:image/jpg");
        
        imagepng($imagetobewatermark);
        imagedestroy($imagetobewatermark);
    
    }

    function limit_title($title){
        if(strlen($title) > 20){
            $data2 = substr($title, 0,20)." ".str_repeat(".", "3");
        }else{
            $data2 = $title;
        }
        return $data2;
    }

    function alert($msg,$type){
        $msgs = '<div class="alert alert-'.$type.'">'.$msg.'</div>';
        echo $msgs;
    }

    function get_upcoming_events($a = FALSE){
        global $db,$user_id,$current_date;

        $sql = $db->query("SELECT j.*,e.id as event_id,e.event_title,e.event_date,c.name as city, s.name as state, e_t.name as event_type_name,
        e.event_date, e.image, e.description, a.name as area, u.fname 
        FROM ".DB_PREFIX."join_event as j
        INNER JOIN ".DB_PREFIX."manage_event as e INNER JOIN ".DB_PREFIX."city as c 
        INNER JOIN ".DB_PREFIX."state as s
        INNER JOIN ".DB_PREFIX."event_type as e_t 
        INNER JOIN ".DB_PREFIX."users as u
        INNEr JOIN ".DB_PREFIX."area as a
        ON j.event_id = e.id and e.city_id and e.state_id = s.id = c.id 
        and e.event_type = e_t.id and e.user_id = u.id  and e.area_id = a.id
        WHERE j.user_id='$user_id' and e.event_date >='$current_date'");

        if ($a == FALSE) {
            return $sql->rowCount();
        }else{
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $rs;
            }
            return $data;
        }

    }

    function get_past_events($a = FALSE){
        global $db,$user_id,$current_date;

        $sql = $db->query("SELECT j.*,e.id as event_id,e.event_title,e.event_date,c.name as city, s.name as state, e_t.name as event_type_name,
            e.event_date, e.image, e.description,a.name as area, u.fname 
            FROM ".DB_PREFIX."join_event as j 
            INNER JOIN ".DB_PREFIX."manage_event as e 
            INNER JOIN ".DB_PREFIX."city as c 
            INNER JOIN ".DB_PREFIX."state as s 
            INNER JOIN ".DB_PREFIX."event_type as e_t 
            INNER JOIN ".DB_PREFIX."users as u
            INNER JOIN ".DB_PREFIX."area as a
            ON j.event_id = e.id and e.city_id and e.state_id = s.id = c.id 
            and e.event_type = e_t.id and e.user_id = u.id and e.area_id = a.id
            WHERE j.user_id='$user_id' and e.event_date <'$current_date'");
        
        if ($a == FALSE) {
            return $sql->rowCount();
        }else{
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $rs;
            }
            return $data;
        }
    }

    function adorable_avatar($name){
        return ADORABLE_AVATAR_API.$name;
    }

    function state($id,$value){
        global $db;
        $sql = $db->query("SELECT * FROM ".DB_PREFIX."state WHERE id='$id'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);
        return $rs[$value];
    }

    function verify_paystack_transaction($ref){
    $curl = curl_init();
    $reference = $ref;
    if (!$reference) {
        set_flash('No reference supplied', 'danger');
        return;
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => LIVE_VERIFY_URL . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Bearer " . SECRET_KEY,
            "cache-control: no-cache"
        ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if ($err) {
        // there was an error contacting the Paystack API
        set_flash( 'Curl returned error: ' . $err,'danger');
        return;
    }

    $tranx = json_decode($response);

    if (!$tranx->status) {
        // there was an error from the API
        set_flash('API returned error: ' . $tranx->message,'danger');
        return;
    }

    if ('success' == $tranx->data->status) {
        // transaction was successful...
        // please check other things like whether you already gave value for this ref
        // if the email matches the customer who owns the product etc
        // Give value
        return $tranx->data;
    }
}
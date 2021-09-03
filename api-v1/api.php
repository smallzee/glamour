<?php 

    require_once '../core/header.php';
    api_error_status();
    exit();


    $data = array();
    $error = $data;

    if (isset($_POST['login'])) {
    	$username = strtolower($_POST['username']);
    	$password = sha1($_POST['password']);

    	$sql = $db->prepare("SELECT * FROM users WHERE email=:email and password=:password");
    	$sql->execute(array(
    		'email'=>$username,
    		'password'=>$password
    	));

    	$num_row = $sql->rowCount();

    	$rs = $sql->fetch(PDO::FETCH_ASSOC);

    	if ($num_row == 0) {
    		$data['error'] = 0;
    		$data['msg'] = "Invalid login details, try again";
    	}elseif ($rs['pin'] != 1) {
            $data['error'] = 0;
            $data['msg'] = "Access denied, try again";
        }else{
             $data['error'] = 1;
             if ($rs['image'] != "") {
                $img = "uploads/users/".$rs['image'];
             }else{
                $img = "";
             }

             $data['info'] = array('id'=>$rs['id'],'img'=>$img,'fname'=>ucwords($rs['fname']),'email'=>$rs['email'],'phone'=>$rs['phone']);
        }

    	echo json_encode($data);
    	exit();
    }



    if (isset($_POST['login-event-planner'])) {
        $event_code = $_POST['event-code'];
        $password = $_POST['password'];

        $sql = $db->prepare("SELECT * FROM event WHERE qr_code =:qr_code");
        $sql->execute(array(
            'qr_code'=>$event_code
        ));

        $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] =0;
            $data['msg'] = "Invalid event code entered, try again";
        }else{
            $rs = $sql->fetch(PDO::FETCH_ASSOC);
            
            $sql1 = $db->prepare("SELECT * FROM event_planner WHERE event_id =:event_id and phone =:phone");
            $sql1->execute(array(
                'event_id'=>$rs['id'],
                'phone'=>$password
            ));

            $num_row1 = $sql1->rowCount();

            if ($num_row1 == 0) {
                $data['error'] =0;
                $data['msg'] = "Invalid login details, try again";
            }else{
                $data['error'] = 1;
                $rs1 = $sql1->fetch(PDO::FETCH_ASSOC);
                $data['info'] = array('id'=>$rs1['id'],'event_code'=>$rs['qr_code'],'fname'=>ucwords($rs1['fname']),'category'=>$rs1['category'],
                    'phone'=>$rs1['phone'],'event_id'=>$rs['id']);
            }
        }

        echo json_encode($data);
        exit();
    }
 	
 	if (isset($_POST['create-account'])) {
 		//$username = strtolower($_POST['username']);
 		$password = sha1($_POST['password']);
 		$fname = $_POST['fname'];
 		$email = strtolower($_POST['email']);
 		$phone = $_POST['phone'];

 		$sql = $db->prepare("SELECT * FROM users WHERE  phone=:phone and email =:email");
 		$sql->execute(array('phone'=>$phone,'email'=>$email));
 		$num_row = $sql->rowCount();

 		if ($num_row >= 1) {
 			$data['error'] =0;
 			$data['msg'] = "username or phone number or email address has already exit, try again";
 		}else{
 			$data['error'] =1;
 			
 			$in = $db->prepare("INSERT INTO users(image,password,fname,email,phone,registered_date,pin)
 				VALUES(:image,:password,:fname,:email,:phone,:registered_date,:pin)");
 			
 			$in->execute(array(
                'image'=>'',
 				'password'=>$password,
 				'fname'=>$fname,
 				'email'=>$email,
 				'phone'=>$phone,
 				'registered_date'=>time(),
                'pin'=>1
 			));

        $subject = "Account Creation";
        $msg_body = "<p>Dear ".ucwords($fname)."</p>";
        $msg_body.= "<p> Your account details are stated below! </p>";

        $msg_body.="<ol>".
                "<li> Full Name : ".$fname."</li>".
                "<li> Email Address : ".$email."</li>".
                "<li> Phone Number : ".$phone."</li>".
                "<li> Account status : Approved</li>"
            ."</ol>";
        $msg_body.='<p>Thanks for creating account with us </p>'; 
        $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';

        send_mail($msg_body,$subject,$email);

 			$data['msg'] = "Account created successfully, please login";
 		}

 		echo json_encode($data);
 		exit();
 	}

    if (isset($_POST['forget-password'])) {
        $name = strtolower($_POST['name']);
        $sql = $db->prepare("SELECT * FROM users WHERE email=:name");
        $sql->execute(array('name'=>$name));

        $num_row = $sql->rowCount();
        if ($num_row == 0) {
            $data['error'] =0;
            $data['msg'] = "Invalid email address entered, try again";
        }else{
            $rs = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $rs['id'];

            $pin = substr(rand(0000,9999), 0,4);

            $up = $db->prepare("UPDATE users SET pin =:pin WHERE id =:id");
            $up->execute(array(
                'pin'=>$pin,
                'id'=>$user_id
            ));

            $email = $rs['email'];
            $fname = $rs['fname'];

            $subject = "Kental Event - Verification";
            $msg_body= "<p> Dear, $fname </p>";
            $msg_body.="<p>Your Verification code is $pin </p>";
            
            $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';

            send_mail($msg_body,$subject,$email);

            $data['error'] = 1;
            $data['msg'] = "Dear, $fname your verification code has been sent to your email address, please verify";
            $data['info'] = array('id'=>$user_id);
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['re-send'])) {
        $user_id = $_POST['user_id'];

        $sql = $db->prepare("SELECT * FROM users WHERE id=:id");
        $sql->execute(array('id'=>$user_id));

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "Invalid username / email address provided earlier, try again";
        }else{
             $pin = substr(rand(0000,9999), 0,5);

            $up = $db->prepare("UPDATE users SET pin =:pin WHERE id =:id");
            $up->execute(array(
                'pin'=>$pin,
                'id'=>$user_id
            ));

            $email = $rs['email'];
            $fname = $rs['fname'];

            $subject = "Kental Event - Verification";
            $msg_body= "<p> Dear, $fname </p>";
            $msg_body.="<p>Your Verification code is $pin </p>";
            
            $msg_body.= '<p style="text-align:right;">Best Regards <br> Kental Event - Admin </p>';

            send_mail($msg_body,$subject,$email);

            $data['error'] = 1;
            $data['msg'] = "Dear, $fname your verification code has been sent to your email address, please verify";
            $data['info'] = array('id'=>$user_id);
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['verify'])) {
        $code = $_POST['code'];
        $user_id = $_POST['user_id'];

       $sql = $db->prepare("SELECT * FROM users WHERE id=:id and pin =:pin");
       $sql->execute(array(
        'id'=>$user_id,
        'pin'=>$code
       ));

       $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "Invalid verification code entered, try again";
        }else{
            $up = $db->prepare("UPDATE users SET pin =:pin WHERE id=:id");
            $up->execute(array(
                'pin'=>0,
                'id'=>$user_id
            ));

            $data['error'] = 1;
            $data['msg'] = "Your verification has been successfully, you can change your password";
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['change-password'])) {
        $npassword = sha1($_POST['npassword']);
        $user_id = $_POST['user_id'];

        $up = $db->prepare("UPDATE users SET password =:password, pin =:pin WHERE id =:id");
        $up->execute(array(
            'password'=>$npassword,
            'pin'=>1,
            'id'=>$user_id,
        ));

        if ($up == TRUE) {
            $data['error'] = 1;
            $data['msg'] = "Password has been changed successfully, please login";
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['create-event'])) {

        $upload_path = 'uploads/invitation';
        $image = $_POST['image'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $add_date = $_POST['add_date'];
        $add_time = $_POST['add_time'];
        $venue = $_POST['venue'];
        $location = $_POST['location'];
        $dress_code = $_POST['dress_code'];
        $user_id = $_POST['user_id'];
        $visitor = $_POST['visitor'];

        $qr_code = substr(rand(), 0,6);

        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $file_name = rand()."_".time().".jpeg";

        $upload_path = $upload_path."/".$file_name;

        if (file_put_contents($upload_path, base64_decode($image))) {
           
           $in = $db->prepare("INSERT INTO event (image,title,category,add_date,add_time,venue,location,dress_code,qr_code,description,user_id,visitor)
            VALUES(:image,:title,:category,:add_date,:add_time,:venue,:location,:dress_code,:qr_code,:description,:user_id,:visitor)");

           $in->execute(array(
                'image'=>$file_name,
                'title'=>$title,
                'category'=>$category,
                'add_date'=>$add_date,
                'add_time'=>$add_time,
                'venue'=>$venue,
                'location'=>$location,
                'dress_code'=>$dress_code,
                'qr_code'=>$qr_code,
                'description'=>$description,
                'user_id'=>$user_id,
                'visitor'=>$visitor
           ));

           $data['error'] = 1;
           $data['msg'] = "Event has been created successfully";
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['upload-profile-image'])) {
        $user_id = $_POST['user-id'];
        $image = $_POST['image'];

        $upload_path = "uploads/users";

        // if (!file_exists($upload_path)) {
        //     mkdir($upload_path, 0777, true);
        // }

        $file_name = rand()."_".time().".jpeg";

        $upload_path = $upload_path."/".$file_name;

        if (file_put_contents($upload_path, base64_decode($image))) {
           
           $up = $db->prepare("UPDATE users SET image =:image WHERE id =:id");
           $up->execute(array(
                'image'=>$file_name,
                'id'=>$user_id
           ));

           $img = "uploads/users/".$file_name;

           $data['error'] = 1;
           $data['info'] = array('image'=>$img);
           $data['msg'] = "Your profile image has been changed successfully";
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['my-event'])) {
        $user_id = $_POST['user_id'];

        $sql = $db->prepare("SELECT * FROM event WHERE user_id =:user_id ORDER BY id DESC");
        $sql->execute(array(
            'user_id'=>$user_id
        ));

        $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "No event created, yet";
        }else{
            $data['error'] = 1;
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                if (strlen($rs['title']) > 30) {
                   $title = substr($rs['title'], 0,30).str_repeat('.', 3);
                }else{
                    $title = $rs['title'];
                }

                if (strlen($rs['description']) > 100) {
                    $desc = substr($rs['description'], 0,100).str_repeat('.',3);
                }else{
                    $desc = $rs['description'];
                }

                $sql1 = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id");
                $sql1->execute(array(
                    'event_id'=>$rs['id']
                ));

                $total = $sql1->rowCount();

                $img = "uploads/invitation/".$rs['image'];

                $data[] = array('id'=>$rs['id'],'title'=>$title,'desc'=>$desc,'category'=>$rs['category'],'total'=>$total,'img'=>$img,'visitor'=>$rs['visitor'],'add_date'=>$rs['add_date'],'add_time'=>$rs['add_time'],'venue'=>$rs['venue'],'location'=>$rs['location'],'dress_code'=>$rs['dress_code'],'full_desc'=>$rs['description'],'qr_code'=>$rs['qr_code']);
            }
        }

        $data['info'] = $user_id;
        echo json_encode($data);
        exit();
    }

    if (isset($_POST['create-event-planner'])) {
        $fname = $_POST['fname'];
        $phone = $_POST['phone'];
        $category = $_POST['category'];
        $event_id = $_POST['event-id'];

        $sql = $db->prepare("SELECT * FROM event_planner WHERE event_id=:event_id and phone =:phone");
        $sql->execute(array(
            'event_id'=>$event_id,
            'phone'=>$phone
        ));

        $num_row = $sql->rowCount();

        if ($num_row >= 1) {
            $data['error'] =0;
            $data['msg'] = "Wrong phone number, it has already registered for this particular event";
        }else{
            $data['error'] = 1;
            $in = $db->prepare("INSERT INTO event_planner (event_id,fname,phone,category)VALUES(:event_id,:fname,:phone,:category)");
            $in->execute(array(
                'event_id'=>$event_id,
                'fname'=>$fname,
                'phone'=>$phone,
                'category'=>$category
            ));
            $data['msg'] = "$fname has been successfully registered to manage $category";
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['all-event-planner'])) {
        $event_id = $_POST['event-id'];

        $sql = $db->prepare("SELECT * FROM event_planner WHERE event_id =:event_id");
        $sql->execute(array(
            'event_id'=>$event_id
        ));

        $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "No event planner has been registered yet";
        }else{
            $data['error'] = 1;
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)) {
                $img = "uploads/users/user.jpg";
                $data[] = array('id'=>$rs['id'],'event-code'=>event_detail($rs['event_id'],'qr_code'),'fname'=>ucwords($rs['fname']),'phone'=>$rs['phone'],'category'=>$rs['category'],'img'=>$img);
            }
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['visited-event'])) {
        $user_id = $_POST['user_id'];

        $current_date = date('m/d/Y');

        $sql = $db->query("SELECT v.*, e.*, e.id as e_id, v.id as v_id FROM visited_event as v INNER JOIN event as e ON v.event_id = e.id WHERE v.user_id='$user_id' and e.add_date >='$current_date'");


        $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] =0;
            $data['msg'] = "No availiable ongoing event";
        }else{
            $data['error'] = 1;
             while ($rs1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                $img = "uploads/invitation/".$rs1['image'];
                $data[] = array('id'=>$rs1['e_id'],'title'=>$rs1['title'],'location'=>$rs1['location'],
                        'add_date'=>$rs1['add_date'],'add_time'=>$rs1['add_time'],
                        'img'=>$img,'category'=>$rs1['category'],'event_id'=>$rs1['e_id'],'seat'=>$rs1['seat']);
            }
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['event-visitor'])) {
        $event_id = $_POST['event-id'];

        $sql = $db->query("SELECT v.*, u.*, u.id as u_id FROM visited_event as v INNER JOIN users as u ON v.user_id = u.id WHERE v.event_id='$event_id'");

        $num_row = $sql->rowCount();

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "No visitors availiable yet";
        }else{
            $data['error'] = 1;

            while ($rs1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                $seat = $rs1['seat'];    
                $img = "uploads/users/".$rs1['image'];
                $data[] = array('id'=>$rs1['id'],'fname'=>ucwords($rs1['fname']),'phone'=>$rs1['phone'],'image'=>$img,
                    'email'=>$rs1['email'],'seat'=>$seat,'attendance'=>$rs1['attendance']);
            }
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['event-reg'])) {
        $event_code = $_POST['event-code'];
        $user_id = $_POST['user-id'];

        $sql = $db->prepare("SELECT * FROM event WHERE qr_code =:qr_code");
        $sql->execute(array(
            'qr_code'=>$event_code
        ));

        $num_row = $sql->rowCount();
        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $current_date = strtotime(date('m/d/Y'));
        $visitor = $rs['visitor'];

        $date = $rs['add_date'];

        $sql1 = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id and user_id =:user_id");
        $sql1->execute(array(
            'event_id'=>$rs['id'],
            'user_id'=>$user_id
        ));

        $sql2 = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id");
        $sql2->execute(array(
            'event_id'=>$rs['id']
        ));

        $num_row2 = $sql2->rowCount();
       
        $num_row1 = $sql1->rowCount();

        $sql3 = $db->prepare("SELECT * FROM users WHERE id =:id");
        $sql3->execute(array(
            'id'=>$user_id
        ));

        $rs3 = $sql3->fetch(PDO::FETCH_ASSOC);

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "Invalid event code entered, try again";
        }elseif ($rs['user_id'] == $user_id) {
            $data['error'] = 0;
            $data['msg'] = "Ops sorry,";
        }elseif ($rs['add_date'] > $current_date) {
           $data['error'] = 0;
           $data['msg'] = "Event has already been closed";
        }elseif ($num_row1 >= 1) {
           $data['error'] = 0;
           $data['msg'] = "You have already booked for the event";
        }elseif ($visitor == $num_row2) {
            $data['error'] =0;
            $data['msg'] = "Event has already been occupied";
        }elseif ($rs3['image'] == "") {
            $data['error'] =0;
            $data['msg'] = "Please upload your profile image, before you can be invited to the event";
        }else{
            $data['error'] = 1;
            $img = "uploads/invitation/".$rs['image'];
            $data['info'] = array('id'=>$rs['id'],'img'=>$img,'add_date'=>$rs['add_date'],'add_time'=>$rs['add_time'],'location'=>$rs['location']);
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['event-access-by-code'])) {
        $user_id = $_POST['user-id'];
        $event_id = $_POST['event-id'];

        $sql = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id and user_id =:user_id");
        $sql->execute(array(
            'event_id'=>$event_id,
            'user_id'=>$user_id
        ));

        $num_row = $sql->rowCount();

        $sql1 = $db->prepare("SELECT * FROM event WHERE id =:id");
        $sql1->execute(array(
            'id'=>$event_id
        ));

        $sql2 = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id");
        $sql2->execute(array(
            'event_id'=>$event_id
        ));

        $num_row2 = $sql2->rowCount();

        $num_row1 = $sql1->rowCount();
        $rs1 = $sql1->fetch(PDO::FETCH_ASSOC);

        $visitor = $rs1['visitor'];

        if ($num_row >= 1) {
            $data['error'] = 0;
            $data['msg'] = "You have already booked for the event";
        }elseif ($visitor == $num_row) {
            $data['error'] = 0;
            $data['msg'] = "Event has already been occupied, not availiable space seat";
        }else{

            $data['error'] = 1;
            
            if ($num_row2 == 0) {
               $seat = 1;
            }else{
                $seat = $num_row2 + 1;
            }

            $in = $db->prepare("INSERT INTO visited_event (user_id,event_id,seat,access_by,add_date,attendance)VALUES(:user_id,:event_id,:seat,:access_by,:add_date,:attendance)");
            $in->execute(array(
                'user_id'=>$user_id,
                'event_id'=>$event_id,
                'seat'=>$seat,
                'access_by'=>'By code',
                'add_date'=>date('d/f/Y'),
                'attendance'=>'Not attended'
            ));

            $data['msg'] = "Wow, You are going!!";
            $location = $rs1['location']. " on ".$rs1['add_date']. " ".$rs1['add_time'];
            $data['info'] = array('seat'=>$seat,'location'=>$location);
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['in-app-change-password'])) {
       $password = sha1($_POST['password']);
       $npassword = sha1($_POST['npassword']);
       $user_id = $_POST['user-id'];

       $sql = $db->prepare("SELECT * FROM users WHERE id =:id");
       $sql->execute(array(
            'id'=>$user_id
       ));

       $rs = $sql->fetch(PDO::FETCH_ASSOC);

       $p_pass = $rs['password'];

       if ($p_pass != $password) {
           $data['error'] = 0;
           $data['msg'] = "Invalid previous password, try again";
       }else{

            $data['error'] = 1;
            
            $up = $db->prepare("UPDATE users SET password =:password WHERE id =:id");
            $up->execute(array(
                'password'=>$npassword,
                'id'=>$user_id
            ));

            $data['msg'] = "Your password has been changed successfully";
       }
       
       echo json_encode($data);
       exit();
    }

    if(isset($_POST['add-ordering'])){
        $image = $_POST['image'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $desc = $_POST['desc'];
        $schedule = $_POST['schedule'];
        $to_time = $_POST['to_time'];
        $from_time = $_POST['from_time'];
        $event_id = $_POST['event-id'];

        $upload_path = 'uploads/food';

        $file_name = rand()."_".time().".jpeg";

        $upload_path = $upload_path."/".$file_name;

        if (file_put_contents($upload_path, base64_decode($image))){
            $in = $db->prepare("INSERT INTO food (event_id,title,type,description,to_time,from_time,image,schedule)
            VALUES (:event_id,:title,:type,:description,:to_time,:from_time,:image,:schedule)");

            $in->execute(array(
                'event_id'=>$event_id,
                'title'=>$title,
                'type'=>$type,
                'description'=>$desc,
                'to_time'=>$to_time,
                'from_time'=>$from_time,
                'image'=>$file_name,
                'schedule'=>$schedule
            ));
            $data['error'] = 1;
            $data['msg'] = "Request has been posted successfully";
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['available-ordering'])){

        $event_id = $_POST['event-id'];

        $sql = $db->prepare("SELECT * FROM food WHERE event_id=:event_id ORDER BY id DESC");
        $sql->execute(array(
            'event_id'=>$event_id
        ));

        $num_row = $sql->rowCount();

        if ($num_row == 0){
            $data['error'] = 0;
            $data['msg'] = "No available ordering, try again";
        }else{
            $data['error'] = 1;
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                $img = "uploads/food/".$rs['image'];
                $data[] = array('id'=>$rs['id'],'title'=>$rs['title'],'desc'=>$rs['description'],'schedule'=>$rs['schedule'],
                    'to_time'=>$rs['to_time'],'from_time'=>$rs['from_time'],'type'=>$rs['type'],'image'=>$img);
            }
        }

        echo json_encode($data);
        exit();
    }

    if(isset($_POST['available-food'])){
        $event_id = $_POST['event-id'];

        $sql = $db->prepare("SELECT * FROM food WHERE event_id=:event_id");
        $sql->execute(array(
            'event_id'=>$event_id
        ));

        $num_row = $sql->rowCount();

        $cu_time = date('H : A');

        if ($num_row == 0){
            $data['error'] = 0;
            $data['msg'] = "No available food, try again";
        }else{
            $data['error'] =1;
            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                if ($rs['status'] == "Approved"){
                    $img = "uploads/food/".$rs['image'];
                    $data[] = array('id'=>$rs['id'],'title'=>$rs['title'],'desc'=>$rs['description'],'schedule'=>$rs['schedule'],
                        'to_time'=>$rs['to_time'],'from_time'=>$rs['from_time'],'type'=>$rs['type'],'image'=>$img);
                }
            }
        }

        echo json_encode($data);
        exit();
    }

    if(isset($_GET['visitor-notification'])){
        $user_id = $_GET['user-id'];

        $current_date = date('m/d/Y');

        $sql = $db->query("SELECT v.*, e.*, e.id as e_id, v.id as v_id FROM visited_event as v INNER JOIN event as e ON v.event_id = e.id WHERE v.user_id='$user_id' and e.add_date >='$current_date'");

        $num_row = $sql->rowCount();

        if ($num_row == 0) {
           $data['error'] =0;
           $data['msg']  = "No available ongoing event notification yet";
        }else{
            $data['error'] = 1;
            while ($rs1 = $sql->fetch(PDO::FETCH_ASSOC)) {
                $img = "uploads/invitation/".$rs1['image'];
                $data[] = array('id'=>$rs1['e_id'],'title'=>$rs1['title'],'type'=>$rs1['category'],
                'event_owner'=>ucwords(user_details($rs1['user_id'],'fname')),'img'=>$img,'add_date'=>$rs1['add_date'],
                'add_time'=>$rs1['add_time'],'location'=>$rs1['location']);
            }
        }

        echo json_encode($data);
        exit();
    }

    if(isset($_POST['update-user-profile'])){
        $fname = $_POST['fname'];
        $email = strtolower($_POST['email']);
        $phone = $_POST['phone'];
        $user_id = $_POST['user-id'];

        $sql = $db->prepare("SELECT * FROM users WHERE email=:email");
        $sql->execute(array(
            'email'=>$email
        ));

        $num_row = $sql->rowCount();

        if ($num_row >= 1){
            $data['error'] = 0;
            $data['msg'] = "Invalid email address, it has already exist, try again";
        }else{

            $up = $db->prepare("UPDATE users SET fname=:fname, email=:email, phone=:phone WHERE  id=:id");
            $up->execute(array(
                'fname'=>$fname,
                'email'=>$email,
                'phone'=>$phone,
                'user_id'=>$user_id
            ));

            $data['error'] = 1;
            $data['msg'] = "Your profile has been updated successfully";
            $data['info'] = array('fname'=>$fname,'email'=>$email,'phone'=>$phone);

        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['verify-qr-code'])){
        $event_code = $_POST['vin'];
        $user_id = $_POST['user-id'];

        $sql = $db->prepare("SELECT * FROM event WHERE qr_code =:qr_code");
        $sql->execute(array(
            'qr_code'=>$event_code
        ));

        $num_row = $sql->rowCount();
        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $current_date = date('d/m/Y');
        $visitor = $rs['visitor'];

        $date = $rs['add_date'];

        $sql1 = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id and user_id =:user_id");
        $sql1->execute(array(
            'event_id'=>$rs['id'],
            'user_id'=>$user_id
        ));

        $sql2 = $db->prepare("SELECT * FROM visited_event WHERE event_id =:event_id");
        $sql2->execute(array(
            'event_id'=>$rs['id']
        ));

        $num_row2 = $sql2->rowCount();

        $num_row1 = $sql1->rowCount();

        $sql3 = $db->prepare("SELECT * FROM users WHERE id =:id");
        $sql3->execute(array(
            'id'=>$user_id
        ));

        $rs3 = $sql3->fetch(PDO::FETCH_ASSOC);

        if ($num_row == 0) {
            $data['error'] = 0;
            $data['msg'] = "Invalid event code entered, try again";
        }elseif ($rs['user_id'] == $user_id) {
            $data['error'] = 0;
            $data['msg'] = "Ops sorry,";
        }elseif ($rs['add_date'] > $current_date) {
            $data['error'] = 0;
            $data['msg'] = "Event has already been closed";
        }elseif ($num_row1 >= 1) {
            $data['error'] = 0;
            $data['msg'] = "You have already booked for the event";
        }elseif ($visitor == $num_row2) {
            $data['error'] =0;
            $data['msg'] = "Event has already been occupied";
        }elseif ($rs3['image'] == "") {
            $data['error'] =0;
            $data['msg'] = "Please upload your profile image, before you can be invited to the event";
        }else{
            $data['error'] = 1;
            $img = "uploads/invitation/".$rs['image'];
            $data['info'] = array('id'=>$rs['id'],'img'=>$img,'add_date'=>$rs['add_date'],'add_time'=>$rs['add_time'],'location'=>$rs['location']);
        }

        echo json_encode($data);
        exit();
    }

    if (isset($_POST['food-ordering'])) {
        $food_id = $_POST['food-id'];
        $user_id = $_POST['user-id'];

        $sql = $db->prepare("SELECT * FROM food WHERE id =:id");
        $sql->execute(array(
            'id'=>$food_id
        ));

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $event_id = $rs['event_id'];
        $status = $rs['status'];

        $sql1 = $db->prepare("SELECT * FROM event WHERE id =:id");
        $sql1->execute(array(
            'id'=>$event_id
        ));

        $rs1 = $sql1->fetch(PDO::FETCH_ASSOC);

        $add_date = $rs1['add_date'];
        $current_date = date('d/m/Y');

        $sql2 = $db->prepare("SELECT * FROM orders WHERE user_id =:user_id and food_id=:food_id");
        $sql2->execute(array(
            'user_id'=>$user_id,
            'food_id'=>$food_id
        ));

        $num_row = $sql2->rowCount();


        echo json_encode($data);
        exit();
    }

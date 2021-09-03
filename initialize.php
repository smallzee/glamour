<?php 
  require_once 'core/core.php';

  //user_is_required_to_login();

  function redirect_paystack($data){
      global  $curl;

      $amount = $data['amount'];

      $paystack_tran_fee = 1.5;//get_settings("paystack_transaction_fee");
      $cal_charges = $amount / 100;

      $charges = $cal_charges * $paystack_tran_fee;
      $amounts = $amount + $charges;

      $amount_to_pay = ($amounts  * 100) / 100;

      $email = $data['email']; //user_details('email');

      curl_setopt_array($curl, array(
          CURLOPT_URL => LIVE_POINT,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode([
              'amount'=>intval($amount_to_pay * 100),
              'email'=>$email
          ]),
          CURLOPT_HTTPHEADER => [
              "authorization: Bearer ".SECRET_KEY, //replace this with your own test key
              "content-type: application/json",
              "cache-control: no-cache"
          ],
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      if($err){
          // there was an error contacting the Paystack API
          die('Curl returned error: ' . $err);
      }

      $tranx = json_decode($response, true);

      if(!$tranx['status']){
          // there was an error from the API
          print_r('API returned error: ' . $tranx['message']);
          return;
      }

      save_last_transaction_reference($tranx['data']['reference'],$data);

      header('Location: ' . $tranx['data']['authorization_url']);
  }

function save_last_transaction_reference($ref,$data){
    global $db;

    $user_id = $data['user_id'];
    $venue_id = $data['venue_id'];
    $amount = $data['amount'];


    $sql = $db->query("SELECT * FROM ".DB_PREFIX."transactions WHERE
     user_id='$user_id' and status IN ('initialized','failed') and verified='0'");

    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    $num_row = $sql->rowCount();

    $payment_id = $rs['id'];
    $event_date = $data['event-date'];

    switch ($num_row){
        case 1 :
            $up = $db->query("UPDATE ".DB_PREFIX."transactions SET amount='$amount',
             reference='$ref', venue_id='$venue_id' WHERE user_id='$user_id'");


            $up2 = $db->query("UPDATE ".DB_PREFIX."order_venues SET venue_id='$venue_id'
            event_date='$event_date' 
            WHERE payment_id='$payment_id'");

            break;
        case 0 :
            $in = $db->query("INSERT INTO ".DB_PREFIX."transactions 
            (user_id,amount,reference,venue_id)
            VALUES('$user_id','$amount','$ref','$venue_id')");

            $payment_id = $db->lastInsertId();

            $in2 = $db->query("INSERT INTO ".DB_PREFIX."order_venues (venue_id,payment_id,user_id,event_date)
            VALUES('$venue_id','$payment_id','$user_id','$event_date')");

            break;
        default;
    }
}
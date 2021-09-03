<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 9/17/2020
 * Time: 1:16 PM
 */

require_once 'core/core.php';

//dump
//$dump = array();
// Retrieve the request's body
$log = [];
$body = @file_get_contents("php://input");
$signature = (isset($_SERVER['HTTP_X_PAYSTACK_SIGNATURE']) ? $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] : '');

//$dump['body'] = $body;
/* It is a good idea to log all events received. Add code *
 * here to log the signature and body to db or file       */

if (!$signature) {
    //// only a post with paystack signature header gets our attention
    //$dump['no_signature'] = true;
    exit();
}

// confirm the event's signature
if ($signature !== hash_hmac('sha512', $body, SECRET_KEY)) {
    // silently forget this ever happened
    //$dump['signature_not_auth'] = true;
    exit();
}

http_response_code(200);
// parse event (which is json string) as object
// Give value to your customer but don't give any output
// Remember that this is a call from Paystack's servers and
// Your customer is not seeing the response here at all
//$event = json_decode('{"event":"charge.success","data":{"reference":"'.$_GET['ref'].'"}}');
$event = json_decode($body);
//$dump['event'] = $event;

switch ($event->event){
    case 'charge.success' :
        $log[] = "Charge success";
        $ref = $event->data->reference;

        if ($ref){

            $tnx_sql = $db->query("SELECT * FROM ".DB_PREFIX."transactions WHERE reference='$ref'");
            $data = $tnx_sql->fetch(PDO::FETCH_ASSOC);

            if ($data['verified'] == 0 && $data['status'] != 'success') {
                $json_response = $body;

                $verify = verify_paystack_transaction($ref);

                if (is_object($verify) && $verify->status == 'success'){

                    $paid_at = date("Y-m-d H:i:s");
                    $payment_id = $data['id'];

                    $trans = $db->query("UPDATE ".DB_PREFIX."transactions SET status='success', 
                    verified='1', paid_at='$paid_at', json_response='$json_response' WHERE reference='$ref'");

                    $venue = $db->query("UPDATE ".DB_PREFIX."order_venues SET verified='1', created_at='$paid_at' WHERE payment_id='$payment_id'");

                }
            }
        }

   break;
   default;
}
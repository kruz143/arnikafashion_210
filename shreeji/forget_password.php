<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

if (!isset($_REQUEST['email_address']) || $_REQUEST['email_address'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Email Address";
    $response['success'] = true;

    echo json_encode($response);
    exit();
}

$email_id = isset($_REQUEST['email_address']) ? $_REQUEST['email_address'] : "";

/* check dublicate Email */
$check_mobile = get_result("SELECT name FROM user where email_address='{$email_id}'");
if (count($check_mobile) > 0) {
    
    $otp = rand(111111, 999999);
    
    bindupdate("user", array("otp"=>$otp), "email_address='{$email_id}'");
    //send mail
    fg_email(ucfirst($check_mobile[0]['name']),$otp,$email_id);
    
    $data['otp_number'] = $otp;
    
    $response['status_code'] = 200;
    $response['data'] = $data;
    $response['message'] = "Please check Your Inbox we have sent otp in your mail.";
    $response['success'] = true;
    echo json_encode($response);
    exit();
} else {
    $response['status_code'] = 401;
    $response['message'] = "Email Id Not Found In System Please Add Valid Email Id.";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}


echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

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
if (!isset($_REQUEST['password']) || $_REQUEST['password'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Enter Password";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

$email_id = isset($_REQUEST['email_address']) ? $_REQUEST['email_address'] : "";

$check_mobile = get_result("SELECT * FROM user where email_address='{$email_id}'");
if (count($check_mobile) > 0) {
    
        bindupdate("user", array("password" => $_REQUEST['password']), "email_address='{$email_id}'");
        $response['status_code'] = 200;        
        $response['message'] = "Password Updated Successfully";
        $response['success'] = true;
        echo json_encode($response);
    
} else {
    $response['status_code'] = 401;
    $response['message'] = "Email Id Not Found In System Please Add Valid Email Id.";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}


// echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

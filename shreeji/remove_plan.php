<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();


if (!isset($_REQUEST['plan_id']) || $_REQUEST['plan_id'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Select plan";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

$additional_charge = get_result("select * from plan where plan_id='{$_REQUEST['plan_id']}'");

if (count($additional_charge)>0) {

    hard_delete("plan", "plan_id", $_REQUEST['plan_id']);
    
    $response['status_code'] = 200;
    $response['message'] = "Plan Removed Successfully";
    $response['success'] = true;
    $response['data'] = '';
} else {
    $response['status_code'] = 404;
    $response['message'] = "Something went wrong please try again";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

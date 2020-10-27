<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();


if (!isset($_REQUEST['customer_id']) || $_REQUEST['customer_id'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Select Customer";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_REQUEST['charge_id']) || $_REQUEST['charge_id'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Select Charge Record";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

$additional_charge = get_result("select * from additional_charge where id='{$_REQUEST['charge_id']}' and user_id='{$_REQUEST['customer_id']}'");

if (count($additional_charge)>0) {

    hard_delete("additional_charge", "id", $_REQUEST['charge_id']);
    
    $response['status_code'] = 200;
    $response['message'] = "Additional Charged Removed";
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

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
if (!isset($_REQUEST['add_channel_charge']) || $_REQUEST['add_channel_charge'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Add Channel Charge";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_REQUEST['box_id']) || $_REQUEST['box_id'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Add Box";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

$insert = array(
    "user_id" => $_REQUEST['customer_id'],
    "channel_charge" => $_REQUEST['add_channel_charge'],
    "box_id" => $_REQUEST['box_id'],
    "description" => isset($_REQUEST['description']) ? $_REQUEST['description'] : "",
    "insert_date" => date('Y-m-d h:i:sa'),
);

if (insert('additional_charge', $insert)) {

    $response['status_code'] = 200;
    $response['message'] = "Additional Charged Added Successfully";
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

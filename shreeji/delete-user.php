<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

if (!isset($_REQUEST['user_id']) || $_REQUEST['user_id'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Select User";
    $response['success'] = true;

    echo json_encode($response);
    exit();
}
$user_id = $_REQUEST['user_id'];
/* check dublicate mobilenumber */
$check_mobile = get_result("SELECT * FROM user where user_id='{$user_id}'");
if (count($check_mobile)<1) {
    $response['status_code'] = 401;
    $response['message'] = "User Not Found";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

if (hard_delete("user", "user_id", $user_id)) {


    $response['status_code'] = 200;
    $response['message'] = "User Deleted";
    $response['success'] = true;
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

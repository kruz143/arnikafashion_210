<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();


if (!isset($_POST['mobile_number']) || $_POST['mobile_number'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter Mobile Number";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_POST['password']) || $_POST['password'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter Password";
    $response['success'] = true;

    echo json_encode($response);
    exit();
}

$result = get_result("SELECT * FROM user where mobile_number='{$_POST['mobile_number']}' and password='{$_POST['password']}'");
if (count($result) > 0 && $result[0]['mobile_number']==$_POST['mobile_number'] && $result[0]['password']==$_POST['password']) {
     
    $device_token = isset($_POST['token']) && $_POST['token']!='' ? $_POST['token'] : '';
    
    bindupdate("user", array("device_token"=>$device_token), "user_id='{$result[0]['user_id']}'");
    
    $userdata['user_id'] = $result[0]['user_id'];
    $userdata['name'] = $result[0]['name'];
    $userdata['mobile_number'] = $result[0]['mobile_number'];
    $userdata['password'] = $result[0]['password'];
    $userdata['profile_pic'] = $result[0]['profile_pic'];
    $userdata['address'] = $result[0]['address'];
    $userdata['app_version_code'] = $result[0]['app_version_code'];
    $userdata['insert_date'] = $result[0]['insert_date'];
    $userdata['is_admin'] = $result[0]['is_admin'];
    /* convert null to array */
    array_walk_recursive($userdata, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });
    
    
    $response['status_code'] = 200;
    $response['message'] = "Data fetch successfully";
    $response['success'] = true;
    $response['data'] = $userdata;
} else {
    $response['status_code'] = 404;
    $response['message'] = "You have entered wrong credentials";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

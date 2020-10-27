<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$where  = "";
if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
    $where.="and user_id='{$_REQUEST['user_id']}'";
}else{
    $where.="and is_admin='0'";
}

$result = get_result("SELECT * FROM user where is_delete=0 $where order by user_id desc");
if (count($result) > 0) {
    
    if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
    $userdata['user_id'] = $result[0]['user_id'];
    $userdata['name'] = $result[0]['name'];
    $userdata['mobile_number'] = $result[0]['mobile_number'];
    $userdata['password'] = $result[0]['password'];
    $userdata['profile_pic'] = $result[0]['profile_pic'];
    $userdata['address'] = $result[0]['address'];
    $userdata['box_number'] = $result[0]['box_number'];
    $userdata['app_version_code'] = $result[0]['app_version_code'];
    $userdata['insert_date'] = $result[0]['insert_date'];
    
    }else{
        $userdata = $result;
    }
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
    $response['message'] = "Users Not Found";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();
$where = "";
if (isset($_REQUEST['plan_id']) && $_REQUEST['plan_id'] != '') {
    $where .= "and plan_id='{$_REQUEST['plan_id']}'";
}
$result = get_result("SELECT * FROM plan where is_delete=0 $where order by price asc");
if (count($result) > 0) {
    
    $data = array();
    foreach($result as $result){
        $details['plan_id'] = $result['plan_id'];
        $details['title'] = $result['title'];
        $details['price'] = $price_label.$result['price'];
        $details['description'] = $result['description'];
        $details['is_delete'] = $result['is_delete'];
        $details['insert_date'] = $result['insert_date'];
        $data[] = $details;
    }
    
    /* convert null to array */
    array_walk_recursive($data, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });
    $response['status_code'] = 200;
    $response['message'] = "Data fetch successfully";
    $response['success'] = true;
    $response['data'] = $data;
} else {
    $response['status_code'] = 404;
    $response['message'] = "plan's Not Found";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$result = get_result("SELECT * FROM faq");
if (count($result) > 0) {
    /* convert null to array */
    array_walk_recursive($result, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });
    $response['status_code'] = 200;
    $response['message'] = "Data fetch successfully";
    $response['success'] = true;
    $response['data'] = $result;
} else {
    $response['status_code'] = 404;
    $response['message'] = "Faq's Not Found";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();


if (!isset($_POST['user_id']) || $_POST['user_id'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Login First";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_POST['lis_box']) || count($_POST['lis_box']) < 1) {
    $response['status_code'] = 401;
    $response['message'] = "Please add box";
    $response['success'] = true;

    echo json_encode($response);
    exit();
}
$check_inserted = array();
for ($i = 0; $i < count($_POST['lis_box']); $i++) {
    if ($_POST['lis_box'][$i] != '') {
        $insert = array(
            "user_id" => $_POST['user_id'],
            "box_details" => $_POST['lis_box'][$i],
            "list_box_number" => $_POST['list_box_number'][$i],
            "insert_date" => date('Y-m-d h:i:sa'),
        );
        $added = insert('box', $insert);
        if ($added) {
            $check_inserted[] = 1;
        }
    }
}
if (count($check_inserted) > 0) {

    $response['status_code'] = 200;
    $response['message'] = "Box Added Successfully";
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

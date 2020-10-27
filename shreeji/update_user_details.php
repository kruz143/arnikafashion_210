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
if (!isset($_POST['mobile_number']) || $_POST['mobile_number'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter Mobile Number";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

if (!isset($_POST['name']) || $_POST['name'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter Name";
    $response['success'] = true;

    echo json_encode($response);
    exit();
}
$user_id = $_POST['user_id'];
/* check dublicate mobilenumber */
$check_mobile = get_result("SELECT * FROM user where mobile_number='{$_POST['mobile_number']}' and user_id NOT IN ('{$user_id}')");
if (count($check_mobile) > 0) {
    $response['status_code'] = 401;
    $response['message'] = "Mobile Number Already In System Please Add Another.";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
/* check dublicate mobilenumber */
$email_id = isset($_POST['email_address']) ? $_POST['email_address'] : "";
if ($email_id != '') {
    /* check dublicate Email */
    $check_email = get_result("SELECT * FROM user where email_address='{$email_id}' and user_id NOT IN ('{$user_id}')");
    if (count($check_email) > 0) {
        $response['status_code'] = 401;
        $response['message'] = "Email Id Already In System Please Add Another.";
        $response['success'] = true;
        echo json_encode($response);
        exit();
    }
}
/* check dublicate mobilenumber */


$insert = array(
    "name" => $_POST['name'],
    "mobile_number" => $_POST['mobile_number'],
    "email_address" => $email_id,
    "address" => isset($_POST['address']) ? $_POST['address'] : "",
    // "box_number" => isset($_POST['box_number']) ? $_POST['box_number'] : "",
);
if (bindupdate('user', $insert, "user_id='{$user_id}'")) {


    /* update box */
    if (isset($_POST['lis_box']) && count($_POST['lis_box']) > 0) {
        $check_inserted = array();
        for ($i = 0; $i < count($_POST['lis_box']); $i++) {
            if ($_POST['lis_box'][$i] != '') {
                $bxinsert = array(
                    "user_id" => $user_id,
                    "box_details" => $_POST['lis_box'][$i],
                    "list_box_number" => $_POST['list_box_number'][$i],
                );
//                $added = insert('box', $insert);
                bindupdate('box', $bxinsert, "box_id='{$_POST['box_id'][$i]}'");                
            } else {
                if (isset($_POST['box_id'][$i]) && $_POST['box_id'][$i] > 0):
                    hard_delete('box', 'box_id', $_POST['box_id'][$i]);
                endif;
            }
            
        }
    }
    /* update box */



    $result = get_result("SELECT * FROM user where user_id='{$user_id}'");
    $userdata['user_id'] = $result[0]['user_id'];
    $userdata['name'] = $result[0]['name'];
    $userdata['mobile_number'] = $result[0]['mobile_number'];
    $userdata['email_address'] = $result[0]['email_address'];
    $userdata['password'] = $result[0]['password'];
    $userdata['profile_pic'] = $result[0]['profile_pic'];
    $userdata['address'] = $result[0]['address'];
    $userdata['box_number'] = $result[0]['box_number'];
    $userdata['app_version_code'] = $result[0]['app_version_code'];
    $userdata['insert_date'] = $result[0]['insert_date'];

    /* convert null to array */
    array_walk_recursive($userdata, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });

    $response['status_code'] = 200;
    $response['message'] = "Profile Update Successfully";
    $response['success'] = true;
    $response['data'] = $userdata;
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

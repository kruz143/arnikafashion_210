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
if (!isset($_POST['name']) || $_POST['name'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter Name";
    $response['success'] = true;

    echo json_encode($response);
    exit();
}

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != '') {
    /* image validation */
    $extension = get_extension($_FILES['profile_pic']['name']);
    $valid_ext = array("jpg", "png", "gif", "jpeg");
    if (!in_array($extension, $valid_ext)) {
        $response['status_code'] = 401;
        $response['message'] = "Upload profile photo in valid format.";
        $response['success'] = true;
        echo json_encode($response);
        exit();
    }
    /* change image name */
    $username = clean($_POST['name']);
    $image_new_name = $username . time() . "." . $extension;
    /* change image name */
} else {
    $image_new_name = "default-user.png";
}
/* image validation */




/* check dublicate mobilenumber */
$check_mobile = get_result("SELECT * FROM user where mobile_number='{$_POST['mobile_number']}'");
if (count($check_mobile) > 0) {
    $response['status_code'] = 401;
    $response['message'] = "Mobile Number Already Registered.";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
/* check dublicate mobilenumber */

$email_id = isset($_POST['email_address']) ? $_POST['email_address'] : "";
if ($email_id != '') {
    /* check dublicate Email */
    $check_email = get_result("SELECT * FROM user where email_address='{$email_id}'");
    if (count($check_email) > 0) {
        $response['status_code'] = 401;
        $response['message'] = "Email Id Already In System.";
        $response['success'] = true;
        echo json_encode($response);
        exit();
    }
}



$device_token = isset($_POST['token']) && $_POST['token'] != '' ? $_POST['token'] : '';
$insert = array(
    "name" => $_POST['name'],
    "mobile_number" => $_POST['mobile_number'],
    "password" => $_POST['password'],
    "app_version_code" => isset($_POST['app_version_code']) ? $_POST['app_version_code'] : "",
    "email_address" => isset($_POST['email_address']) ? $_POST['email_address'] : "",
    "address" => isset($_POST['address']) ? $_POST['address'] : "",
    "profile_pic" => "upload/" . $image_new_name,
    "device_token" => $device_token,
    "insert_date" => date('Y-m-d h:i:sa'),
);
if (insert('user', $insert)) {

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != '') {
        /* move uploaded file into folder */
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "upload/" . $image_new_name);
        compress_image("upload/" . $image_new_name, "upload/" . $image_new_name, 80);
        /* move uploaded file into folder */
    }
    $user_id = insertid();

    $result = get_result("SELECT * FROM user where user_id='{$user_id}'");
    $userdata['user_id'] = $result[0]['user_id'];
    $userdata['name'] = $result[0]['name'];
    $userdata['mobile_number'] = $result[0]['mobile_number'];
    $userdata['password'] = $result[0]['password'];
    $userdata['profile_pic'] = $result[0]['profile_pic'];
    $userdata['address'] = $result[0]['address'];
    $userdata['app_version_code'] = $result[0]['app_version_code'];
    $userdata['insert_date'] = $result[0]['insert_date'];

    /* convert null to array */
    array_walk_recursive($userdata, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });

    $response['status_code'] = 200;
    $response['message'] = "Registered Successfully";
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

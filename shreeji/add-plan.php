<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();


if (!isset($_POST['title']) || $_POST['title'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter title";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_POST['price']) || $_POST['price'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Enter price";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

if (!isset($_FILES['image']) || $_FILES['image']['name'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Upload Plan Image";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}


/* image validation */
$extension = get_extension($_FILES['image']['name']);
$valid_ext = array("jpg", "png", "gif", "jpeg");
if (!in_array($extension, $valid_ext)) {
    $response['status_code'] = 401;
    $response['message'] = "Upload Plan Image in valid format.";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
/* image validation */

/* change image name */
$username = clean($_POST['title']);
$image_new_name = $username . time() . "." . $extension;
/* change image name */
 
$upload_path = "upload/pack/";

$insert = array(
    "title" => $_POST['title'],
    "price" => $_POST['price'],
    "description" => $upload_path . $image_new_name,
    "insert_date" => date('Y-m-d h:i:sa'),
);
if (insert('plan', $insert)) {

    /* move uploaded file into folder */
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $image_new_name);
    compress_image($upload_path . $image_new_name, $upload_path . $image_new_name, 80);
    /* move uploaded file into folder */

    $plan_id = insertid();

     
    $response['status_code'] = 200;
    $response['message'] = "Plan Added Successfully";
    $response['success'] = true;
    $response['plan_id'] = $plan_id;
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

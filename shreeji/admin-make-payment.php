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
/* if (!isset($_POST['box_id']) || $_POST['box_id'] == '') {
  $response['status_code'] = 401;
  $response['message'] = "Please Select box";
  $response['success'] = true;
  echo json_encode($response);
  exit();
  }
 */
if (!isset($_POST['box_id']) || count($_POST['box_id']) < 1) {
    $response['status_code'] = 401;
    $response['message'] = "Please Select box";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_POST['start_date']) || $_POST['start_date']== '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Select Start Date";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_POST['end_date']) || $_POST['end_date'] == '') {
    $response['status_code'] = 401;
    $response['message'] = "Please Select End Date";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}
if (!isset($_POST['amount']) || count($_POST['amount']) < 1) {
    $response['status_code'] = 401;
    $response['message'] = "Enter Amount";
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

$user_details = get_result("select * from user where user_id='{$_POST['user_id']}'");
$total_amount = $_POST['total_amount'];
$check_inserted = array();

$start_date=date_frmt($_POST['start_date']);
$end_date=date_frmt($_POST['end_date']);

$insert_master = array(
    "user_id" => $_POST['user_id'],
    "total_amount" => $total_amount,
    "transection_code" => $_POST['transection_code'],
    "is_admin" => isset($_POST['is_admin']) ? $_POST['is_admin'] : 0,
    "start_date" => $start_date,
    "end_date" => $end_date,
    "insert_date" => date('Y-m-d h:i:sa'),
);
if (insert('payment_master', $insert_master)) {

    $master_id = insertid();

    for ($i = 0; $i < count($_POST['box_id']); $i++) {

        if ($_POST['box_id'][$i] != '') {

            $total_months = diff_month($start_date,$end_date);
            if ($total_months > 0) {
                for ($m = 0; $m <= $total_months; $m++) {
                    $insert = array(
                        "user_id" => $_POST['user_id'],
                        "amount" => $_POST['amount'][$i],
                        "box_id" => $_POST['box_id'][$i],
                        "no_of_months" => $_POST['no_of_months'][$i],
                        "transection_code" => time(),
                        "master_id" => $master_id,
                        "insert_date" => date('Y-m-d h:i:sa', strtotime("+$m month", strtotime($start_date))),
                    );
                    if (insert('payment', $insert)) {
                        $check_inserted[] = 1;
                    }
                }
            }
        }
    }
    if (count($check_inserted) > 0) {

        /* push notification */
        $push_title = "New Payment";
        $push_body = "{$user_details[0]['name']} has paid $total_amount";
        if (count(admin_token()) > 0) {
            foreach (admin_token() as $admin_token):
                push_fb_notification($push_title, $push_body, $admin_token['token'], $admin_token['user_id']);
            endforeach;
        }
        /* push notification */


        $response['status_code'] = 200;
        $response['message'] = "Payment Added Successfully";
        $response['success'] = true;
        $response['data'] = '';
    } else {
        $response['status_code'] = 404;
        $response['message'] = "Something went wrong please try again";
        $response['success'] = false;
    }
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

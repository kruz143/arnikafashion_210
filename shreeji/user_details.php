<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$where = "";
if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
    $where .= "and user_id='{$_REQUEST['user_id']}'";
} else {
    $where .= "and is_admin='0'";
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

        $check_payment = get_result("SELECT total_amount FROM `payment_master` WHERE user_id='{$result[0]['user_id']}' order by id desc limit 0,1");
        $userdata['amount'] = $check_payment[0]['total_amount'];
        $userdata['is_paid'] = $check_payment[0]['total_amount'] > 0 ? 1 : 0;



        /* box details */
        $box_result = get_result("SELECT
    `box`.`box_id`
    , `box`.`user_id`
    , `box`.`box_details`
    , `box`.`list_box_number`
    , `box`.`insert_date`
    , `user`.`name`
    , `user`.`mobile_number`
FROM
    `box`
    LEFT JOIN `user` 
        ON (`box`.`user_id` = `user`.`user_id`) where `box`.is_delete=0 and `box`.user_id='{$result[0]['user_id']}'");
        $userdata['box_details'] = $box_result;

        /* additional charges */
        $additional_charge_result = get_result("SELECT
    `additional_charge`.*
    , `box`.`box_details`
    , `box`.`list_box_number`
FROM
    `additional_charge`
    LEFT JOIN `box` 
        ON (`additional_charge`.`box_id` = `box`.`box_id`) where `additional_charge`.is_delete=0 and `additional_charge`.user_id='{$result[0]['user_id']}' order by `additional_charge`.id desc");
        $userdata['additional_charge'] = $additional_charge_result;
        /* additional charges */

        $pdata = array();
        
        $master_payment = get_result("select * from payment_master where is_delete=0 and user_id='{$result[0]['user_id']}' order by id desc limit 0,1");
        foreach ($master_payment as $master_payment) {

            $m['id'] = $master_payment['id'];
            $m['total_amount'] = $master_payment['total_amount'];
            $m['transection_code'] = $master_payment['transection_code'];
            $m['insert_date'] = $master_payment['insert_date'];

            $paymentresult = get_result("SELECT
    `payment`.`payment_id`
    , `payment`.`user_id`
    , `payment`.`amount`
    , `payment`.`box_id`
    , `payment`.`transection_code`
    , `payment`.`no_of_months`
    , `payment`.`insert_date`
    , `user`.`name`
    , `user`.`mobile_number`
    , `box`.`box_details`
    , `box`.`list_box_number`
FROM
    `payment`
    LEFT JOIN `user` 
        ON (`payment`.`user_id` = `user`.`user_id`)
    LEFT JOIN `box` 
        ON (`payment`.`box_id` = `box`.`box_id`) where `payment`.is_delete=0 and `payment`.master_id='{$master_payment['id']}' order by `payment`.payment_id desc");
            $details_data = array();
            foreach ($paymentresult as $paymentresult) {
                $details['payment_id'] = $paymentresult['payment_id'];
                $details['user_id'] = $paymentresult['user_id'];
                $details['amount'] = $price_label . $paymentresult['amount'];
                $details['box_id'] = $paymentresult['box_id'];
                $details['transection_code'] = $paymentresult['transection_code'];
                $details['no_of_months'] = $paymentresult['no_of_months'];
                $details['insert_date'] = $paymentresult['insert_date'];
                $details['name'] = $paymentresult['name'];
                $details['mobile_number'] = $paymentresult['mobile_number'];
                $details['box_details'] = $paymentresult['box_details'];
                $details['list_box_number'] = $paymentresult['list_box_number'];
                $details_data[] = $details;
            }
            $m['payment_details'] = $details_data;
            $pdata[] = $m;
            unset($details_data);
        }
        $userdata['payment_details'] = $pdata;

        $plan_result = get_result("SELECT * FROM plan where is_delete=0 order by price asc");
        $userdata['plan_details'] = $plan_result;
    } else {
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

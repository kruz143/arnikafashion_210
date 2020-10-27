<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$month = "";
if (isset($_REQUEST['month']) && $_REQUEST['month'] != '') {
    $month = $_REQUEST['month'];
}

$result = get_result("SELECT * FROM user where is_delete=0 and is_admin=0 order by user_id desc");
if (count($result) > 0) {
    $user_data = array();
    foreach ($result as $user_details):

        $userdata['user_id'] = $user_details['user_id'];
        $userdata['name'] = $user_details['name'];
        $userdata['mobile_number'] = $user_details['mobile_number'];
        $userdata['password'] = $user_details['password'];
        $userdata['profile_pic'] = $user_details['profile_pic'];
        $userdata['address'] = $user_details['address'];
        $userdata['app_version_code'] = $user_details['app_version_code'];
        $userdata['box_number'] = $user_details['box_number'];


        /* payment */
        $check_payment = get_result("SELECT sum(total_amount) as totalamount,insert_date FROM `payment_master` WHERE user_id='{$user_details['user_id']}' and id IN (select master_id from payment where user_id='{$user_details['user_id']}' and month(`insert_date`)='$month')");
        //$check_payment = get_result("SELECT sum(total_amount) as totalamount,insert_date FROM `payment_master` WHERE user_id='{$user_details['user_id']}' and month(`insert_date`)='$month'");
        $userdata['amount'] = $check_payment[0]['totalamount'];
        $userdata['is_paid'] = $check_payment[0]['totalamount'] > 0 ? 1 : 0;
        $userdata['insert_date'] = $check_payment[0]['totalamount'] > 0 ? $check_payment[0]['insert_date'] : '0000-00-00';
        /* payment */


        /* box detail */
        $box_result = get_result("SELECT
    `box`.`box_id`
    , `box`.`user_id`
    , `box`.`box_details`
    , `box`.`list_box_number`
    , `box`.`insert_date`
    , `user`.`name`
    , `user`.`mobile_number`
    , `user`.`address`
FROM
    `box`
    LEFT JOIN `user` 
        ON (`box`.`user_id` = `user`.`user_id`) where `box`.is_delete=0 and `box`.user_id='{$user_details['user_id']}' order by `box`.box_id desc");
        $bxlist = array();
        foreach ($box_result as $box_result) {

            $total_additional_charge = get_result("SELECT sum(channel_charge) as total_charge FROM `additional_charge` where is_delete=0 and user_id='{$box_result['user_id']}' and box_id='{$box_result['box_id']}' order by id desc");
            $check_bxpayment = get_result("SELECT sum(amount) as totalamount FROM `payment` WHERE box_id='{$box_result['box_id']}' and month(`insert_date`)='$month'");
            $bx['box_id'] = $box_result['box_id'];
            $bx['user_id'] = $box_result['user_id'];
            $bx['box_details'] = $box_result['box_details'];
            $bx['list_box_number'] = $box_result['list_box_number'];
            $bx['insert_date'] = $box_result['insert_date'];
            $bx['name'] = $box_result['name'];
            $bx['mobile_number'] = $box_result['mobile_number'];
            $bx['address'] = $box_result['address'];
            $bx['additional_charge'] = $total_additional_charge[0]['total_charge'];
            $bx['is_paid'] = $check_bxpayment[0]['totalamount'] > 0 ? 1 : 0;
            $bx['paid_amount'] = $check_bxpayment[0]['totalamount'] > 0 ? $check_bxpayment[0]['totalamount'] : 0;
            $bxlist[] = $bx;
        }
        /* box detail */
        $userdata['box_details'] = $bxlist;



        $user_data[] = $userdata;

    endforeach;

    /* convert null to array */
    array_walk_recursive($user_data, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });

    $response['status_code'] = 200;
    $response['message'] = "Data fetch successfully";
    $response['success'] = true;
    $response['data'] = $user_data;
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

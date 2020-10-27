<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$where = "";
if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
    $where .= "and user_id='{$_REQUEST['user_id']}'";
}

$master_payment = get_result("select * from payment_master where is_delete=0 $where order by id desc");

if (count($master_payment) > 0) {


    $data = array();

    foreach ($master_payment as $master_payment) {

        $start_date = $master_payment['start_date']!='0000-00-00' ? $master_payment['start_date'] : '';
        $end_date = $master_payment['end_date']!='0000-00-00' ? $master_payment['end_date'] : '';
        $m['id'] = $master_payment['id'];
        $m['total_amount'] = $master_payment['total_amount'];
        $m['transection_code'] = $master_payment['transection_code'];
        $m['start_date'] = $start_date;
        $m['end_date'] = $end_date;
        $m['insert_date'] = $master_payment['insert_date'];
        $limit_con = $start_date!='' && $end_date!='' ? "group by `payment`.box_id" : "";
        $result = get_result("SELECT
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
FROM
    `payment`
    LEFT JOIN `user` 
        ON (`payment`.`user_id` = `user`.`user_id`)
    LEFT JOIN `box` 
        ON (`payment`.`box_id` = `box`.`box_id`) where `payment`.is_delete=0 and `payment`.master_id='{$master_payment['id']}' $limit_con order by `payment`.payment_id desc ");
        $details_data = array();
        foreach ($result as $result) {
            $details['payment_id'] = $result['payment_id'];
            $details['user_id'] = $result['user_id'];
            $details['amount'] = $price_label . $result['amount'];
            $details['box_id'] = $result['box_id'];
            $details['transection_code'] = $result['transection_code'];
            $details['no_of_months'] = $result['no_of_months'];
            $details['insert_date'] = $result['insert_date'];
            $details['name'] = $result['name'];
            $details['mobile_number'] = $result['mobile_number'];
            $details['box_details'] = $result['box_details'];
            $details_data[] = $details;
        }
        $m['payment_details'] = $details_data;
        $data[] = $m;
        unset($details_data);
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
    $response['message'] = "payment Not Found";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

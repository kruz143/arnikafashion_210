<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$where = "";
if (isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] != '') {
    $where .= "and `additional_charge`.user_id='{$_REQUEST['customer_id']}'";
}

$result = get_result("SELECT
    `additional_charge`.*
    , `box`.`box_details`
    , `box`.`list_box_number`
FROM
    `additional_charge`
    LEFT JOIN `box` 
        ON (`additional_charge`.`box_id` = `box`.`box_id`) where `additional_charge`.is_delete=0 $where order by `additional_charge`.id desc");
$total_additional_charge = get_result("SELECT sum(channel_charge) as total_charge FROM `additional_charge` where is_delete=0 $where order by id desc");
if (count($result) > 0) {


    $data = array();
    foreach ($result as $result) {
        $details['charge_id'] = $result['id'];
        $details['customer_id'] = $result['user_id'];
        $details['channel_charge'] = $result['channel_charge'];
        $details['box_id'] = $result['box_id'];
        $details['box_details'] = $result['box_details'];
        $details['list_box_number'] = $result['list_box_number'];
//        $details['channel_charge'] = $price_label . $result['channel_charge'];
        $details['description'] = $result['description'];
        $details['insert_date'] = date('d-m-Y h:i:sa', strtotime($result['insert_date']));        
        $data[] = $details;
    }

    /* convert null to array */
    array_walk_recursive($data, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });

    $response['status_code'] = 200;
    $response['message'] = "Data fetch successfully";
    $response['total_additional_charge'] = $total_additional_charge[0]['total_charge'];
    $response['success'] = true;
    $response['data'] = $data;
} else {
    $response['status_code'] = 404;
    $response['message'] = "Additional Charge Not Found";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

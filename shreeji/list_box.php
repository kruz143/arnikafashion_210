<?php

include './dbconfig/db.php';
//if ($_SERVER['PHP_AUTH_USER'] == $GLOBALS['tokenname'] && $_SERVER['PHP_AUTH_PW'] == $GLOBALS['tokenvalue']) {
$response = array();

$where = "";
if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
    $where .= "and `box`.user_id='{$_REQUEST['user_id']}'";
}

$result = get_result("SELECT
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
        ON (`box`.`user_id` = `user`.`user_id`) where `box`.is_delete=0 $where order by `box`.box_id desc");
if (count($result) > 0) {
    $bxlist = array();
    foreach($result as $result){
        
        $total_additional_charge = get_result("SELECT sum(channel_charge) as total_charge FROM `additional_charge` where is_delete=0 and user_id='{$result['user_id']}' and box_id='{$result['box_id']}' order by id desc");
        
        $bx['box_id'] = $result['box_id'];
        $bx['user_id'] = $result['user_id'];
        $bx['box_details'] = $result['box_details'];
        $bx['list_box_number'] = $result['list_box_number'];
        $bx['insert_date'] = $result['insert_date'];
        $bx['name'] = $result['name'];
        $bx['mobile_number'] = $result['mobile_number'];
        $bx['address'] = $result['address'];
        $bx['additional_charge'] = $total_additional_charge[0]['total_charge'];
        $bxlist[] = $bx;
    }
    

    /* convert null to array */
    array_walk_recursive($bxlist, function (&$item, $key) {
        $item = null === $item ? '' : $item;
    });

    $response['status_code'] = 200;
    $response['message'] = "Data fetch successfully";
    $response['success'] = true;
    $response['data'] = $bxlist;
} else {
    $response['status_code'] = 404;
    $response['message'] = "box Not Found";
    $response['success'] = false;
}
echo json_encode($response);

//} else {
//    header('WWW-Authenticate: Basic realm="My Realm"');
//    header('HTTP/1.0 401 Unauthorized');
//    echo 'Sorry You Are not Allow to access';
//    exit;
//}

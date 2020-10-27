<?php

global $conn,$project_name;

// for webservice 
//$tokenname = 'sms';
//$tokenvalue = 'sms@123';
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $servername = "localhost";
    $username = 'root';
    $password = '';
    $dbname = 'cable_network';
} else {

    $servername = "localhost";
    $username = 'shreeji_cable';
    $password = 'shreeji_cable@2020';
    $dbname = 'shreeji_cable';
}
$conn = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

define('FIREBASE_API_KEY', 'AAAAtQv5MoI:APA91bFPdQWtopLi5Smr3ldIwAgWfMZDT2mXxmD3v4BCxkEij304boA1C4YXwX7p5vC5lGmghR6TU58CFsL9DpQ_plJ70QzU_6P4bkGIokGLjXDOpY9ZtTGdfLgrRxEqtJkKInTglXe6');
// Check connection
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

$project_name="Shreeji Cabel Network";

$price_label = "Rs. ";

function get_result($data) {
    $query = $GLOBALS['conn']->prepare($data);
    $query->execute();
    return $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

function insertid() {
    return $GLOBALS['conn']->lastInsertId();
}

function insert($table_name, $data) {

    $qstnmrk = "";

    foreach ($data as $key => $value) {
        $qstnmrk .= "?, ";
    }

    $qstnmrk = rtrim($qstnmrk, ", ");

    $keys = implode(",", array_keys($data));
    $keys1 = str_replace(":", "", implode(",", array_keys($data)));
    $values = implode("','", array_values($data));

    $query = $GLOBALS['conn']->prepare("INSERT INTO $table_name ($keys1) VALUES ($qstnmrk)");
    $id = 0;
    foreach ($data as $key => $value) {
        $id++;
        $query->bindValue($id, $value);
    }

    $insert = $query->execute();
    if ($insert == TRUE) {
        return TRUE;
    } else {
        echo implode(",", $query->errorInfo());
        exit();
    }
}

function bindupdate($table_name, $data, $where) {


    $query = "UPDATE $table_name SET ";

    foreach ($data as $key => $value) {
        $query .= "`" . $key . "`=?, ";
    }

    $query = rtrim($query, ", ");

    $query .= " where $where";

    $upq = $GLOBALS['conn']->prepare($query);
    $id = 0;
    foreach ($data as $key => $value) {
        $id++;
        $upq->bindValue($id, $value);
    }
    $update = $upq->execute();
    if ($update == TRUE) {
        return TRUE;
    } else {
        echo implode(",", $update->errorInfo());
        die();
    }
}

function get_extension($path) {
    return pathinfo($path, PATHINFO_EXTENSION);
}

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function compress_image($source_url, $destination_url, $quality) {

    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}

function hard_delete($table_name, $where, $id) {
    $sql = "DELETE FROM $table_name WHERE $where = ?";
    $q = $GLOBALS['conn']->prepare($sql);
    $q->execute(array($id));
    return true;
}

/* firebase */

function send($registration_ids, $message) {
    $fields = array(
        'registration_ids' => $registration_ids,
        'token' => $registration_ids,
        'notification' => $message,
        'data' => $message,
    );
    return sendPushNotification($fields);
}

/*
 * This function will make the actuall curl request to firebase server
 * and then the message is sent 
 */

function sendPushNotification($fields) {
//importing the constant files
//firebase server url to send the curl request
    $url = 'https://fcm.googleapis.com/fcm/send';

//building headers for the request
    $headers = array(
        'Authorization: key=' . FIREBASE_API_KEY,
        'Content-Type: application/json'
    );

//Initializing curl to open a connection
    $ch = curl_init();

//Setting the curl url
    curl_setopt($ch, CURLOPT_URL, $url);

//setting the method as post
    curl_setopt($ch, CURLOPT_POST, true);

//adding headers 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//disabling ssl support
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//adding the fields in json format 
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

//finally executing the curl request 
    $result = curl_exec($ch);
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

//Now close the connection
    curl_close($ch);

//and return the result 
    return $result;
}

function getPush($title, $message) {
    $res = array();
    $res['title'] = $title;
    $res['body'] = $message;
    return $res;
}

function push_fb_notification($title, $body, $device_id, $user_id) {
    $mPushNotification = getPush($title, $body);
   
//getting the token from database object 
    $devicetoken = array($device_id);

//sending push notification and displaying result 
    $details_response = send($devicetoken, $mPushNotification);

    add_notification($details_response, $user_id, $title, $body);

    return $details_response;
}

function admin_token() {
    $admin_list = get_result("select device_token,user_id from user where is_admin=1");
    $tokens = array();
    foreach ($admin_list as $admin_list):
        $tok['token'] = $admin_list['device_token'];
        $tok['user_id'] = $admin_list['user_id'];
        $tokens[] = $tok;
    endforeach;
    return $tokens;
}

function user_token($user_id) {
    $admin_list = get_result("select device_token from user where user_id='{$user_id}'");
    return $admin_list[0]['device_token'];
}

function add_notification($data, $user_id, $title, $messgae) {
    $insert = array(
        "firebase_log" => $data,
        "title" => $title,
        "messgae" => $messgae,
        "user_id" => $user_id,
        "insert_date" => date('Y-m-d h:i:sa'),
    );
    insert('notification', $insert);
}

/* firebase */
function month_string($str) {
    preg_match_all('!\d+!', $str, $matches);
    return count($matches[0]) > 0 && is_numeric($matches[0][0]) ? $matches[0][0] : 0;
}


function fg_email($username,$otp,$email){
    $body='';
    $body.='<html>';
    $body.= "<h3>Hello $username,</h3>";
    $body.= "<p>You have requested for reset your password.</p>";
    $body.= "<p>For Reset Password your otp is <span style='background: #fce8ff;font-size: 18px;border: 1px solid black;padding: 5px;'>$otp</span>. Please don't share this otp to any one.</p>";
    $body.= "<p>Thank You :)</p>";
    $body.= '</html>';
     
    $subject = "Reset Password Request From ".$GLOBALS['project_name'];
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From:{$GLOBALS['project_name']} <no-reply@everysolution.in>\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    mail($email, $subject, $body, $headers);
}
function date_frmt($date){
    $e = explode("/", $date);
    $d = $e[0];
    $m = $e[1];
    $y = $e[2];
    $create_date = $y."-".$m."-".$d;
    return date('Y-m-d', strtotime($create_date));
}
function diff_month($date1,$date2)
{
    
    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);
    
    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);
    
    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);
    
    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    return $diff;
}
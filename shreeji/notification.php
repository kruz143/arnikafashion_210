<?php

include './dbconfig/db.php';


$title="Demo Notification";


$mPushNotification = getPush($title,$body);

//getting the token from database object 
//$devicetoken = array("eJUYXmgCR6m41DHS_WLKGC:APA91bGCrbd3K31YfJbD6kdPdxybMSKIgJBiCMifoIoFFEyEGZc6wNz3TXwH9w6iMwKLigW4h3bSNILYU5IAsa8VWO-5P2FgvMwzMD7At-B4Tim-ckkIr326ii4PYsMiTa9H7tjGwGrh");
$device_id = "cV0qSJ3IRcKVnI8GdX9Qmd:APA91bF_AL1Z3YMrMS8PABSAP3jPgzVpzGhvxuD9ptZ2D3sB2oxow4i0TXZ2ZMLRyuOZsjc3Siv74dXWZ8WM4vSCCA2svW7Jolnwrc3u76bCbusv0xVJ8PyTEWLxK7zq_aS_SE0yMpOC";
$notiuser = get_result("SELECT device_token,user_id,name FROM `user` where device_token!=''");
foreach ($notiuser as $admin_token):

$body="Hi {$admin_token['name']}, This is Notification Messaage Demo";
//sending push notification and displaying result 
// echo send($devicetoken, $mPushNotification);

push_fb_notification($title, $body, $admin_token['device_token'], $admin_token['user_id']);
endforeach;

echo "send";
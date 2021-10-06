<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Dhaka');
$data['time']= date("h:i A");
$data['date']= date("D, M Y");



$myfile = fopen("weather.txt", "r") or die("Unable to open file!");
$json=fread($myfile,filesize("weather.txt"));
fclose($myfile);

$ar = json_decode($json);

$i = 1;
foreach($ar as $key=>$a){
    $data[$key] = $a;
}

$fb = file_get_contents("fb.txt");
$fb_ar = json_decode($fb, true);
$message = $fb_ar["entry"][0]["messaging"][0]["message"]["text"];
$data['fb'] = str_split($message, 25)[0];


$myfile = fopen("last_email.txt", "r") or die("Unable to open file!");
$json=fread($myfile,filesize("last_email.txt"));
fclose($myfile);

$ar = json_decode($json);

$i = 1;
foreach($ar as $a){
    // $data['email'.$i++] = $a;
}


$json = json_encode($data);
echo $json;
?>
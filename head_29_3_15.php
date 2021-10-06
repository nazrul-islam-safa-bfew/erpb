<?php

function post_it($appsecret="", $page_id="", $message=""){

	$message = urlencode($message);
	$link = 'https://graph.facebook.com/v9.0/'.$page_id."/feed?message=".$message."&access_token=".$appsecret;
	// echo $link;
		
	$ch = curl_init($link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $reply);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	
	// execute!
	$response = curl_exec($ch);

	
// file_put_contents("fb.txt", $response);
file_put_contents("fb1.txt", $reply);
	
	// close the connection, release resources used
	curl_close($ch);
	return $response;
	// do anything you want with your response
}
$page_id = "104731341580084";
$appsecret = "EAADMs7TgxSIBABLqyI7g3N6RmZBRDrGfsZAlhqZARkcSAso5iKd1Q0hQVgo9wZBFvqfzZAgO9ML0CPQjzqrI1hbNdZCMBRhZAki8D9GSnmA66uS8oUTdx7f6tI0LAeKAqftJqSS9j1FTPzpRONBuZCJGajJ7P1yQO1pRj2tWypJyydl3o806iswUbcM5sTZBwrhgZD";


$host = "208.97.163.167";
$db_name = "islamicapp2";
$user = "islamicappdb";
$pass = "6Pbajt7JkA*2Jt9";




$db = mysqli_connect($host, $user, $pass, $db_name);
mysqli_set_charset($db,"utf8");
$sql = "select * from all_hadith_refined where published=0 order by id asc limit 1";
$q = mysqli_query($db, $sql);
$row = mysqli_fetch_array($q);
// print_r($row);


$search_arr = [
	"&#x27;",
	"&amp;#x27;",
	"&#39;",
	"&amp;#39;"

];

$replace_arr = [
	":",
	":",
	":",
	":"
];





	$book = htmlspecialchars_decode($row['book']);
	$hadith = html_entity_decode($row['hadith']);
	$hadith = htmlspecialchars_decode($hadith);
	$hadith = str_replace($search_arr, $replace_arr, $hadith);
	$quality = htmlspecialchars_decode($row['is_verified']);






$complete = $hadith;


$res = post_it($appsecret, $page_id, $complete);
$j_res = json_decode($res, true);
if($j_res['id']){
	$sql = "update all_hadith_refined set published=1 where id = ".$row['id'];
	mysqli_query($db, $sql);
}

?>
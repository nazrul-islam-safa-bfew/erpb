<?php
$code = "1145998242";
$hub_verify_token  = $_GET['hub_verify_token'];
$hub_challenge  = $_GET['hub_challenge'];

if($code == $hub_verify_token)
	echo $hub_challenge;





	$appsecret = 'EAAME48I1N2EBACfxIt6wAo3CWzMqOh5ZAg35KPlZCSF6zdmtHNDhIEChacD6WnW8ZBgNrVrwjNTnkMGf2LkZCZBQ7Y0NKz5K1W6Xgr4ZCqRpgctiaI3XD7Rs7AYyMc2Q3Ne7mFOaM7fwNqnYRd4qn4x9ekIrQ0xKsm5ORoHwivg4KyRgjzkPTYznR1tp2gADIZD';
	$res = file_get_contents('php://input');


	$arr = json_decode($res, true);

	$recepent_id = $arr["entry"][0]["messaging"][0]["sender"]["id"];
	$message = $fb_ar["entry"][0]["messaging"][0]["message"]["text"];

	

	$reply = '{
		"messaging_type": "RESPONSE",
		"recipient": {       "id":"'.$recepent_id.'"    },
		"message": {       "text":"Thank you so much for your message. We will contact with you ASAP."}
	}';
	



	reply_to($appsecret, $reply);


	function reply_to($appsecret="", $reply=""){

		
		$ch = curl_init('https://graph.facebook.com/me/messages?access_token='.$appsecret);
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
		
		// do anything you want with your response
	}


	file_put_contents("fb.txt", $res);
?>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

	function fcm_send($pust_token,$content){
		
		if($pust_token){

			$url = 'https://fcm.googleapis.com/v1/projects/kaviar-67020/messages:send';
			putenv('GOOGLE_APPLICATION_CREDENTIALS='.$_SERVER['DOCUMENT_ROOT'].'/fcm_auth.json');

			$scope = 'https://www.googleapis.com/auth/firebase.messaging';
			$client = new Google_Client();
			$client->useApplicationDefaultCredentials();
			$client->setScopes($scope);	
			$auth_key = $client->fetchAccessTokenWithAssertion();
			//echo $auth_key['access_token'];

			$ch = curl_init();

			//header 설정 후 삽입

			$headers = array
			(
				'Authorization: Bearer ' . $auth_key['access_token'],
				'Content-Type: application/json'
			);

			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 

			$title = "[캐비아]";
			$message = $content;

			$notification_opt = array (
				'title'         => $title,
				'body'          => $message
				// 'image' => 'http://sowonbyul.com/original/totalAdmin/images/Icon-512.png'
			);
	/*
			$datas = array (
				'test1'     => '테스트 데이터1',
				'test2'     => '테스트 데이터2',
				'test3'     => '테스트 데이터3'
			);
	*/
			$android_opt = array (
				'notification' => array(
					'default_sound'         => true
				)
			);

			$message = array
			(
				'token' => $pust_token,
				'notification' => $notification_opt,
				'android' => $android_opt

			);

			$last_msg = array (
				"message" => $message
			);

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($last_msg)); 
			$result = curl_exec($ch);

			if($result === FALSE){
			  // die('FCM Send Error: ' . curl_error($ch));
				printf("cUrl error (#%d): %s<br>\n",
				curl_errno($ch),
				htmlspecialchars(curl_error($ch)));
			}

			return $result;
		}
	}
?>
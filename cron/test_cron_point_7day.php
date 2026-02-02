<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.lib.php');
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.kakao.lib.php');
	
    aligo_sms_call("내용", "01086201333", "0266703672", "", "", "");

?>
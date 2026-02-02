<?php
include_once("./_common.php");

$number = $_REQUEST['number'];
$type   = $_REQUEST['type'];
$content   = $_REQUEST['content'];

if($type == 1){ //사용유무 config 업데이트

	$sql = " update `g5_config` set cf_grade = '$content'";
	sql_query($sql);

}else if($type == 2) {
	
	$sql = " update `g5_member_grade` 
				set g_name = '$content'
			  where idx = $number ";
	sql_query($sql);

}else if($type == 3) {
	
	$sql = " update `g5_member_grade` 
				set g_discount = '$content'
			  where idx = $number ";
	sql_query($sql);

}else if($type == 4) {
	
	$sql = " update `g5_member_grade` 
				set g_reward = '$content'
			  where idx = $number ";
	sql_query($sql);

}else if($type == 5) {
	
	$sql = " update `g5_member_grade` 
				set g_reward_start = '$content'
			  where idx = $number ";
	sql_query($sql);

}else if($type == 6) {
	
	$sql = " update `g5_member_grade` 
				set g_reward_end = '$content'
			  where idx = $number ";
	sql_query($sql);

}


echo(json_encode(
array(
	"type"			=> 'Y'
	)
));

?>

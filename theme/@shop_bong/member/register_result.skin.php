<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';
$sql = " select * from {$g5['membercode_table']} where code_id = '{$member[mb_code]}' ";
$code = sql_fetch($sql);
/*if(file_exists(G5_THIS_PATH.'/member/register_result.skin.'.$code['code_id'].'.php')) {
	require_once(G5_THIS_PATH.'/member/register_result.skin.'.$code['code_id'].'.php');
	return;
}*/
?>


<div id="reg_result" class="register keep-all">
	<?php if($code['join_content']) {
		$join_content = preg_replace("/{name}/",$member['mb_nick'],$code['join_content']); //가입자 이름
		$join_content = preg_replace("/{company}/",$default['de_admin_company_name'],$join_content); //회사 이름
		echo $join_content;
	} else {
		if($config['cf_use_membercode'] && $code['code_name']) echo '<p class="fs20 fw600">'.$code['code_name'].' 회원입니다.</p>';
		echo '<p class="fs20 mt20">안녕하세요</p>';
		echo '<p class="fs18 mt15 keep-all">';
		echo $default['de_admin_company_name'].'는임직원과 그 가족여러분들의 복지개선을 위해 많은솔루션을 제공하고자 최선을 다 하고있습니다.';
		echo '</p>';
		echo '<p class="fs18 mt15">감사합니다.</p>';
		echo '<p class="fs18 mt15">'.$default['de_admin_company_name'].' 인사·총무 부서 일동</p>';
	} ?>
</div>

<div class="btn_confirm_reg p20">
	<a href="<?php echo G5_URL ?>/" class="_btn/lg/line w-full">메인으로</a>
</div>
<?php
if (!defined('_GNUBOARD_')) exit;

//상시 열림메뉴 설정 추가
if(!isset($config['cf_open_menu'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_open_menu` VARCHAR(255) NOT NULL DEFAULT '' ", true);
}
function get_open_menu_multiple_select($name, $selected='', $event='') {
    global $g5;
	
	$sql= " select * from {$g5['menu_table']} where LENGTH(me_code) = '2' and me_name !='' order by `me_order`  ";
	$result = sql_query($sql);

    $str = "<select id=\"$name\" name=\"$name\" multiple $event>\n";
    for ($i=0; $row=sql_fetch_array($result); $i++) {		
		$str .= option_multiple_selected_my($row['me_name'], $selected, $row['me_name']);	
    }
    $str .= "</select>";
    return $str;
}
?>

<section class="mybox">
	
	<form name="fmenu_default_open" id="fmenu_default_open" method="post" action="<?=G5_ADMIN_URL?>/my/menu_default_open_update.php">
		<input type="hidden" name="callback_url" value="<?=G5_ADMIN_URL?>/menu_list.php">
		<div style="display:flex;align-items:center;">
			<b class="mr20">상시 열림 메뉴</b>
			<?=get_open_menu_multiple_select('cf_open_menu[]', $config['cf_open_menu'], 'class="selectpicker" title="상시열림으로 설정할 메뉴를 선택하세요." ')?>
			<button type="submit" name="button" value="확인" class="btn btn_02 ml5">저장</button>
		</div>
	</form>

	<div class="local_desc01 local_desc">
		<p>
			<strong>주의!</strong> 메뉴설정 작업 후 반드시 <strong>확인</strong>을 누르셔야 저장됩니다.	
		</p>
	</div>	

	<p class="help-block mt20 mb10" style="line-height:1.6em;">
		※ 링크 입력 방법 - <b>URL, 게시판table명&sca=카테고리명&gr=그룹명, 엘럿메시지</b><br/>
		<span>예시1 - basic&sca=분류a</span>
		<span class="ml20">예시2 - basic&gr=갤러리</span>
		<span class="ml20">예시4 - 준비중입니다.</span>
		<span class="ml20">예시5 - http://~</span>
	</p>

	<form name="fmenulist" id="fmenulist" method="post" action="<?=G5_ADMIN_URL?>/my/menu_list_update.php" onsubmit="return fmenulist_submit(this);">
	<input type="hidden" name="token" value="">

	<?php include_once(G5_ADMIN_PATH.'/my/menu.php') ?>

	<div class="btn_fixed_top">
		<button type="button" onclick="return add_menu();" class="btn btn_02">메뉴추가<span class="sound_only"> 새창</span></button>
		<input type="submit" name="act_button" value="확인" class="btn_submit btn ">
	</div>

	</form>
	
	<script>
	function fmenulist_submit(f) {
		var me_links = document.getElementsByName('me_link[]');
		var reg = /^javascript/; 
		for (i=0; i<me_links.length; i++) {
			if( reg.test(me_links[i].value) ) {         
				alert('링크에 자바스크립트문을 입력할수 없습니다.');
				me_links[i].focus();
				return false;
			}
		}
		return true;
	}
	</script>
</section>




<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>

<?php
include_once('./_common.php');

// 테마에 myaddress.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_myaddress_file = file_exists(G5_THEME_MSHOP_PATH.'/myaddress.php') ? G5_THEME_MSHOP_PATH.'/myaddress.php' : G5_THEME_SHOP_PATH.'/myaddress.php';
    if(is_file($theme_myaddress_file)) {
        include_once($theme_myaddress_file);
        return;
        unset($theme_myaddress_file);
    }
}

$g5['title'] = "배송지 관리";
$head_title = '배송지 관리';
$topMenu_skip = true;
$head_back_url = G5_SHOP_URL.'/mypage.php';
include_once(G5_MSHOP_PATH.'/_head.php');
?>

<div id="myaddress">

	<ul class="myaddress_ul">
		<?php for($i=0; $row=sql_fetch_array($myad_result); $i++) { ?>
		<li class="li_addr">
			<div class="addr_hd">
				<?php if($row['ad_subject']) echo '<span class="add_subject">'.$row['ad_subject'].'</span>'; ?>
				<span class="add_name"><?=get_text($row['ad_name'])?></span>
				<?php if($row['ad_default']) echo '<div class="tag">기본배송지</div>'; ?>
			</div>
			<div class="addr_addr"><?php echo print_address($row['ad_addr1'], $row['ad_addr2'], $row['ad_addr3'], $row['ad_jibeon']); ?></div>
			<div class="addr_tel"><?php echo $row['ad_hp']; ?></div>
			<div class="addr_btnSet">
				<a href="<?=$update_url?>?w=u&amp;ad_id=<?php echo $row['ad_id']; ?>" class="_btn/mini">수정</a>
				<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?w=d&amp;ad_id=<?php echo $row['ad_id']; ?>" id="btn_del" class="del_address _btn/mini/red/line">삭제</a>
			</div>
		</li>
		<?php
		}
		if(!sql_num_rows($myad_result)) echo '<li class="p15 py30 tcenter color-gray">배송지 목록 자료가 없습니다.</li>';
		?>
	</ul>

    <div class="flex flex-middle gap15 mt20">
		<a href="<?=$update_url?>" type="submit" class="btn_submit _btn/lg/line flex1">+ 배송지 추가</a>
    </div>
</div>

<?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $(".del_address").on("click", function() {
        return confirm("배송지 목록을 삭제하시겠습니까?");
    });
});
</script>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
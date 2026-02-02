<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH') && $theme_type=='shop') {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/tail.php');
    return;
}


		echo '</div>'; //end - #container
	echo '</div>'; //end - #container_wr
	
	$ft_background = explode("|", $footer['ft_background']);
	echo '<footer id="footer" class="footer'.($footer['ft_inc']?' inc':'').'" style="'.(!$footer['ft_inc'] && $ft_background[0]?'--footer-background:'.$ft_background[0].';':'').(!$footer['ft_inc'] && $ft_background[1]?'--footer-color:'.$ft_background[1].';':'').'">';
	if($footer['ft_inc']) {
		$is_footer = file_exists(G5_THIS_PATH.'/footer.php');
		if($is_footer) include_once(G5_THIS_PATH.'/footer.php');
		$footerOn = $is_footer ? 'htmlOn' : '';
	} else {
		echo '<div class="footer-container">';
		if($footer['copyright']) echo '<div class="copyright">'.$footer['copyright'].'</div>';
		echo '</div>';
	}
	echo '<div id="footer-iconSet">';
	if($is_admin == 'super' && defined("_INDEX_")) echo '<span class="icon_includeInfo '.$footerOn.'" data-tip="popup/html/footer.php"><span></span></span>';
	//if ($adminIP && !$is_member) {
	if (!$is_member) {
		if($config['cf_use_login_popup']) {
			echo '<a href="'.G5_BBS_URL.'/ajax.login.php" class="icon_login popup-ajax" data-tip="로그인" alt="로그인">로그인<span></span></a>';
		} else {
			echo '<a href="'.G5_BBS_URL.'/login.php" class="icon_login" data-tip="로그인" alt="로그인">로그인<span></span></a>';
		}
	}				
	echo '</div>';
	echo '</footer>';

echo '</div>'; //end - #wrapper

include_once(G5_BBS_PATH.'/my/pop-hd-search-set.php'); //사이트 검색(일반 팝업)
?>

<button type="button" id="_gototop" class="hidden" <?php if($is_quickNews && !G5_IS_MOBILE) echo 'style="margin-right:50px;"';?>><span class="sound_only">상단으로</span></button>
<script>
$(window).scroll(function() {
	if( $(this).scrollTop() >= 1200 ) {
		$("#_gototop").removeClass('hidden');
	} else {
		$("#_gototop").addClass('hidden');
	}
});
$(function() {
	$("#_gototop").on("click", function() {
		$("html, body").animate({scrollTop:0}, '500');
		return false;
	});
});
</script>


<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) echo $config['cf_analytics'];

if($myStyle) echo '<style name="myStyle">'.$myStyle.'</style>'.PHP_EOL;
if($myScript) echo '<script name="myScript">'.$myScript.'</script>'.PHP_EOL;

// ─────────────────────────────────────────────────────────────────────
if($is_includers) include_once(G5_BBS_PATH.'/my/_includers.php'); //참조 파일 리스트 출력
// ─────────────────────────────────────────────────────────────────────
?>

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
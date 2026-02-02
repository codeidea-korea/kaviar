<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
	</div><!-- container End -->

	<?php
	if(!$footer_skip) {
		$shop_ft_background = explode("|", $footer['shop_ft_background']);
		echo '<footer id="footer" class="'.($footer['shop_ft_inc']?'inc':'').'" style="'.(!$footer['shop_ft_inc'] && $shop_ft_background[0]?'--footer-background:'.$shop_ft_background[0].';':'').(!$footer['shop_ft_inc'] && $shop_ft_background[1]?'--footer-color:'.$shop_ft_background[1].';':'').'">';
		
		if($footer['shop_ft_inc']) {
			$is_shop_footer = file_exists(G5_THIS_PATH.'/shop_footer.php');
			if($is_shop_footer) include_once(G5_THIS_PATH.'/shop_footer.php');
		} else {
			echo '<div class="footerContainer">';
			if($footer['shop_copyright']) echo '<div class="copyright">'.$footer['shop_copyright'].'</div>';
			$shop_footer_menu = '';
			for($i=1; $i<=5; $i++) {
				$footer_menu[$i] = explode('|', $footer['footer_menu'.$i]);
				if($footer_menu[$i][0]) {
					if($i > 1) $shop_footer_menu .= '<span class="division"></span>';
					$shop_footer_menu .= '<li><a href="'.($footer_menu[$i][1]?$footer_menu[$i][1]:'#').'">'.$footer_menu[$i][0].'</a></li>';
				}
			}
			if($shop_footer_menu) echo '<ul id="shop_footer_menu">'.$shop_footer_menu.'</ul>';
			echo '</div>';
		}

		if($is_admin && !defined('_ITEM_') && !$bo_table) echo '<a href="'.$_adm_url.'/?pn=_shop_footer_setting&title=쇼핑몰 카피라이트 관리" class="btnSetting popWin" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#footer">쇼핑몰 카피라이트</a>';
		echo '</footer>';
	}
	
	if(!get_shop_bottom_tabs()) $bottomTabMenu_skip = true;
	if(!$bottomTabMenu_skip) $bottomSpace_height = $bottomTabMenu_height;
	//if($bottomSpace_height) echo '<div id="bottomSpace" style="height:'.$bottomSpace_height.'px;"></div>';
	?>
	


</div><!-- wrapper End -->


</div><!-- root End -->

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
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<script src="<?php echo G5_THEME_JS_URL ?>/css3-animate-it.js"></script>
<!--<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/animate.css">-->

<?php

if($myStyle) echo '<style name="myStyle">'.$myStyle.'</style>'.PHP_EOL;
if($myScript) echo '<script name="myScript">'.$myScript.'</script>'.PHP_EOL;

// ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────
if($is_includers) include_once(G5_BBS_PATH.'/my/_includers_shop.php'); //참조 파일 리스트 출력
// ─────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────────
?>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>

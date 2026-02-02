<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$bl_id_list = '<li class="swiper-slide"><a href="'.shop_short_url_my('page', 'setmenu1').'" class="'.($pn_id=='setmenu1'?'active':'').'">오직캐비아몰</a></li>';
$bl_id_list .= '<li class="swiper-slide"><a href="'.shop_short_url_my('page', 'setmenu2').'" class="'.($pn_id=='setmenu2'?'active':'').'">인기급상승</a></li>';
$bl_id_list .= '<li class="swiper-slide"><a href="'.shop_short_url_my('page', 'setmenu3').'" class="'.($pn_id=='setmenu3'?'active':'').'">직원꿀조합</a></li>';
$bl_id_list .= '<li class="swiper-slide"><a href="'.shop_short_url_my('page', 'setmenu4').'" class="'.($pn_id=='setmenu4'?'active':'').'">후기많은</a></li>';
$bl_id_list .= '<li class="swiper-slide"><a href="'.shop_short_url_my('page', 'setmenu5').'" class="'.($pn_id=='setmenu5'?'active':'').'">캐비아추천</a></li>';
?>

<style>
<?php if(!G5_IS_MOBILE) { ?>
#bl_id_<?=$bl_id?>{display:flex;align-items:center;justify-content:center;}
#bl_id_<?=$bl_id?> ul{width:100%;max-width:960px;height:70px;padding:0 50px;border-radius: 10px;border: 1px solid #BFB6AE;display:flex;align-items:center;justify-content:center;justify-content:space-between;}
#bl_id_<?=$bl_id?> ul li{font-size:14px;width:auto !important;height:auto !important;}
#bl_id_<?=$bl_id?> ul .active{font-weight:600;color:var(--mainColor);}
<?php } else { ?>
#section-<?=$bl_id?> .inner{height:auto;}
#bl_id_<?=$bl_id?>{padding:0 !important;}
#bl_id_<?=$bl_id?> .mySwiper{}
#bl_id_<?=$bl_id?> ul{display:flex;}
#bl_id_<?=$bl_id?> ul li{font-size:14px;width:auto !important;height:auto !important;}
#bl_id_<?=$bl_id?> ul li a{display:inline-flex;align-items:center;justify-content:center;flex-direction:column;gap:5px;}
#bl_id_<?=$bl_id?> ul li a:before{content:'';display:inline-flex;width:68px;height:68px;}
#bl_id_<?=$bl_id?> ul .active{font-weight:600;color:var(--mainColor);}
#bl_id_<?=$bl_id?> ul li:nth-child(1) a:before{background:url('<?=$html_img_url?>/icon01.png') no-repeat center / 100%;}
#bl_id_<?=$bl_id?> ul li:nth-child(2) a:before{background:url('<?=$html_img_url?>/icon02.png') no-repeat center / 100%;}
#bl_id_<?=$bl_id?> ul li:nth-child(3) a:before{background:url('<?=$html_img_url?>/icon03.png') no-repeat center / 100%;}
#bl_id_<?=$bl_id?> ul li:nth-child(4) a:before{background:url('<?=$html_img_url?>/icon04.png') no-repeat center / 100%;}
#bl_id_<?=$bl_id?> ul li:nth-child(5) a:before{background:url('<?=$html_img_url?>/icon05.png') no-repeat center / 100%;}
<?php } ?>
</style>

<?php if(!G5_IS_MOBILE) {
	echo '<div id="bl_id_'.$bl_id.'" class="_sectionContainer">';
			echo '<ul>';
				echo $bl_id_list;
			echo '</ul>';
	echo '</div>';
} else {
	echo '<div id="bl_id_'.$bl_id.'" class="_sectionContainer mySwiper" data-per="4" data-gap="25" data-loop="false">';
		echo '<div class="swiper-container">';
			echo '<ul class="swiper-wrapper">';
				echo $bl_id_list;
			echo '</ul>';
		echo '</div>';
	echo '</div>';
}
?>
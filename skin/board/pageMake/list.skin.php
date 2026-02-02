<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
//include_once(G5_LIB_PATH.'/my/latest.category.lib.php');
include_once($board_skin_path.'/lib/pagemake.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/'.$css).'">', 3);
if(!G5_IS_MOBILE) {
	add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/mix-type/mix-style.css').'">', 3);
} else {
	add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/mix-type/mix-style-mobile.css').'">', 3);
}
add_javascript('<script src="'.get_url($board_skin_url.'/js/pagemake.js').'"></script>', 6);

$style_path = G5_HTML_PATH.'/'.$board['bo_table'].'/style.css';	
if(file_exists($style_path)) add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_HTML_URL.'/'.$board['bo_table'].'/style.css').'">', 4);
?>

<?php if($pageMakeStyle) echo '<style name="pageMake">'.$pageMakeStyle.'</style>'; ?>

<?=$pagemake_tabmenu_top?>

<?php $tabmenu_padding_bottom = G5_IS_MOBILE ? 'var(--tabmenu-height);' : 'calc(var(--tabmenu-height) + 18px);'; ?>
<div id="pageMake-form-area" style="<?=$pagemake_tabmenu_floating?'padding-bottom:'.$tabmenu_padding_bottom:''?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="sw" value="">



<div id="pageMake" >

	<?php for ($i=0; $i<count($list); $i++) {

		$bl_text_align[$i] = explode("|", $list[$i]['bl_text_align']);
		$bl_text_align[$i][1] = $bl_layout[$i] == 'layout-lt' || $bl_layout[$i] == 'layout-rt' ? $bl_text_align[$i][1] : '';

		if($wr_use[$i]) {
			//article(100%이하블럭)끼리 묶기
			$block_html_tag[$i] = $list[$i]['bl_width'] && $list[$i]['bl_width'] < 100 ? 'article' : 'section';			
			if($block_html_tag[$i - 1] == 'article' && $block_html_tag[$i] != 'article') echo '</div></section>';
			if($block_html_tag[$i] == 'article' && ($block_html_tag[$i - 1] == 'section' || !$block_html_tag[$i - 1])) echo '<section class="blockSet"><div class="inner">';			

			$blockClass[$i] = '';
			if($list[$i]['bl_width'] && $list[$i]['bl_width'] < 100) {
				if($list[$i]['bl_width'] <= 25) $blockClass[$i] = ' piece-4';				
				if($list[$i]['bl_width'] > 25 && $list[$i]['bl_width'] < 40) $blockClass[$i] = ' piece-3';
				if($list[$i]['bl_width'] >= 40 && $list[$i]['bl_width'] <= 60) $blockClass[$i] = ' piece-2';
				if($list[$i]['bl_width'] > 60 && $list[$i]['bl_width'] < 75) $blockClass[$i] = ' piece-3-2';
				if($list[$i]['bl_width'] >= 75) $blockClass[$i] = ' piece-4-3';
			}
			if($bl_layout[$i]=='layout-bg' || $bl_layout[$i]=='layout-bigBanner') {
				if(!G5_IS_MOBILE && !$list[$i]['bl_height']) $blockClass[$i] .= ' height-fixed';
				if(G5_IS_MOBILE && !$list[$i]['bl_height_mobile']) $blockClass[$i] .= ' height-fixed';
			}			
			if($bl_layout[0]=='layout-bg') $blockClass[0] .= ' top-visual';

			echo '<'.$block_html_tag[$i].' id="'.$blockName[$i].'" class="blockContainer'.$blockClass[$i].'"'.($list[$i]['bl_background']?' style="background-color:'.$list[$i]['bl_background'].';"':'').' data-option="'.$latestOption[$i].'"'.($list[$i]['wr_subject'] == 'layout-mix'?' data-mix-type="'.$list[$i]['mix_type'].'"':'').'>'.PHP_EOL;

			if($is_admin && !defined('_INDEX_')) {				
				if($bl_layout[$i] == 'layout-mix') {
					echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_mix_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=믹스형 블럭 편집" class="blockSetting popWin" data-width="1650" data-height="960" data-top="0" data-left="0" data-area="#'.$blockName[$i].' .blockInner">블럭 편집</a>';
				} else if($bl_layout[$i] == 'layout-bigBanner') {
					echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_bigBanner_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=빅배너 블럭관리" class="blockSetting popWin" data-width="1100" data-height="350" data-top="0" data-left="0" data-area="#'.$blockName[$i].' .blockInner">블럭 편집</a>';
				} else if($bl_layout[$i] == 'layout-bg') {
					echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_bg_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=배경이미지형 블럭 관리" class="blockSetting popWin" data-width="1650" data-height="700" data-top="60" data-left="0" data-area="#'.$blockName[$i].' .blockInner">블럭 편집</a>';
				} else {
					echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=블럭편집" class="blockSetting popWin" data-width="1450" data-height="700" data-top="60" data-left="0" data-area="#'.$blockName[$i].' .blockInner">블럭 편집</a>';
				}
				if(!G5_IS_MOBILE) echo '<label class="labelCheck edit-mode data-area" data-area="#'.$blockName[$i].' .blockInner"><input type="checkbox" name="chk_wr_id[]" value="'.$list[$i]['wr_id'].'" id="chk_wr_id_'.$i.'"><i class="sound_only">'.$list[$i]['subject'].'</i></label>';
			}

			echo get_include_html($list[$i]['wr_id'], '_top'); //블럭 상단 인크루드
			
			if($latestContainer[$i]) $inc_latest[$i] = 'inc_latest';
			if($list[$i]['latest_table'] && $list[$i]['latest_skin'] && $bl_layout[$i] != 'layout-mix') $latestSkin[$i] = $latest_skin[$i];
			echo '<div class="blockInner '.$bl_layout[$i].' '.$latest_type[$i].' '.$inc_latest[$i].' '.$bl_text_align[$i][1].'" data-latest-skin="'.$latestSkin[$i].'">'.PHP_EOL;			

			if($bl_layout[$i] == 'layout-mix') {				
				if($list[$i]['mix_type']) {
					include($board_skin_path.'/mix-type/'.$list[$i]['mix_type'].'/mix.skin.php');
					echo '<script>$(document).ready(function() {
						$(".'.$blockName[$i].'_popup-view").magnificPopup({
							type:"ajax", fixedContentPos:true, fixedBgPos:true, closeOnContentClick:false,  closeOnBgClick:false, gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]}, overflowY:"auto", closeBtnInside:false, preloader:false, midClick:true, removalDelay:300, mainClass:"my-mfp-zoom-in"
						});
					});</script>';
				} else {
					echo '<div class="flex flex-center flex-middle tcenter fs14 bold" style="height:60px;border-radius:6px;background:#def2ff;">믹스형 타입을 편집해 주세요.</div>';
				}
			} else {
				
				//텍스트 콘텐츠
				if(($list[$i]['bl_title'] || $isContent[$i]) && $bl_layout[$i] != 'layout-bigBanner') {
					echo '<div class="textCon'.($bl_text_align[$i][0]?' '.$bl_text_align[$i][0]:'');
					if($list[$i]['wr_video'] && !$list[$i]['wr_video_play'] && $bl_layout[$i] == 'layout-bg') echo ' fadeOut" style="z-index:9;" data-duration="0.8" data-delay="3.5'; //비디오 커버색이 있을때 fadeout
					echo '">'.PHP_EOL;
					if($list[$i]['bl_title']) echo '<div class="block-title'.($list[$i]['wr_subject'] == 'layout-bg'?' scrollMotion':'').($bl_font?' '.$bl_font:'').'">'.nl2br($list[$i]['bl_title']).'</div>'.PHP_EOL;
					if($isContent[$i]) echo '<div class="contents'.($list[$i]['wr_subject'] == 'layout-bg'?' scrollMotion':'').'">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
					if($list_btn_set[$i]) echo '<div class="'.($list[$i]['wr_subject'] == 'layout-bg'?' scrollMotion':'').'">'.$list_btn_set[$i].'</div>'; //좌우미디어 일때 버튼위치
					echo '</div>';
				}
				//이미지&최신글스킨 콘텐츠
				if($imgCon[$i] || $latestContainer[$i]) {
					if($list[$i]['latest_skin'] != 'basic' || $list[$i]['wr_subject'] != 'layout-bg' || !G5_IS_MOBILE) {
						echo '<div class="mediaCon'.($bl_text_align[$i][0]?' '.$bl_text_align[$i][0]:'').'">'.PHP_EOL;
						echo '	<div class="mc-wrap">'.PHP_EOL;
						if($imgCon[$i]) echo $imgCon[$i];
						if($latestContainer[$i]) echo $latestContainer[$i];
						if($list[$i]['latest_skin'] == 'basic' && !$list[$i]['bl_title']) echo $list_btn_set[$i];
						echo '	</div>'.PHP_EOL;
						echo '</div>'.PHP_EOL;
					}
				}
				
				//백그라운드 콘텐츠
				if($backgroundCon[$i]) echo '<div class="bgContainer">'.$backgroundCon[$i].'</div>';
			}
			
			echo get_include_html($list[$i]['wr_id']); //블럭 하단 인크루드

			if(!$include_top[$i] && !$list[$i]['bl_title'] && !$isContent[$i] && !$include[$i] && !$bgImg[$i] && !$imgCon[$i] && !$latestContainer[$i] && $bl_layout[$i] != 'layout-mix' && !$backgroundCon[$i]) echo '<div class="binpage">비어있는 블럭 입니다.<br>콘텐츠를 등록해 주세요.</div>';

			echo '</div>'.PHP_EOL; //end - blockInner			
			
			
			if($is_admin && !defined('_INDEX_') && !G5_IS_MOBILE) {			
				if($list[$i]['latest_table']) {
					$sectionTip[$i] = $list[$i]['latest_table'].' <small>(게시판)</small>'; 
					if($list[$i]['latest_skin']) $sectionTip[$i] .= ' - '.$list[$i]['latest_skin'].' <small>(스킨)</small>';
					$btnTip[$i] = 'myTip useTag mini '.$includeOn[$i];
				}
				echo '<div class="layerBtn" style="'.$layerBtnMargin[$i].' z-index:50;">';
				if($include_top[$i]) $includeTip[$i] = 'section_'.$list[$i][wr_id].'_top.php';
				if($include_top[$i] && $include[$i]) $includeTip[$i] .= '&nbsp;&nbsp;&nbsp;';
				if($include[$i]) $includeTip[$i] .= 'section_'.$list[$i][wr_id].'.php';
				if($includeTip[$i] && $is_admin=='super') echo '<div class="helpTag includeTip myTip mini" data-tip="'.$includeTip[$i].'">Inc</div>';

				$btnEdit_class[$i] = $list[$i]['wr_use'] == 'admin' ? ' admin':'';
				echo '<a href="'.$edit_href[$i].'" class="'.$btnTip[$i].'" data-tag="'.$sectionTip[$i].'" data-tip="" alt="편집"><span class="btnEdit'.$btnEdit_class[$i].'">편집</span></a>';
				echo '</div>';
			}

			echo '</'.$block_html_tag[$i].'>'.PHP_EOL;		

			if($list[$i]['latest_skin'] == 'basic' && $list[$i]['wr_subject'] == 'layout-bg' && G5_IS_MOBILE) { //모바일 basic은 배경블럭과 분리
				if($latestContainer[$i]) echo '<section id="'.$blockName[$i].'-mobile" class="layout-bg-outside">'.$latestContainer[$i].'</section>';
			}

			if($block_html_tag[$i] == 'article' && $i == count($list)-1) echo '</div></section>';
		}
	} ?>

	<?php if(!defined('_INDEX_')) echo $list_bundle_form; ?>

</div>



<?php if($is_admin && !defined('_INDEX_') && !G5_IS_MOBILE) {
	if(count($list) == 0) echo '<div class="fixedCenter">'.PHP_EOL;
	echo '<div class="bo_btnSet">'.PHP_EOL;
	if($is_checkbox) {
		echo '<div class="bo_adm_set">';
		if($admin_href) echo '<a href="'.$admin_href.'" class="myTip top mini" data-tip="전체 블럭 '.number_format($total_count).'개" alt="admin"><span class="btn_admin">ADMIN</span></a>';
		if(count($list) > 0) {
			echo '<span class="btnEditMode">EDIT-MODE</span>';
			echo '<ul class="ul-edit-mode">';		
			echo '<li class="edit-mode"><label class="btnChkall"><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"><span>전체선택</span></label></li>';
			echo '<li class="edit-mode"><input type="submit" name="btn_submit" class="del" value="선택삭제" onclick="document.pressed=this.value"></li>';
			echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>';
			echo '</ul>';
		}
		echo '</div>'.PHP_EOL;
	}

	if($board['bo_category_list'] && $board['bo_use_category'] && $_GET['sca']) $write_href = $write_href.'&sca='.urlencode($sca);
	echo '<a href="'.$write_href.'" class="btn_write block" alt="블럭 추가">블럭 추가</a>'.PHP_EOL;
	echo '</div>'.PHP_EOL;

	if(count($list) == 0) echo '</div>'.PHP_EOL;
} ?>

<?=$pagemake_tabmenu_floating?>

</div>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>

<script>
$('.btnEditMode').click(function() {
	$(this).toggleClass('on');
	$('.ul-edit-mode, .edit-mode').toggleClass('on');
	if($(this).hasClass('on')) {
		$('#pageMake-form-area').wrap('<form name="fboardlist"  id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">');
	} else {
		$('#pageMake-form-area').unwrap();
	}
});

<?php if(!G5_IS_MOBILE && !defined("_INDEX_") && $is_admin) { ?>
$(window).scroll(function() {
	let winHeight = $(window).height(),
		ypos = $('.btnEditMode').offset().top - winHeight,
		xpos = $('.btnEditMode').offset().left + 76;
	if( $(this).scrollTop() < ypos ) {
		$(".ul-edit-mode").addClass('fixed').css({'left':xpos});
	} else {
		$(".ul-edit-mode").removeClass('fixed').css({'left':''});
	}
});
<?php } ?>

/*let winHeight = $(window).outerHeight(),
	headerHeight = $('#header .topSection').outerHeight(),
	fixedHeight = winHeight - headerHeight;
$('.height-fixed .blockInner').each(function() {
	if($(this).hasClass('layout-bg') || $(this).hasClass('layout-bigBanner')) {
		//$(this).css({'height':winHeight, 'overflow':'hidden'});
	} else {
		//$(this).css({'min-height':fixedHeight});
	}
});*/

<?php if($pagemake_tabmenu_floating && G5_IS_MOBILE) { ?>
let mySwiper = new Swiper( '#pagemake-tabmenu.floating', {
	slidesPerView: 'auto',
	freeMode: true
});	
if($('#pagemake-tabmenu.floating').find('.active')) {
	let i = $('.swiper-slide.active').index();
	mySwiper.slideTo(i,0,true);
}
<?php } ?>
</script>
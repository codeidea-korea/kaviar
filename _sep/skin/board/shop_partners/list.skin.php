<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/'.$css).'">', 2);
?>

<?php if(shop_banner('', '_block_banner.skin.php', 'partners')) {
	echo '<section id="bo_banner" class="relative">';
		echo shop_banner('', '_block_banner.skin.php', 'partners');
		if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=basic&bn_cate=partners&title=쇼핑몰 배너관리" class="edit-block btnSetting popWin" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#bo_banner">쇼핑몰 배너관리</a>';
	echo '</section>';
}?>
<?php// if($is_bo_title) echo $bo_title; ?>

<?php// if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?>

<div class="bo_gall boContainer" style="<?=$bo_width?>">

	<?=$list_bundle_form?>

	<?=$tagsGroup?>

	<?php// if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table); ?>

	<form name="fboardlist"  id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">
	
	<?php
	for ($i=0; $i<count($list); $i++) {
		$_gall_li[$i] = '';
		$_gall_li[$i] .= '<li class="gall_li '.$skinOption_frame.($list[$i]['wr_use']?' use_'.$list[$i]['wr_use']:'').' '.$is_now[$i].'">';
			$_gall_li[$i] .= $bo_current[$i];
			$_gall_li[$i] .= $gall_li_checkbox[$i];
			$_gall_li[$i] .= $icon_use[$i];
			$_gall_li[$i] .= '<div class="gallContents">';
				//$_gall_li[$i] .= $list[$i]['ca_name'];
				if($img[$i]) {
					if($list[$i]['ca_name'] == "셰프관" && $is_mobile){
						$_gall_li[$i] .= '<div class="gall_thumb" style="width:75%;margin-bottom:30px;">';
					}else{
						$_gall_li[$i] .= '<div class="gall_thumb">';
					}
					
						$_gall_li[$i] .= $a_link_img[$i];
						$_gall_li[$i] .= $img[$i];
						if($a_link_img[$i]) $_gall_li[$i] .= '</a>';
					$_gall_li[$i] .= '</div>';
				}				
			$_gall_li[$i] .= '</div>';
			if($edit_href[$i]) {
				$_gall_li[$i] .= '<div class="layerBtn">';
					$_gall_li[$i] .= '<a href="'.$edit_href[$i].'" class="myTip mini '.$includeOn[$i].'" data-tip="section_'.$list[$i]['wr_id'].'"><span class="btnEdit '.$btnEdit_class[$i].'">수정</span></a>';
				$_gall_li[$i] .= '</div>';
			}
		$_gall_li[$i] .= '</li>';
	}
	
	if($board['bo_use_category']) {
		$category = explode('|', $board['bo_category_list']);			
		for ($j=0; $j<count($category); $j++) {
			echo '<section class="sec">';
			
				echo '<div class="_ca_name" style="font-weight:bold;margin-bottom:20px">'.$category[$j].'</div>';
			
				
				echo '<ul class="gall_ul" data-cate="'.$category[$j].'">';
					for ($i=0; $i<count($list); $i++) {
						if($category[$j] == $list[$i]['ca_name']) {
							echo $_gall_li[$i];
						}
					}
					if(count($list) == 0) echo '<li class="empty_list" data-text="게시물이 없습니다."></li>';
				echo '</ul>';
			echo '</section>';
		}		
		for ($i=0; $i<count($list); $i++) {
			if($list[$i]['ca_name'] == '') {
				$no_cate_gall_li .= $_gall_li[$i];
			}
		}
		if($no_cate_gall_li) echo '<ul class="gall_ul" style="padding:15px;background:rgba(0,0,0,0.01);border-radius:6px;">'.$no_cate_gall_li.'</ul>';
	} else {
		echo '<ul class="gall_ul">';
			for ($i=0; $i<count($list); $i++) {
				echo $_gall_li[$i];
			}
			if(count($list) == 0) echo '<li class="empty_list" data-text="게시물이 없습니다."></li>';
		echo '</ul>';
	}
	?>

	<?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

	</form>

	<?=$write_pages?>

</div>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>
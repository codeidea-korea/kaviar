<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//if($board['bo_layer_popup']) goto_url(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;pop_id='.$wr_id);

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_pcskin_url.'/'.$css).'">', 3);
?>

<style>
.boWrap{--bo-mobile-padding:0 !important;}
</style>

<article id="bo_v" style="<?php if(!G5_IS_MOBILE) echo $bo_width; ?>">
	
	<?php if(shop_banner('', '_block_banner.skin.php', 'partners') && !G5_IS_MOBILE) {
		echo '<section id="bo_banner" class="relative">';
			echo shop_banner('', '_block_banner.skin.php', 'partners');
			if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=basic&bn_cate=partners&title=쇼핑몰 배너관리" class="edit-block btnSetting popWin" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#bo_banner">쇼핑몰 배너관리</a>';
		echo '</section>';
	}?>
	
	<?php if(!G5_IS_MOBILE) echo $fileDownload; //첨부파일?>	

    <section id="bo_v_atc">	

		<?=$bo_v_linkSet; //첨부된 링크?>

        <?php
		if($view['wr_video']) { //저장된 동영상 코드가 있다면
			echo '<section id="bo_v_video">';
			if($video_type == 'mp4') {
				if( !preg_match('/http(s?)\:\/\//i', $view['wr_video']) ) $view['wr_video'] = G5_URL.$view['wr_video'];
				echo '<div class="video-container play-btn"><video src="'.$view['wr_video'].'" controls class="video"></video></div>';
			} else if($video_type == 'youtube') {
				echo '<iframe src="https://www.youtube.com/embed/'.$view['wr_video'].'?amp;controls=2&amp;showinfo=1&autoplay=0&modestbranding=1" frameborder="0" class="video" allowfullscreen title="'.$view['wr_subject'].'"></iframe>';
			} else if($video_type == 'vimeo') {
				echo '<iframe src="https://player.vimeo.com/video/'.$view['wr_video'].'?autoplay=0" frameborder="0" class="video" webkitallowfullscreen mozallowfullscreen allowfullscreen title="'.$view['wr_subject'].'"></iframe>';
			}
			echo '</section>';
		}

		if($board['bo_view_thumb']) { //뷰페이지 이미지 사용
			if(strpos($boSkin, 'gallery') !== false) { //갤러리 스킨은 pc, 모바일 구분
				if(G5_IS_MOBILE && $view['file'][1]['view']){
					echo '<div class="bo_v_img">'.get_file_thumbnail($view['file'][1]).'</div>';
				} else if($view['file'][0]['view']) {
					echo '<div class="bo_v_img">'.get_file_thumbnail($view['file'][0]).'</div>';
				}
			} else {
				$v_img_count = count($view['file']);
				if($v_img_count) {
					for ($i=0; $i<=count($view['file']); $i++) {
						if ($view['file'][$i]['view']) {
							//echo $view['file'][$i]['view'];
							echo '<div class="bo_v_img">'.get_file_thumbnail($view['file'][$i]).'</div>';
						}
					}
				}
			}
		}
        ?>
		
		<?=get_include_html($view['wr_id'])?>

        <?php if($isContent) { ?>
        <div id="bo_v_con">
			<?php
			//echo stripslashes($view['wr_content']);
			echo get_view_thumbnail($view['content']);
			//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우
			?>
		</div>
        <?php } ?>

		<?=$view_btn_set?>
		
		<?php if(G5_IS_MOBILE) echo $fileDownload; //첨부파일 ?>

		<?//=$bo_v_info //작성자 및 게시물 정보?>

		<?=$view_tag_set?>

		<?php include_once(G5_SNS_PATH."/view.sns.skin.php"); ?>
		
		<?php if($view['wr_store_id']) {
			echo '<div id="_store_item_list">';			
				$skin = 'list.10.skin.php';
				$list_mod = G5_IS_MOBILE ? 2:4; //가로수
				$list_row = 5; //줄수

				$items = $list_mod * $list_row;
				if ($page < 1) $page = 1;
				$from_record = ($page - 1) * $items;

				$list = new item_list(G5_SHOP_SKIN_PATH.'/'.$skin, $list_mod, $list_row , 230, 230);
				$list->set_store($view['wr_store_id']);	
				$list->set_is_page(true);
				$list->set_mobile(true);
				$list->set_category($ca_id, 1);
				$list->set_category($ca_id, 2);
				$list->set_category($ca_id, 3);
				$list->set_order_by($order_by);
				$list->set_from_record($from_record);
				$list->set_view('it_img', true);
				$list->set_view('it_id', false);
				$list->set_view('it_name', true);
				$list->set_view('it_cust_price', false);
				$list->set_view('it_price', true);
				$list->set_view('it_icon', true);
				$list->set_view('sns', true);
				echo $list->run();

				// where 된 전체 상품수
				$total_count = $list->total_count;
				// 전체 페이지 계산
				$total_page  = ceil($total_count / $items);

				$qstr .= 'bo_table='.$bo_table.'&amp;wr_id='.$view['wr_id'];
				echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");			
			echo '</div>';
		} ?>

    </section>

	<?php if($bo_comment) include_once(G5_BBS_PATH.'/view_comment.php'); // 코멘트 입출력 ?>
	
	<?php include_once(G5_BBS_PATH.'/my/view_btnSet.php'); ?>

</article>
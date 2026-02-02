<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$is_pagemake_cate = false;
$pagemake_cate = '';
if ($board['bo_use_category']) {
    $is_pagemake_cate = true;
	$pagemake_cate_href = G5_BBS_URL.'/my/_adm/?pn=_list_bundle&bo_table='.$bo_table.'&title='.$title;
	$pagemake_cate .= '<div class="boCate">';
	$pagemake_cate .= '<ul>';    
    $pagemake_categories = explode('|', $board['bo_category_list']);
    for ($i=0; $i<count($pagemake_categories); $i++) {
        $pagemake_category = trim($pagemake_categories[$i]);
        if ($pagemake_category=='') continue;
        $pagemake_cate .= '<li><a href="'.$pagemake_cate_href.'&sca='.urlencode($pagemake_category).'"';
        if ($pagemake_category==$sca) {
            $pagemake_cate .= ' class="active"';
        }
        $pagemake_cate .= '>'.$pagemake_category.'</a></li>';
    }
	$pagemake_cate .= '<li><a href="'.$pagemake_cate_href.'&sca=none" class="'.($sca=='none'?'active':'').'">분류없음</a></li>';
	$pagemake_cate .= '</ul>';
	$pagemake_cate .= '</div>';
}
?>

<form name="_adm_form" id="_adm_form" action="<?=G5_BBS_URL?>/my/_adm/_list_bundle_update.php" onsubmit="return _adm_form_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type='hidden' name='chk' value='<?=count($list)?>'>
<input type='hidden' name='sca' value='<?=urlencode($sca)?>'>
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<?=$pagemake_cate?>

<ul class="frm_bl_ul" id="sortable">
	
	<?php for ($i=0; $i<count($list); $i++) {
		$img_thumb[$i] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 0, 50, false, true);
		if($list[$i]['bl_width'] && $list[$i]['bl_width'] < 100) {
			if($list[$i]['bl_width'] <= 25) $list_row[$i] = 'piece-4';				
			if($list[$i]['bl_width'] > 25 && $list[$i]['bl_width'] < 40) $list_row[$i] = 'piece-3';
			if($list[$i]['bl_width'] >= 40 && $list[$i]['bl_width'] <= 60) $list_row[$i] = 'piece-2';
			if($list[$i]['bl_width'] > 60 && $list[$i]['bl_width'] < 75) $list_row[$i] = 'piece-3-2';
			if($list[$i]['bl_width'] >= 75) $list_row[$i] = 'piece-4-3';
		}
		?>	
	<li class="<?=$list[$i]['wr_use']=='none'?'no-use':''?> <?=$list_row[$i]?>" data-wr-id="<?=$list[$i]['wr_id']?>">
		<div class="list_inner">
			<span class="wr_use_tag <?=$list[$i]['wr_use']?>"></span>
			<input type='hidden' name='wr_id_up[<?=$i?>]' value='<?php echo $list[$i]['wr_id'] ?>'>

			<div class="flex flex-middle">
				<input type="text" name="wr_order[<?=$i?>]" value="<?php if($list[$i]['wr_order']) echo $list[$i]['wr_order'];?>" id="wr_order[<?=$i?>]" class="wr_order tcenter" placeholder="">
				<select name="wr_use[<?=$i?>]" value="<?=$list[$i]['wr_use']?>" id="wr_use[<?=$i?>]" class="wr_use selectpicker" data-wr-id="<?=$list[$i]['wr_id']?>" data-style="<?=$list[$i]['wr_use']=='none'?'selectColor-lightGray':'selectColor-gray'?>">
					<?php					
					echo option_selected_my("",  $list[$i]['wr_use'], "전체 공개", "data-content='<span class=\"icon_check\">전체 공개</span>'");
					echo option_selected_my("none",  $list[$i]['wr_use'], "비공개", "data-content='<span class=\"icon_lock\">비공개</span>'");
					echo option_selected_my("pc",  $list[$i]['wr_use'], "PC 전용", "data-content='<span class=\"icon_pc\">PC 전용</span>'");
					echo option_selected_my("mobile",  $list[$i]['wr_use'], "MOBILE 전용", "data-content='<span class=\"icon_mobile\">MOBILE 전용</span>'");
					echo option_selected_my("admin",  $list[$i]['wr_use'], "관리자 확인용", "data-content='<span class=\"icon_admin\">관리자 확인용</span>'");
					?>
				</select>
				<?php if($list[$i]['bl_name']) echo '<span class="bl_name bold ml20">'.$list[$i]['bl_name'].'</span>';?>
				<?php if ($board['bo_use_category']) {
					$category_option = get_category_option($bo_table, $list[$i]['ca_name'], $is_notice=false);
					echo '<span style="margin-left:auto;margin-right:25px;">';
					echo '<select name="ca_name['.$i.']" id="ca_name['.$i.']" class="ca_name selectpicker" data-wr-id="'.$list[$i]['wr_id'].'">';
					echo option_selected("",  $list[$i]['ca_name'], "- 분류 없음 -");
					echo $category_option;
					echo '</select>';
					echo '</span>';
				} ?>
			</div>			

			<div class="flex flex-middle gap20 mt10">
				<?php
				if($list[$i]['wr_subject'] == 'layout-basic') $layout_name[$i] = '기본형';
				if($list[$i]['wr_subject'] == 'layout-lt') $layout_name[$i] = '좌미디어형';
				if($list[$i]['wr_subject'] == 'layout-rt') $layout_name[$i] = '우미디어형';
				if($list[$i]['wr_subject'] == 'layout-bottom') $layout_name[$i] = '하단미디어형';
				if($list[$i]['wr_subject'] == 'layout-bg') $layout_name[$i] = '배경이미지형';
				if($list[$i]['wr_subject'] == 'layout-mix') $layout_name[$i] = '믹스 입력형';
				echo '<div class="bl_layout gap8">';
				echo "<img src='".get_url($board_skin_url."/img/".$list[$i]['wr_subject'].".gif")."' alt='".$layout_name[$i]."'>";
				

				if($list[$i]['wr_subject'] == 'layout-mix' && $list[$i]['mix_type']) {
					echo "<img src='".get_url($board_skin_url."/mix-type/".$list[$i]['mix_type']."/thumb.gif")."' alt='".$list[$i]['mix_type']."'>";
					echo '<span class="mix_type_name">'.$list[$i]['mix_type'].'</span>';
				}

				if($list[$i]['latest_table'] && $list[$i]['latest_skin'] && $list[$i]['wr_subject'] != 'layout-mix' && $list[$i]['wr_subject'] != 'layout-bg' && $list[$i]['wr_subject'] != 'layout-bigBanner') {
					echo '<div class="span120">';
					$latest_skin_url = G5_URL.'/skin/latest/'.$list[$i]['latest_skin'];
					echo "<img src='".get_url($latest_skin_url."/thumb.png")."' alt='".$layout_name[$i]."'>";
					echo '</div>';
				}

				if($img_thumb[$i]) echo '<img src="'.$img_thumb[$i]['src'].'" class="img_thumb">';
				echo '</div>';
				
				if($list[$i]['wr_subject'] != 'layout-mix') {						
					if($list[$i]['latest_table']) {							
						if($list[$i]['latest_type']) {
							echo '<div class="skin_type">';
							$latest_skin_url = G5_URL.'/skin/latest/'.$list[$i]['latest_skin'];
							echo "<img src='".get_url($latest_skin_url."/img/".$list[$i]['latest_type'].".gif")."' alt='".$layout_name[$i]."'>";
							echo '</div>';								
						}
						if($list[$i]['latest_list_style']) {
							echo '<div class="skin_type">';
							if($list[$i]['latest_list_style'] == 'list-style1') $layout_name[$i] = '라인';
							if($list[$i]['latest_list_style'] == 'list-style2') $layout_name[$i] = '심플';
							echo "<img src='".get_url($board_skin_url."/img/".$list[$i]['latest_list_style'].".gif")."' alt='".$layout_name[$i]."'>";
							echo '</div>';
						}
						
						echo '<div class="latest-info">';
						if($list[$i]['latest_table'] != 'SQUARE') {
							echo '<div class="flex flex-middle gap5">';
							echo '<span class="label">불러오기</span>';
							if($list[$i]['latest_order_option']=='list_of_select') {
								$sel_li_id[$i] = explode(",",$list[$i]['latest_sel_li_id']);							
								echo '<span class="count">'.count($sel_li_id[$i]).'개</span>';							
							} else {
								$mobile_count[$i] = $list[$i]['latest_mobile_count'] ? ' ('.$list[$i]['latest_mobile_count'].')' : '';
								echo '<span class="count">'.$list[$i]['latest_count'].$mobile_count[$i].'개</span>';
							}
							echo '</div>';
							$latest[$i] = sql_fetch(" select bo_subject from {$g5['board_table']} where bo_table = '{$list[$i]['latest_table']}' ");
							$latest_subject[$i] = get_text($latest[$i]['bo_subject']);
							echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$list[$i]['latest_table'].'" target="_blank" title="'.$list[$i]['latest_table'].' 바로가기">'.$latest_subject[$i].'<span class="tablename">('.$list[$i]['latest_table'].')</span></a>';						
						} else {
							echo '<span class="small-tag green">SQUARE</span>';
						}
						echo '</div>';
					}
				}
				?>
			</div>
			
			<?php
			$htmlPATH = G5_POPUP_PATH.'/html/'.$bo_table;
			$includeFilePATH = $htmlPATH.'/section_'.$list[$i][wr_id].'.php';
			$imgURL = G5_POPUP_URL.'/html/'.$bo_table.'/img';
			$htmlURL = G5_POPUP_URL.'/html/'.$bo_table;
			$includeFileURL = $htmlURL.'/section_'.$list[$i][wr_id].'.php';
			$includeFilePATH_top = $htmlPATH.'/section_'.$list[$i][wr_id].'_top.php';
			$is_html_top = file_exists($includeFilePATH_top);
			$is_html = file_exists($includeFilePATH);
			if($is_html || $is_html_top) {
				$includeOn[$i] = 'includeOn';
			} else {
				$includeOn[$i] = '';
			}
			$sectionTip = 'section_'.$list[$i][wr_id].'.php';
			//echo '<a href="'.G5_BBS_URL.'/write.php?&w=u&bo_table='.$bo_table.'&wr_id='.$list[$i][wr_id].'" target="_blank" class="includeTip" data-tip="'.$sectionTip.'" alt="편집"><span class="btnEdit '.$includeOn[$i].'">편집</span></a>';

			if($list[$i]['wr_subject'] == 'layout-mix') {
				echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_mix_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=믹스형 블럭 편집&callback=1" class="blockSetting">블럭 편집</a>';
			} else if($list[$i]['wr_subject'] == 'layout-bigBanner') {
				echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_bigBanner_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=빅배너 블럭관리&callback=1" class="blockSetting">블럭 편집</a>';
			} else if($list[$i]['wr_subject'] == 'layout-bg') {
				echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_bg_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=배경이미지형 블럭 관리&callback=1" class="blockSetting">블럭 편집</a>';
			} else {
				echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_form&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&title=블럭편집&callback=1" class="blockSetting">블럭 편집</a>';
			}
			?>	
			<select name="bl_width[<?=$i?>]" value="<?=$list[$i]['bl_width']?>" id="bl_width[<?=$i?>]" class="bl_width selectpicker" data-wr-id="<?=$list[$i]['wr_id']?>">
				<?php
				echo option_selected_my("",  $list[$i]['bl_width'], "piece-1", "data-content='<img src=\"".get_url($board_skin_url."/img/piece-1.gif")."\" alt=\"".$list[$i]['mix_type']."\">'");
				echo option_selected_my("50",  $list[$i]['bl_width'], "piece-2", "data-content='<img src=\"".get_url($board_skin_url."/img/piece-2.gif")."\" alt=\"".$list[$i]['mix_type']."\">'");
				echo option_selected_my("33",  $list[$i]['bl_width'], "piece-3", "data-content='<img src=\"".get_url($board_skin_url."/img/piece-3.gif")."\" alt=\"".$list[$i]['mix_type']."\">'");
				echo option_selected_my("66",  $list[$i]['bl_width'], "piece-3-2", "data-content='<img src=\"".get_url($board_skin_url."/img/piece-3-2.gif")."\" alt=\"".$list[$i]['mix_type']."\">'");
				echo option_selected_my("25",  $list[$i]['bl_width'], "piece-4", "data-content='<img src=\"".get_url($board_skin_url."/img/piece-4.gif")."\" alt=\"".$list[$i]['mix_type']."\">'");
				echo option_selected_my("75",  $list[$i]['bl_width'], "piece-4-3", "data-content='<img src=\"".get_url($board_skin_url."/img/piece-4-3.gif")."\" alt=\"".$list[$i]['mix_type']."\">'");
				?>
			</select>
		</div>
	</li>
	<?php } ?>
</ul>

 <div class="_adm_btnSet">
	<input type="submit" value="순서 변경하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$('.frm_bl_ul li').hover(function() {
	var bl_id = $(this).attr('data-wr-id');
	opener.$('#section-'+bl_id).addClass('hover-marker');
}, function(){
	var bl_id = $(this).attr('data-wr-id');
	opener.$('#section-'+bl_id).removeClass('hover-marker');
});
$('.wr_use').change(function (){
	var wr_use = $(this).val(),
		wr_id = $(this).attr('data-wr-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_list_use_update.php",{bo_table:'<?=$bo_table?>', wr_use:wr_use, wr_id:wr_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
$('.ca_name').change(function (){
	var ca_name = $(this).val(),
		wr_id = $(this).attr('data-wr-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_list_cate_update.php",{bo_table:'<?=$bo_table?>', ca_name:ca_name, wr_id:wr_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
$('.bl_width').change(function (){
	var bl_width = $(this).val(),
		wr_id = $(this).attr('data-wr-id');
	$.post("<?=$board_skin_url?>/_list_bl_width_update.php",{bo_table:'<?=$bo_table?>', bl_width:bl_width, wr_id:wr_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
</script>